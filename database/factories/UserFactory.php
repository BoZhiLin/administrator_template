<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Defined\GenderDefined;
use App\Models\User;
use App\Tools\Tool;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = GenderDefined::all()[rand(0, 2)];
        $birthday = $this->faker->date;

        return [
            'name' => $this->faker->name,
            'nickname' => $this->faker->name,
            'birthday' => $birthday,
            'age' => Tool::getAge($birthday),
            'constellation' => Tool::getConstellation($birthday),
            'gender' => $gender,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => null,
            'is_verified' => false,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }
}
