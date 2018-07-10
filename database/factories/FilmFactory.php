<?php

use Faker\Generator as Faker;

$factory->define(App\Film::class, function (Faker $faker) {
    return [
        'Name'=>$faker->name(),
        'Description' => $faker->paragraph,
        'RealeaseDate'=>$faker->dateTime,
        'Rating'=>$faker->randomFloat(null,1,5),
        'TicketPrice'=>$faker->randomFloat(),
        'Country'=>$faker->country,
        'Genre' => $faker->address,
        'Slug' => $faker->slug(6,true),
        'Photo'=> $faker->imageUrl()
    ];
});
