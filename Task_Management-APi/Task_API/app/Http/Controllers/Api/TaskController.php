<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\Base\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Task\TaskCollection;
use App\Http\Resources\Task\TaskResource;
use Illuminate\Http\JsonResponse;
use App\Models\Task;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends BaseApiController
{
    Use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;

    //Get all Task
    public function index(): JsonResponse
    {
        try{
            $tasks = Auth::user()->tasks()->latest()->paginate(10);
            return $this->success(new TaskCollection($tasks), 'Task fetched successfully');
        }catch(\Throwable $e){
            return $this->error('Failed to fetch Tasks', 500, $e);
        }
    }
    //Create Task
    public function store(StoreTaskRequest $request):  JsonResponse{
        try{
            $task = Auth::user()->tasks()->create($request->validated());
            return $this->success(new TaskResource($task), 'Task Created Successfully', 201);
        }catch(\Throwable $e){
            return $this->error('Failed to create Tasks', 500, $e);
        }
    }
    //Read single Task by Id
    public function show(Task $task): JsonResponse{
        try {
            $this->authorize('view', $task);
            return $this->success(new TaskResource($task), 'Task details retrieved');
        } catch(\Throwable $e) {
             return $this->error('Failed to retrieve task', 500, $e);
        }
    }
    //update Task
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse{
        try {
            $this->authorize('update', $task);
            $task->update($request->validated());
            return $this->success(new TaskResource($task), 'Task Updated successfully');
        } catch (\Throwable $e) {
            return $this->error ('Failed to update task', 500, $e);
        }
    }
    //Destroy Rask or Soft Delete Task
    public function destroy(Task $task): JsonResponse {
        try {
            $this->authorize('delete', $task);
            $task->delete();
            return $this->success(null, 'Task Deleted successfully');
        }catch(\Throwable $e) {
           return $this->error ('Failed to delete Task', 500, $e); 
        }
    }
    //Restore Task
    public function restore($id): JsonResponse{
        try {
            $task = Task::withTrashed()->findOrFail($id);
            $this->authorize('restore', $task);
            $task->restore();
            return $this->success(new TaskResource($task), 'Task Restored Successfully');
        } Catch(\Throwable $e) {
            return $this->error('Failed to restore task', 500, $e);
        }
    }
    //ForceDelete Task
    public function forceDelete($id): JsonResponse{
        try {
           $task = Task::withTrashed()->findOrFail($id);
           $this->authorize('forceDelete', $task);
           $task->forceDelete();
           return $this->success(null, 'Task permanently deleted ');
        } catch(\Throwable $e) {
            return $this->error('Task deleted from Trash', 500, $e);
        }
    }
    //TaskFilter By Id
    public function TaskFilter(Request $request): JsonResponse{
        $request->validate([
            'status' => 'required|in:new,in_progress,completed,canceled',
        ]);

        try{
           $tasks = Auth::user()->tasks()
           ->where('status', $request->status)
           ->latest()
           ->paginate(10);
           return $this->success(new TaskCollection($tasks), 'Filtered Task Successfully');
        } catch (\Throwable $e) {
            return $this->error('Failed to filter Tasks', 500, $e);
        }
    }
    //StatusUpdate
    public function updateStatus(Request $request, Task $task): JsonResponse{
        $request->validate([
            'status' => 'required|in:new,in_progress,completed,canceled',
        ]);
        try {
            $this->authorize('update', $task);
            $task->status = $request->status;
            $task->save();

            return $this->success(new TaskResource($task), 'Task status updated');
        } catch(\Throwable $e) {
            return $this->error('Failed to update task status', 500, $e);
        }
    }

     // Get Summary
    public function summary(): JsonResponse
    {
        try {
            $user = Auth::user();

            $summary = $user->tasks()
                ->selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status');

            // Ensure all statuses are present, even if 0
            $allStatuses = ['new', 'in_progress', 'completed', 'canceled'];
            $finalSummary = [];

            foreach ($allStatuses as $status) {
                $finalSummary[$status] = $summary[$status] ?? 0;
            }

            return $this->success($finalSummary, 'Task summary fetched successfully');
        } catch (\Throwable $e) {
            return $this->error('Failed to load task summary', 500, $e);
        }
    }

    // Get Trashed Tasks
    public function trashed(): JsonResponse
    {
        
        try {
            $user = Auth::user();
            $tasks = $user->tasks()
                ->onlyTrashed()
                ->latest()
                ->paginate(10);

            return $this->success(new TaskCollection($tasks), 'Trashed tasks fetched successfully');
        } catch (\Throwable $e) {
            return $this->error('Failed to fetch trashed tasks', 500, $e);
        }
    }
}    
