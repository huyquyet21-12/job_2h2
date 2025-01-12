<?php

namespace Database\Factories;

use App\Enums\UserRoleEnum;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'avatar'=> $this->faker->imageUrl(),
            'email'=> $this->faker->email,
            'password' => $this->faker->password,
            'phone'=> $this->faker->phoneNumber,
            'link' => null,
            'role'=> $this->faker->randomElement(UserRoleEnum::getValues()),
            'bio'=> $this->faker->boolean ? $this->faker->word : null,
            'position' => $this->faker->jobTitle,
            'gender'=> $this->faker->boolean,
            'city'=> $this->faker->city,
            'company_id' => Company::query()->inRandomOrder()->value('id'),
        ];
    }

    
}
