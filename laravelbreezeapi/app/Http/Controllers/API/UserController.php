<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        $data = UserResource::collection($users);

        return $this->sendResponse($data, 'Successfully.', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        if ($request->profile_photo_path != null) {
            $fileName = time() . '.' . $request->profile_photo_path->extension();

            $request->profile_photo_path->move(public_path('uploads'), $fileName);

            $data['profile_photo_path'] = $fileName;
        }

        $data['password'] = Hash::make('password');

        $user = User::create($data);

        return new UserResource($user);

        $request->validate([
            'profile_photo_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // validate the image
        ]);

        if ($request->hasFile('profile_photo_path')) {
            $image = $request->file('profile_photo_path');
            $imageName = time() . '.' . $image->extension();

            // Store the image in the public directory
            $image->storeAs('public/images', $imageName);

            // You can save the path to the database
            $user = new User();
            $user->profile_photo_path = 'storage/images/' . $imageName;
            $user->save();

            return response()->json(['message' => 'User created successfully.', 'user' => $user], 201);
        }

        return response()->json(['message' => 'No image uploaded.'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $result = new UserResource($user);

        return $this->sendResponse($result, 'Successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        if ($request->profile_photo_path != null) {
            $fileName = time() . '.' . $request->profile_photo_path->extension();

            $request->profile_photo_path->move(public_path('uploads'), $fileName);

            $data['profile_photo_path'] = $fileName;
        }

        if ($request->password != null) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->sendResponse('', 'Successfully Deleted', 200);
    }
}
