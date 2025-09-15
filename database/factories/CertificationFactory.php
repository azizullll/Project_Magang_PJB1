<?php

namespace Database\Factories;

use App\Models\Certification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Certification>
 */
class CertificationFactory extends Factory
{
    protected $model = Certification::class;

    public function definition(): array
    {
        $code = strtoupper($this->faker->bothify('??###'));
        return [
            'code' => $code,
            'name' => $this->faker->randomElement([
                'K3 Umum', 'Audit Internal', 'PMI-ACP', 'ISO 9001', 'ITIL Foundation', 'CM001', 'CA100'
            ]),
        ];
    }
}


