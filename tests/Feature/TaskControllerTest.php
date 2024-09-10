<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if tasks can be listed.
     *
     * @return void
     */
    public function test_tasks_can_be_listed()
    {
        // Arrange: Create some tasks in the database
        Task::factory()->count(3)->create();

        // Act: Make a GET request to the task listing route
        $response = $this->get('/tasks');

        // Assert: Ensure the tasks are returned in the response
        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');
        $response->assertViewHas('tasks');
    }

    /**
     * Test if a task can be created.
     *
     * @return void
     */
    public function test_task_can_be_created()
    {
        // Arrange: Prepare task data
        $taskData = [
            'name' => 'New Task',
            'description' => 'This is a test task',
        ];

        // Act: Make a POST request to the task creation route
        $response = $this->post('/tasks', $taskData);

        // Assert: Ensure the task was created and response is JSON
        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['name' => 'New Task']);
    }

    /**
     * Test if a task can be marked as completed.
     *
     * @return void
     */
    public function test_task_can_be_marked_as_completed()
    {
        // Arrange: Create a new task
        $task = Task::factory()->create(['status' => 'pending']);

        // Act: Make a PUT request to mark the task as completed
        $response = $this->put("/tasks/{$task->id}/complete");

        // Assert: Ensure the task status is updated
        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'completed']);
    }
}
