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
            'sekbid' => 'Akademik',
        ]);
    }

    public function test_guest_sees_members_on_landing_page(): void
    {
        $this->anggota();

        $this->get('/')
            ->assertOk()
            ->assertSee('Daftar Anggota OSIS')
            ->assertSee('Anggota Uji')
            ->assertSee('OSIS-1')
            ->assertDontSee('Tambah anggota')
            ->assertDontSee('Edit')
            ->assertDontSee('Hapus')
            ->assertDontSee('Login Admin')
            ->assertDontSee('Keluar');
    }

    public function test_old_member_list_redirects_to_landing_page(): void
    {
        $this->get('/osis')->assertRedirect('/#anggota');
    }

    public function test_guest_is_redirected_from_management_routes(): void
    {
        $this->get('/osis/create')->assertRedirect(route('login', absolute: false));

        $this->post('/osis', [
            'id_osis' => 'OSIS-2',
            'nama' => 'Anggota Baru',
            'kelas' => 'X',
            'jurusan' => 'RPL',
            'sekbid' => 'Seni',
        ])->assertRedirect(route('login', absolute: false));

        $this->put('/osis/1', [
            'id_osis' => 'OSIS-1',
            'nama' => 'Diubah',
            'kelas' => 'XII',
            'jurusan' => 'RPL',
            'sekbid' => 'Akademik',
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
            ->assertSee('Anggota Uji')
            ->assertSee('Tambah anggota')
            ->assertSee('Edit')
            ->assertSee('Hapus');
    }

    public function test_user_is_redirected_away_from_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertRedirect('/');
    }

    public function test_admin_dashboard_lists_all_members(): void
    {
        $admin = User::factory()->admin()->create();

        for ($i = 1; $i <= 6; $i++) {
            Osis::create([
                'id_osis' => 'OSIS-'.$i,
                'nama' => 'Anggota '.$i,
                'kelas' => 'XI',
                'jurusan' => 'RPL',
                'sekbid' => 'Akademik',
            ]);
        }

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Anggota 1')
            ->assertSee('Anggota 6')
            ->assertSee('Tambah anggota')
            ->assertSee('Edit')
            ->assertSee('Hapus');
    }

    public function test_non_admin_sees_read_only_members_on_landing_page(): void
    {
        $user = User::factory()->create();
        $this->anggota();

        $this->actingAs($user)
            ->get('/')
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
                'sekbid' => 'Seni',
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
                'sekbid' => 'Akademik',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('osis', [
            'id' => $anggota->id,
            'nama' => 'Anggota Uji',
        ]);
    }

    public function test_admin_can_store_member(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/osis', [
                'id_osis' => 'OSIS-2',
                'nama' => 'Anggota Baru',
                'kelas' => 'X',
                'jurusan' => 'RPL',
                'sekbid' => 'Seni',
            ])
            ->assertRedirect('/dashboard')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('osis', [
            'id_osis' => 'OSIS-2',
            'nama' => 'Anggota Baru',
        ]);
    }

    public function test_create_form_lists_sekbid_options(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/osis/create')
            ->assertOk()
            ->assertSee('Keagamaan')
            ->assertSee('Kesehatan');
    }

    public function test_admin_must_choose_a_valid_sekbid(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from('/osis/create')
            ->post('/osis', [
                'id_osis' => 'OSIS-3',
                'nama' => 'Anggota Baru',
                'kelas' => 'X',
                'jurusan' => 'RPL',
                'sekbid' => 'Sekbid Palsu',
            ])
            ->assertSessionHasErrors('sekbid');

        $this->assertDatabaseMissing('osis', ['id_osis' => 'OSIS-3']);
    }

    public function test_admin_can_update_member(): void
    {
        $admin = User::factory()->admin()->create();
        $anggota = $this->anggota();

        $this->actingAs($admin)
            ->put("/osis/{$anggota->id}", [
                'id_osis' => 'OSIS-1',
                'nama' => 'Anggota Diubah',
                'kelas' => 'XII',
                'jurusan' => 'RPL',
                'sekbid' => 'Akademik',
            ])
            ->assertRedirect('/dashboard')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('osis', [
            'id' => $anggota->id,
            'nama' => 'Anggota Diubah',
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
