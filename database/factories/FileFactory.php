<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * The name of de factory corresponding model
     */
    protected $model = File::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->unique()->uuid(),
            'name' => $this->faker->word . '.mp4',
            'path' => 'files/abc.mp4',
            'size' => 5000
        ];
    }
}
