<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_shows_the_public_landing_page(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Dari ide siswa,')
            ->assertSee('Daftar Anggota OSIS');
    }
}
