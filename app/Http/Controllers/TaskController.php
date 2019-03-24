<?php

namespace App\Http\Controllers;

use App\Model\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * Get all of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function store(Request $request)
    {
        $task = $request->task;
        $users = $request->users;
        $user_ids = [];

        foreach ($users as $user) {
            array_push($user_ids, $user['id']);
        }

        $newTask = Task::create($task);
        $newTask->users()->attach($user_ids);

        return response('Created', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Task::find($id)->with('users')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Task::find($id)->update($request->all());
        return response('Updated', Response::HTTP_OK);
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
        Task::find($id)->delete();
        return response('Deleted', Response::HTTP_OK);
    }
}
