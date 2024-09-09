<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\taskService;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Trait\ApiResponseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaskController extends Controller
{   
    protected $taskService;
    use ApiResponseTrait;
    public function __construct(taskService $taskService)
    {
        $this->taskService = $taskService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $tasks = $this->taskService->getAllTasks($request);
            return $this->successResponse($tasks, 'bring all tasks successfully.', 200);
        } catch (\Exception $e) {
            return $this->handleException($e, ' error with bring all tasks.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        
        try{
            $validatedRequest=$request->validated();
            $task=$this->taskService->storetask($validatedRequest);
            return $this->successResponse($task,'the task stored successfuly',201);
        }catch(\Exception $e){
            return $this->handleException($e, ' error with stored the task',);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
        
            $task=$this->taskService->showTask($id);
            return $this->successResponse($task,'the task has been showing successfuly',200);
        }catch(\Exception $e){
         return $this->handleException($e,'error with showing the task');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        try{
            if(!$task->exists){
                return $this->notFound('the task not found');
            }
            $validated=$request->validated();
            $updatedTask=$this->taskService->updateTask($task,$validated);
           return $this->successResponse($updatedTask,'the task updated successfuly',200);
        }catch(\Exception $e){
            return $this->handleException($e,'error with updating task');
    
        }
    }
    public function update_assigned_to(TaskRequest $request, Task $task)
    {
        try{
            if(!$task->exists){
                return $this->notFound('the task not found');
            }
            $validated=$request->validated();
            $updatedTask=$this->taskService->update_assigned_to($task,$validated);
           return $this->successResponse($updatedTask,'the task updated successfuly',200);
        }catch(\Exception $e){
            return $this->handleException($e,'error with updating task');
    
        }
    }
/**
     * Remove the one object from storage.
     */
    public function destroy(string $id):JsonResponse
    {
         try {
            $this->taskService->deletetask($id);
            return $this->successResponse([], 'the book deleted successfully.', 200);
        } catch (\Exception $e) {
            return $this->handleException($e, 'error with deleting the book');
        }
    }
    /**
     * Handle exceptions and show a response.
     */
    protected function handleException(\Exception $e, string $message): JsonResponse
    {
        // Log the error with additional context if needed
        Log::error($message, ['exception' => $e->getMessage(), 'request' => request()->all()]);

        return $this->errorResponse($message, [$e->getMessage()], 500);
    }
}

