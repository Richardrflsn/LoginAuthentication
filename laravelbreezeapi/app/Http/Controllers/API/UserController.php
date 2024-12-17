<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
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
        // Validate request data
        $data = $request->validated();

        // Handle profile photo upload using Cloudinary
        if ($request->hasFile('profile_photo_path')) {
            try {
                $uploadedFile = Cloudinary::upload($request->file('profile_photo_path')->getRealPath(), [
                    'folder' => 'users',
                ]);

                // Store the secure URL in the data array
                $data['profile_photo_path'] = $uploadedFile->getSecurePath();
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image upload failed: ' . $e->getMessage(),
                ], 500);
            }
        }

        // Hash the password before storing it
        $data['password'] = Hash::make($request->password ?? 'default_password');

        // Create the user
        $user = User::create($data);

        // Return the newly created user as a resource
        return response()->json([
            'message' => 'User created successfully.',
            'data' => new UserResource($user),
        ], 201);
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

        // Handle image upload using Cloudinary
        if ($request->hasFile('profile_photo_path')) {
            try {
                // Delete the old image from Cloudinary (if any)
                if ($user->profile_photo_path) {
                    $publicId = basename(parse_url($user->profile_photo_path, PHP_URL_PATH), '.jpg');
                    Cloudinary::destroy("users/{$publicId}");
                }

                // Upload the new image to Cloudinary
                $uploadedFile = Cloudinary::upload($request->file('profile_photo_path')->getRealPath(), [
                    'folder' => 'users',
                ]);

                // Update the secure URL in the data
                $data['profile_photo_path'] = $uploadedFile->getSecurePath();
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image upload failed: ' . $e->getMessage(),
                ], 500);
            }
        }

        // Update the password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update the user
        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'data' => new UserResource($user),
        ]);
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
