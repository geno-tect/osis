<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AspirasiTest extends TestCase
{
    use RefreshDatabase;

    private function validData(): array
    {
        return [
            'kategori' => 'Fasilitas',
            'pesan' => 'Mohon tambah tempat sampah di koridor lantai dua agar kelas tetap bersih.',
            'nama' => '',
        ];
    }

    public function test_guest_can_open_aspiration_form(): void
    {
        $this->get('/aspirasi')
            ->assertOk()
            ->assertSee('Kirim aspirasi')
            ->assertSee('Sebelum mengirim');
    }

    public function test_guest_can_submit_aspiration(): void
    {
        $data = $this->validData();
        $data['nama'] = 'Siswa Uji';

        $this->post('/aspirasi', $data)
            ->assertRedirect('/aspirasi')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('aspirasi', [
            'kategori' => 'Fasilitas',
            'pesan' => $data['pesan'],
            'nama' => 'Siswa Uji',
        ]);
    }

    public function test_aspiration_can_be_sent_without_name(): void
    {
        $this->post('/aspirasi', $this->validData())
            ->assertRedirect('/aspirasi')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('aspirasi', [
            'kategori' => 'Fasilitas',
            'nama' => null,
        ]);
    }

    public function test_category_and_message_are_required(): void
    {
        $this->post('/aspirasi', [
            'kategori' => '',
            'pesan' => '',
        ])
            ->assertSessionHasErrors(['kategori', 'pesan']);

        $this->assertDatabaseCount('aspirasi', 0);
    }

    public function test_message_has_minimum_length(): void
    {
        $this->post('/aspirasi', [
            'kategori' => 'Akademik',
            'pesan' => 'Terlalu singkat.',
        ])->assertSessionHasErrors('pesan');

        $this->assertDatabaseCount('aspirasi', 0);
    }

    public function test_category_must_be_available(): void
    {
        $this->post('/aspirasi', [
            'kategori' => 'Kategori Palsu',
            'pesan' => 'Mohon tambah tempat sampah di koridor lantai dua agar kelas tetap bersih.',
        ])->assertSessionHasErrors('kategori');

        $this->assertDatabaseCount('aspirasi', 0);
    }
}
