<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Booking;
use App\Models\ProviderService;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed database and set up necessary data
        $this->artisan('db:seed');
    }

    /** @test */
    public function it_can_create_a_booking()
    {
        $user = User::factory()->create();
        $service = ProviderService::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/bookings', [
            'provider_service_id' => $service->id,
            'booking_date' => Carbon::now()->toDateTimeString(),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', ['provider_service_id' => $service->id]);
    }

    /** @test */
    public function it_can_confirm_a_booking()
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create(['user_id' => $user->id, 'status' => 'pending']);

        $response = $this->actingAs($user)->postJson("/api/bookings/{$booking->id}/confirm");

        $response->assertStatus(200);
        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'status' => 'confirmed']);
    }

    /** @test */
    public function it_can_update_a_booking()
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->putJson("/api/bookings/{$booking->id}", [
            'booking_date' => Carbon::now()->addDay()->toDateTimeString(),
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('bookings', ['id' => $booking->id]);
    }

    /** @test */
    public function it_can_delete_a_booking()
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson("/api/bookings/{$booking->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
    }
}
