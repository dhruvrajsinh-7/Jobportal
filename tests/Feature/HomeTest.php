<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testhomepage(): void
    {
        $response = $this->get(route('jobs.index'));

        $response->assertStatus(200);
    }
}
