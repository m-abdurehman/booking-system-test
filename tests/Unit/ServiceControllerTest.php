<?php

namespace Tests\Unit;

use App\Models\ProviderService;
use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /** @test */
    public function it_can_search_services_within_range()
    {
        $user = User::factory()->create();


        $service = ProviderService::factory()->create([
            'latitude' => 31.5497,
            'longitude' => 74.3436,
        ]);


        $response = $this->actingAs($user)->getJson('/api/services/search?latitude=31.5497&longitude=74.3436&range=25');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $service->id]);
    }

}
