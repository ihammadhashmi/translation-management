<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_translation()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/translations', [
            'locale' => 'en',
            'key' => 'greeting',
            'content' => 'Hello!',
            'tags' => ['web', 'mobile']
        ]);

        $response->assertStatus(201);
    }

    public function test_authenticated_user_can_export_translations()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson('/api/export');

        $response->assertStatus(200);
    }

    public function test_export_endpoint_performance()
    {
        Sanctum::actingAs(User::factory()->create());

        $start = microtime(true);

        $response = $this->getJson('/api/export');

        $duration = (microtime(true) - $start) * 1000;

        $response->assertStatus(200);
        $this->assertLessThan(500, $duration, 'Export API exceeded 500ms.');
    }
}
