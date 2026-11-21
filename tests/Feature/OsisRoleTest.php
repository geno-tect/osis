<?php

namespace Tests\Feature;

use App\Models\Osis;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OsisRoleTest extends TestCase
{
    use RefreshDatabase;

    private function anggota(): Osis
    {
        return Osis::create([
            'id_osis' => 'OSIS-1',
            'nama' => 'Anggota Uji',
            'kelas' => 'XI',
            'jurusan' => 'RPL',
            'sekbid' => 'Sekbid 1',
        ]);
    }

    public function test_guest_can_view_member_list(): void
    {
        $this->anggota();

        $this->get('/osis')
            ->assertOk()
            ->assertSee('Anggota Uji')
            ->assertDontSee('Tambah anggota')
            ->assertDontSee('Edit')
            ->assertDontSee('Hapus')
            ->assertDontSee('Login Admin')
            ->assertDontSee('Keluar');
    }

    public function test_guest_is_redirected_from_management_routes(): void
    {
        $this->get('/osis/create')->assertRedirect(route('login', absolute: false));

        $this->post('/osis', [
            'id_osis' => 'OSIS-2',
            'nama' => 'Anggota Baru',
            'kelas' => 'X',
            'jurusan' => 'RPL',
            'sekbid' => 'Sekbid 2',
        ])->assertRedirect(route('login', absolute: false));

        $this->put('/osis/1', [
            'id_osis' => 'OSIS-1',
            'nama' => 'Diubah',
            'kelas' => 'XII',
            'jurusan' => 'RPL',
            'sekbid' => 'Sekbid 1',
        ])->assertRedirect(route('login', absolute: false));

        $this->delete('/osis/1')->assertRedirect(route('login', absolute: false));
    }

    public function test_admin_dashboard_shows_management_controls(): void
    {
        $admin = User::factory()->admin()->create();
        $this->anggota();

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Dashboard admin')
            ->assertSee('Tambah anggota')
            ->assertSee('Hapus');
    }

    public function test_user_is_redirected_away_from_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertRedirect('/osis');
    }

    public function test_admin_sees_member_management_links(): void
    {
        $admin = User::factory()->admin()->create();
        $this->anggota();

        $this->actingAs($admin)
            ->get('/osis')
            ->assertOk()
            ->assertSee('Tambah anggota')
            ->assertSee('Edit')
            ->assertSee('Hapus');
    }

    public function test_user_sees_read_only_member_list(): void
    {
        $user = User::factory()->create();
        $this->anggota();

        $this->actingAs($user)
            ->get('/osis')
            ->assertOk()
            ->assertSee('Anggota Uji')
            ->assertDontSee('Tambah anggota')
            ->assertDontSee('Edit')
            ->assertDontSee('Hapus');
    }

    public function test_user_cannot_open_create_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/osis/create')
            ->assertForbidden()
            ->assertSee('Akses ditolak');
    }

    public function test_user_cannot_store_member(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/osis', [
                'id_osis' => 'OSIS-2',
                'nama' => 'Anggota Baru',
                'kelas' => 'X',
                'jurusan' => 'RPL',
                'sekbid' => 'Sekbid 2',
            ])
            ->assertForbidden();

        $this->assertDatabaseCount('osis', 0);
    }

    public function test_user_cannot_update_member(): void
    {
        $user = User::factory()->create();
        $anggota = $this->anggota();

        $this->actingAs($user)
            ->put("/osis/{$anggota->id}", [
                'id_osis' => 'OSIS-1',
                'nama' => 'Diubah',
                'kelas' => 'XII',
                'jurusan' => 'RPL',
                'sekbid' => 'Sekbid 1',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('osis', [
            'id' => $anggota->id,
            'nama' => 'Anggota Uji',
        ]);
    }

    public function test_admin_can_delete_member_from_dashboard(): void
    {
        $admin = User::factory()->admin()->create();
        $anggota = $this->anggota();

        $this->actingAs($admin)
            ->from('/dashboard')
            ->delete("/osis/{$anggota->id}")
            ->assertRedirect('/dashboard')
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('osis', ['id' => $anggota->id]);
    }

    public function test_user_cannot_delete_member(): void
    {
        $user = User::factory()->create();
        $anggota = $this->anggota();

        $this->actingAs($user)
            ->delete("/osis/{$anggota->id}")
            ->assertForbidden();

        $this->assertDatabaseHas('osis', ['id' => $anggota->id]);
    }
}
