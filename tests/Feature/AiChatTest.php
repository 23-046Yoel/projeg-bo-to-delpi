<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AiBotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Mockery\MockInterface;

class AiChatTest extends TestCase
{
    public function test_chatbot_can_respond_successfully()
    {
        $user = User::factory()->create();

        // Mock the AiBotService to avoid real API calls
        $this->mock(AiBotService::class, function (MockInterface $mock) {
            $mock->shouldReceive('generateResponse')
                ->once()
                ->andReturn('Halo! Ada yang bisa saya bantu?');
        });

        $response = $this->actingAs($user)
            ->postJson('/chat/query', [
                'message' => 'Halo'
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'reply' => 'Halo! Ada yang bisa saya bantu?'
            ]);
    }

    public function test_chatbot_requires_message()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/chat/query', []);

        $response->assertStatus(422);
    }
}
