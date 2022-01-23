<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JournalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = $this->faker->randomElement(['event', 'gauge', 'text', 'text', 'text', 'text', 'text', 'text', 'text']);

        $subtype = $type === 'gauge' ? 'mood' : null;
        if($type === 'event') {
            $subtype = $this->faker->randomElement(['kleeblatt', 'geburtstag']);
        }

        return [
            'type' => $type,
            'subtype' => $subtype,
            'text' => $type === 'text' ? $this->faker->paragraphs(2, true) : null,
            'value' => $type === 'gauge' ? $this->faker->randomDigit() : null,
            'date' => $this->faker->dateTime
        ];
    }
}
