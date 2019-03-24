<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Get all of the resource.
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return User::with(['group', 'permission', 'position'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO: validation & StoreUserRequest
        return
            User::create($request->all())
                ? response('Created', Response::HTTP_OK)
                : response('Error', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show($id)
    {
        return UserResource::collection(User::where('id', $id)->firstOrFail());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return UserResource
     */
    public function showAuth()
    {
        $user = auth()->user()->with(['group', 'permission', 'position'])->firstOrFail();
        return UserResource::collection($user);
    }
}
