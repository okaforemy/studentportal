<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'surname'=> $this->faker->lastName(),
            'othernames'=>$this->faker->firstName(),
            'fullname'=>$this->faker->name(),
            'dob'=>$this->faker->dateTimeThisCentury->format('Y-m-d'),
            'sex'=>'male',
            'student_id'=>$this->faker->uuid(),
            'grade'=>'Primary 2',
            'reg_progress'=>'50',
            'arm'=>''
        ];
    }
}
