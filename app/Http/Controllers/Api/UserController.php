<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * List all Users
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $users = User::all();

        return response()->json($users);
    }

    /**
     * Create a new User
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $request->merge([
                'password' => bcrypt($request->password)
            ]);

            $user = User::create($request->all());

            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update a User
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if(!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            if (!($request->user()->isAdmin() || $request->user()->id == $user->id)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $user->update($request->all());

            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show a User
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);

        if(!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    /**
     * Delete a User
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function destroy(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if(!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            if (!($request->user()->isAdmin() || $request->user()->id == $user->id)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $user->delete();

            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
