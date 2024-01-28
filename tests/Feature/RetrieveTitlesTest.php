<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetrieveTitlesTest extends TestCase
{
    /**
     * A basic feature to retrieve titles.
     *
     * @return void
     */
    public function test_get_titles_from_all_services_successfully()
    {
        $response = $this->get('/api/titles');
        $response->assertStatus(200);
    }
}
