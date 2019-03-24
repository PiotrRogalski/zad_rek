<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskUserResource;
use App\Model\Task;
use App\Model\TaskUser;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class TaskUserController extends Controller
{
    /**
     * Get all of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $user = auth()->user();

        return
            TaskUserResource::collection(
                TaskUser::where('user_id', $user->id)
                        ->orderBy('accepted_at', 'ASC')
                        ->get()
            );
    }

    /**
     * Getting all users who get this task.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsers($id)
    {
        return Task::query()->select(['id', 'title'])->with('users')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return string
     */
    public function update($task_id)
    {
        $user = auth()->user();
        $taskUser = TaskUser::where('task_id', $task_id)->where('user_id', $user->id)->first();
        $taskUser->update(['accepted_at' => Carbon::now()->format('Y-m-d H:i:s')]);

        return Carbon::now()->format('Y-m-d H:i:s');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TaskUser::find($id)->delete();
        return response('Deleted', Response::HTTP_OK);
    }
}
