<?php
namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and issue a token
        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
    }

    public function testIndex()
    {
        // Create an employee
        $employee = Employee::factory()->create();

        // Make a GET request to the index route
        $response = $this->getJson('/api/employees');

        // Assert the response status and data
        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => $employee->name,
                     'email' => $employee->email,
                 ]);
    }

    public function testStore()
    {
        // Define employee data
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Developer',
            'salary' => 60000,
        ];

        // Make a POST request to the store route
        $response = $this->postJson('/api/employees', $data);

        // Assert the response status and data
        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        // Assert the employee was created
        $this->assertDatabaseHas('employees', $data);
    }

    public function testShow()
    {
        // Create an employee
        $employee = Employee::factory()->create();

        // Make a GET request to the show route
        $response = $this->getJson("/api/employees/{$employee->id}");

        // Assert the response status and data
        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => $employee->name,
                     'email' => $employee->email,
                 ]);
    }

    public function testUpdate()
    {
        // Create an employee
        $employee = Employee::factory()->create();

        // Define updated data
        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'position' => 'Manager',
            'salary' => 70000,
        ];

        // Make a PUT request to the update route
        $response = $this->putJson("/api/employees/{$employee->id}", $data);

        // Assert the response status and data
        $response->assertStatus(200)
                 ->assertJsonFragment($data);

        // Assert the employee was updated
        $this->assertDatabaseHas('employees', $data);
    }

    public function testDestroy()
    {
        // Create an employee
        $employee = Employee::factory()->create();

        // Make a DELETE request to the destroy route
        $response = $this->deleteJson("/api/employees/{$employee->id}");

        // Assert the response status
        $response->assertStatus(204);

        // Assert the employee was deleted
        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    }
}
