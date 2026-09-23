<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_sent_to_the_login_page(): void
    {
        $this->get(route('tasks.index'))
            ->assertRedirect(route('login'));
    }

    public function test_users_can_log_in_and_log_out(): void
    {
        $user = User::factory()->create();

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('tasks.index'));

        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_guests_can_register_and_are_logged_in(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Create an account');

        $this->post(route('register.store'), [
            'name' => 'Alex Morgan',
            'email' => 'alex@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ])->assertRedirect(route('tasks.index'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'Alex Morgan',
            'email' => 'alex@example.com',
        ]);
    }

    public function test_tasks_can_be_created_and_viewed(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('tasks.create'))
            ->assertRedirect(route('tasks.index'));

        $response = $this->post(route('tasks.store'), [
            'task_name' => 'Prepare weekly report',
            'description' => 'Summarize this week\'s progress.',
            'status' => 'Pending',
            'due_date' => '2026-09-30',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'task_name' => 'Prepare weekly report',
            'status' => 'Pending',
        ]);

        $this->get(route('tasks.index'))
            ->assertOk()
            ->assertSee('Prepare weekly report');
    }

    public function test_tasks_can_be_updated_status_toggled_and_deleted(): void
    {
        $this->actingAs(User::factory()->create());

        $task = Task::create([
            'task_name' => 'Draft presentation',
            'description' => 'Add the final slides.',
            'status' => 'Pending',
            'due_date' => '2026-10-01',
        ]);

        $this->put(route('tasks.update', $task), [
            'task_name' => 'Finish presentation',
            'description' => 'Add the final slides and review them.',
            'status' => 'Completed',
            'due_date' => '2026-10-02',
        ])->assertRedirect(route('tasks.index'));

        $task->refresh();
        $this->assertSame('Completed', $task->status);
        $this->assertSame('Finish presentation', $task->task_name);

        $this->patch(route('tasks.status', $task))
            ->assertRedirect(route('tasks.index'));
        $this->assertSame('Pending', $task->fresh()->status);

        $this->delete(route('tasks.destroy', $task))
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);

    }
}
