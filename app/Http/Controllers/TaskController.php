<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of all tasks.
     * 
     * @retur \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Retrieve all tasks from the database
            $tasks = Task::all();

            // Return the view with the task data
            return view('tasks.index', compact('tasks'));
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error fetching tasks: ' . $e->getMessage());

            // Return an error view or redirect with an error message
            return redirect()->back()->with('error', 'Unable to retrieve tasks at this time.');
        }
    }

    /**
     * Return the task list as a JSON response (for AJAX).
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            // Retrieve all tasks
            $tasks = Task::all();

            // Render the task list view as a string
            $view = (string) view('tasks.list', compact('tasks'));

            // Return the view in a JSON response
            return response()->json([
                'data' => $view,
                'message' => 'Task list retrieved successfully',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error fetching task list: ' . $e->getMessage());

            // Return an error response
            return response()->json([
                'message' => 'Unable to retrieve task list',
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Store a newly created task in the database and communicate with the Python API.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:1000'
            ]);

            // Create a new task with validated data
            $task = Task::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'status' => 'pending',
            ]);

            // Send task data to the Python API for processing
            $response = Http::post(env('API_URL') . '/process-task', [
                'task_name' => $task->name,
            ]);

            // Fetch all tasks to update the task list view
            $tasks = Task::all();
            $view = (string) view('tasks.list', compact('tasks'));

            // Return success response with updated task list and API message
            return response()->json([
                'data' => $view,
                'message' => $response['message'] ?? 'Task processed successfully',
                'status' => 'success'
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 'error'
            ], 422);
        } catch (\Exception $e) {
            // Log any general errors
            Log::error('Error storing task: ' . $e->getMessage());

            // Return a generic error response
            return response()->json([
                'message' => 'An error occurred while creating the task',
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Mark the specified task as completed.
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsCompleted($id)
    {
        try {
            // Find the task by its ID, or throw a 404 error if not found
            $task = Task::findOrFail($id);

            // Update the task status to "completed"
            $task->status = 'completed';
            $task->save();

            // Fetch all tasks to update the task list view
            $tasks = Task::all();
            $view = (string) view('tasks.list', compact('tasks'));

            // Return a success response with the updated task list
            return response()->json([
                'data' => $view,
                'message' => 'Task marked as completed',
                'status' => 'success'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle case where the task ID doesn't exist
            return response()->json([
                'message' => 'Task not found',
                'status' => 'error'
            ], 404);
        } catch (\Exception $e) {
            // Log any general errors
            Log::error('Error marking task as completed: ' . $e->getMessage());

            // Return a generic error response
            return response()->json([
                'message' => 'An error occurred while marking the task as completed',
                'status' => 'error'
            ], 500);
        }
    }
}
