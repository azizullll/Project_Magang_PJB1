<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $years = $this->faker->numberBetween(0, 20);
        $level = $years >= 10 ? 'Ahli Madya' : ($years >= 6 ? 'Ahli Muda' : ($years >= 3 ? 'Terampil' : 'Pemula'));

        return [
            'nip' => (string) $this->faker->unique()->numerify('########'),
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'jabatan' => $this->faker->randomElement(['Staff', 'Supervisor', 'Engineer', 'Manager', 'Koordinator']),
            'divisi' => $this->faker->randomElement(['IT', 'HR', 'Operasional', 'Keuangan', 'Pemasaran', 'Produksi']),
            'masa_kerja_tahun' => $years,
            'level_kompetensi' => $level,
            'foto_path' => null,
        ];
    }
}


