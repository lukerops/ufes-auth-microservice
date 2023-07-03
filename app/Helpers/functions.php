<?php

use App\Enums\SupportStatus;

if (!function_exists('getStatusSupport')) {
    function getStatusSupport(string $status): string {
        return SupportStatus::fromValue($status);
    }
}

if (!function_exists('getRandomRegistration')) {
    function getRandomRegistration(): string {
        $faker = Faker\Factory::create();
        return $faker->unique()->numerify('##########');
    }
}
