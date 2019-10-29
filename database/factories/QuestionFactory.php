<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Question;
use App\User;
use App\Model\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Question::class, function (Faker $faker) {
    $title = $faker->sentence(5);

    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'body' => $faker->text(200),
        'user_id' => function() {
            return User::all()->random();
        },
        'category_id' => function() {
            return Category::all()->random();
        }
    ];
});
