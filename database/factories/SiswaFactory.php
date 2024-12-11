<?php

namespace Database\Factories;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model=Siswa::class;
    public function definition(): array
    {
        return [
            'nisn' => fake()->numerify('########'),
            'nama' => fake()->name(),
            'jenis_kelamin' => fake()->randomElement(['l', 'p']),
            'alamat' => fake()->address(),
            'koordinat' => fake()->latitude() . ', ' . fake()->longitude(), // Koordinat geografis acak
        ];
    }
}
