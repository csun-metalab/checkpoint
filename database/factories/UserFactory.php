<?php

use function Opis\Closure\serialize;
use function Opis\Closure\unserialize;

use Faker\Generator as Faker;

// Models
use App\Models\Program;
use App\Models\Organization;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */



 $factory->define(App\User::class, function (Faker $faker) {
     return [
         'name' => $faker->name,
         'email' => $faker->unique()->email,
         'email_verified_at' => now(),
         'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
         'remember_token' => str_random(10),
         'organization_id' => Organization::all()->random()->id
     ];
 });
