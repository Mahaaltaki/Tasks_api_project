<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;


class userService
{
    /*
     * @param Request $request 
     * @return array containing paginated book resources.
     */
    public function getAllUsers(Request $request): array
    {
        // query builder instance for the User model
        $query = User::query();
        // Paginate the results
        $users = $query->paginate(10);

        // Return the paginated books wrapped in a BookResource collection
        return UserResource::collection($users)->toArray(request());
    }

    /**
     * Store a new User.
     * @param array $data array containing 'name', 'email', 'password'.
     * @return array array containing the created user resource.
     * @throws \Exception
     * Throws an exception if the user creation fails */
    public function storeUser(array $data): array
    {
        // Create a new user
        $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = $data['password']; 
            $user->role=$data['role'];
            $user->save();
        // if the user was created successfully
        if (!$user) {
            throw new \Exception('Failed to create user.');
        }

        // Return the created book as a resource
        return UserResource::make($user)->toArray(request());
    }

    /*Retrieve a specific user by its ID.
     * @param int $id of the user.
     * @return array containing the user resource.
     * @throws \Exception exception if the user is not found.*/
    public function showUser(int $id): array
    {
        // Find user by ID
        $user = User::find($id);
        // If user is not found, throw an exception
        if (!$user) {
            throw new \Exception('user not found.');
        }

        // Return the found user
        return UserResource::make($user)->toArray(request());
    }

    /**
     * Update an user.
     * @param User $user
     * update The user model.
     * @param array $data array containing the fields to update (name, email, password).
     * @return array containing the updated user resource.
     */
    public function updateUser(User $user, array $data): array
    {
        // Update only the fields that are provided in the data array
        $user->update(array_filter([
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
            'password' => $data['password'] ?? $user->password,
        ]));
        // Return the updated user as a resource
        return UserResource::make($user)->toArray(request());
    }

    /**
     * Delete user by ID.
     * @param int $id of user to delete.
     * @return void
     * @throws \Exception an exception if the user is not found.
     */
    public function deleteUser(int $id): void
    {
        // Find the user by ID
        $user = User::find($id);

        // If no user is found, throw an exception
        if (!$user) {
            throw new \Exception('user not found.');
        }

        // Delete user
        $user->delete();
    }
}
