<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BerandaTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_has_real_section_targets(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('id="tentang"', false)
            ->assertSee('id="struktur"', false)
            ->assertSee('id="anggota"', false)
            ->assertSee('id="berita"', false)
            ->assertSee('id="aspirasi"', false)
            ->assertSee('href="'.route('aspirasi.index').'"', false);
    }

    public function test_article_page_can_be_opened(): void
    {
        $this->get('/berita/class-meeting-satu-pekan-satu-cerita')
            ->assertOk()
            ->assertSee('Class meeting: satu pekan, satu cerita');
    }

    public function test_unknown_article_returns_not_found(): void
    {
        $this->get('/berita/artikel-yang-tidak-ada')->assertNotFound();
    }
}
