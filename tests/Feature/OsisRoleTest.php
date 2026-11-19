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

    public function test_admin_dashboard_shows_management_controls(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Dashboard admin')
            ->assertSee('Tambah anggota');
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
            ->assertSee('Edit');
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
            ->assertDontSee('Edit');
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
}
