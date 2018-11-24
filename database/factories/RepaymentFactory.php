<?php

namespace App;

use Faker\Generator as Faker;

$factory->define(Repayment::class, function (Faker $faker) {
    return [
        'loan_id'=>rand(1,15),
        'repayment_amount'=>rand(1000, 10000),
        'repayment_amount'=>rand(1,120)
    ];
});
