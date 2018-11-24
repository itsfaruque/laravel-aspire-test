<?php

namespace App;

use Faker\Generator as Faker;

$factory->define(Loan::class, function (Faker $faker) {
    return [
        'user_id'=>rand(1,5),
        'amount'=>rand(10000, 100000),
        'duration'=>rand(12,120),
        'repayment_frequency'=>'monthly',
        'interest_rate'=>rand(1,10),
        'arrangement_fee'=>rand(1000, 10000),
        'status'=>'processing'
    ];
});
