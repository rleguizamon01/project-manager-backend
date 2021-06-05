<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_name' => $this->faker->word(), 
            'description' => $this->faker->text(),
            'manager_id' => User::factory(),
            'assigned_id' => User::factory(),
            'enabled' => $this->faker->boolean(),
        ];
    }
}
