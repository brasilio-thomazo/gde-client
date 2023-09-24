<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $fake = fake('pt_BR');
        return [
            'code' => Str::random(8),
            'identity' => $fake->cnpj(false),
            'name' => $fake->name(),
            'comment' => $fake->text(),
            'storage' => Str::random(5),
            'doc_date' => $fake->dateTimeThisYear()->format('Y-m-d')
        ];
    }
}
