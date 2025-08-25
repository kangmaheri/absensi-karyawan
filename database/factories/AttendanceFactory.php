<?php
// database/factories/AttendanceFactory.php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'employee_id' => Employee::factory(), // otomatis buat karyawan
            'check_in'    => now(),
            'check_out'   => null,
            'status'      => $this->faker->randomElement(['Present','Permission','Sick','Absent']),
        ];
    }
}
