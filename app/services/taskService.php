<?php

namespace App\Services;

use App\Models\task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;

class taskService
{
    /*
     * @param Request $request
     * @return array containing detials about task resources.
     */
    public function getAllTasks(Request $request): array
    {
        // query for the task with rating
        $query = Task::with('user');
        // Paginate the results
        $tasks = $query->paginate(10);

        // Return the paginated task wrapped in a taskResource collection
        return TaskResource::$tasks->toArray(request());
    }

    /**
     * Store a new task
     * @param array <array> containing 'title', 'user_id', 'description', 'due_date'.
     * @return array containing the created task resource.
     * @throws \Exception
     * Throws an exception if the task creation fails*/
    public function storetask(array $data): array
    {
        // Create a new task
        $task = task::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'priority' => $data['priority'],
            'assigned_to' => $data['assigned_to'],
            'due_date' => $data['due_date'],
            
         
        ]);

        // Check if the task was created successfully
        if (!$task) {
            throw new \Exception('Failed to create the task.');
        }

        // Return the created task as a resource
        return taskResource::make($task)->toArray(request());
    }

    /**
     * Retrieve a specific task by its ID.
     * 
     * @param int $id
     * The ID of the task to retrieve.
     * 
     * @return array
     * An array containing the task resource.
     * 
     * @throws \Exception
     * Throws an exception if the task is not found.
     */
    public function showTask(int $id): array
    {
        // Find the task by ID
        $task = task::find($id);

        // If no task is found, throw an exception
        if (!$task) {
            throw new \Exception('task not found.');
        }

        // Return the found task as a resource
        return taskResource::make($task)->toArray(request());
    }

    /**
     * Update an existing task.
     * 
     * @param task $task
     * The task model instance to update.
     * @param array $data
     * An associative array containing the fields to update (title, athor, description, published_at).
     * 
     * @return array
     * An array containing the updated task resource.
     */
    public function updatetask(task $task, array $data): array
    {
        // Update only the fields that are provided in the data array
        $task->update(array_filter([
            'title' => $data['title'] ?? $task->title,
            'description' => $data['description'] ?? $task->description,
            'status' => $data['status'] ?? $task->status,
            'priority' => $data['priority'] ?? $task->priority,
            'due_date' => $data['due_date'] ?? $task->due_date,
            'assigned_to' => $data['assigned_to'] ?? $task-> assigned_to,

        ]));
         // Return the updated task as a resource
         return taskResource::make($task)->toArray(request());
        }

        public function update_assigned_to(task $task, array $data): array
    {
        // Update only the fields that are provided in the data array
        $task->update(array_filter([
            // 'title' => $data['title'] ?? $task->title,
            // 'description' => $data['description'] ?? $task->description,
            // 'status' => $data['status'] ?? $task->status,
            // 'priority' => $data['priority'] ?? $task->priority,
            // 'due_date' => $data['due_date'] ?? $task->due_date,
            'assigned_to' => $data['assigned_to'] ?? $task-> assigned_to,

        ]));

        // Return the updated task as a resource
        return taskResource::make($task)->toArray(request());
    }

    /**
     * Delete a task by its ID.
     * 
     * @param int $id
     * The ID of the task to delete.
     * 
     * @return void
     * 
     * @throws \Exception
     * Throws an exception if the task is not found.
     */
    public function deletetask(int $id): void
    {
        // Find the task by ID
        $task = task::find($id);

        // If no task is found, throw an exception
        if (!$task) {
            throw new \Exception('task not found.');
        }

        // Delete the task
        $task->delete();
    }
}
