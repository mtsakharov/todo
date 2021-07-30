<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return TaskResource::collection($request->user()->tasks()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest $request
     * @return JsonResponse|object
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->all());

        return response()->json(new TaskResource($task))
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return TaskResource|JsonResponse|object
     */
    public function show(Task $task)
    {
        if (!$task) {
            return response()->json(['message' => 'Task not found'])
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return JsonResponse|object
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        if (!$task) {
            return response()->json(['message' => 'Task not found'])
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $task = $task->update($request->all());

        return response()->json(new TaskResource($task))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return JsonResponse|object
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['message' => 'Successfully deleted'])
            ->setStatusCode(Response::HTTP_OK);
    }
}
