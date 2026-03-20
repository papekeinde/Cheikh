<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => 'Cheikh Keinde',
            'slogan' => 'Développeur Full-Stack',
            'description' => 'Développeur Full-Stack passionné, spécialisé en Laravel, Vue.js, C# .NET et solutions web modernes.',
            'photo' => 'default-avatar.jpg',
            'tel1' => '772756581',
            'tel2' => '+1(438) 465-8983',
            'email' => 'pkeinde6@gmail.com',
            'password' => 'password',
            'adresse' => 'Dakar, Sénégal',
            'poste' => 'Full-Stack Developer',
            'link' => fake()->url(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
