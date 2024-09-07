<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\ProviderService;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'provider_service_id' => ProviderService::factory(),
            'booking_date' => $this->faker->dateTime,
            'status' => 'pending',
        ];
    }
}
