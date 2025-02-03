<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Patient;
use Illuminate\Validation\ValidationException;


class PatientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba la creación de un paciente.
     *
     * @return void
     */
    public function testPatientCreation()
    {
        $patient = Patient::create([
            'name' => 'John',
            'last_name' => 'Doe',
            'birth_date' => '1990-01-01',
            'age' => '30',
            'contacto' => '123-456-7890',
            'email' => 'john@example.com'
        ]);

        $this->assertDatabaseHas('patients', [
            'name' => 'John',
            'last_name' => 'Doe'
        ]);

        $this->assertEquals('John', $patient->name);
        $this->assertEquals('Doe', $patient->last_name);
    }

    /**
     * Prueba la validación de los datos del paciente.
     *
     * @return void
     */
    public function testPatientValidation()
    {
        $this->expectException(ValidationException::class);

        Patient::create([
            'name' => '', // Name is required
            'last_name' => 'Doe',
            'birth_date' => '1990-01-01',
            'age' => '30',
            'contacto' => '123-456-7890',
            'email' => 'john@example.com'
        ]);
    }

    /**
     * Prueba la actualización de un paciente.
     *
     * @return void
     */
    public function testPatientUpdate()
    {
        $patient = Patient::create([
            'name' => 'John',
            'last_name' => 'Doe',
            'birth_date' => '1990-01-01',
            'age' => '30',
            'contacto' => '123-456-7890',
            'email' => 'john@example.com'
        ]);

        $patient->update([
            'name' => 'Jane',
            'last_name' => 'Smith'
        ]);

        $this->assertDatabaseHas('patients', [
            'name' => 'Jane',
            'last_name' => 'Smith'
        ]);
    }

    /**
     * Prueba la eliminación de un paciente.
     *
     * @return void
     */
    public function testPatientDeletion()
    {
        $patient = Patient::create([
            'name' => 'John',
            'last_name' => 'Doe',
            'birth_date' => '1990-01-01',
            'age' => '30',
            'contacto' => '123-456-7890',
            'email' => 'john@example.com'
        ]);

        $patient->delete();

        $this->assertDatabaseMissing('patients', [
            'name' => 'John',
            'last_name' => 'Doe'
        ]);
    }
}
