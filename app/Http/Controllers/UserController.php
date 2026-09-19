<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'searchEmail' => 'sometimes|string|max:50|email',
            'searchPhone' => 'sometimes|numeric',
            'searchUsername' => 'sometimes|string|max:50',
            'searchRoleId' => 'sometimes|numeric|exists:user_roles,id',
            'searchStatusId' => 'sometimes|string|max:50|exists:user_statuses,id',
            'limit' => 'required|numeric',
            'page' => 'required|numeric',
        ]);
       $result = $this->userService->getAllUser($request->all());
       
       return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'email' => 'required|string|max:50|email|unique:users,email',
            'phone' => 'required|numeric',
            'password' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:users,username',
            'role_id' => 'required|numeric|exists:user_roles,id',
            'status_id' => 'required|string|max:50|exists:user_statuses,id',
        ]);

         $this->userService->createUser(
                $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'New user created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->userService->getUserDetailsById(
                $id
        );
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'email' => 'sometimes|string|max:50|email|unique:users,email',
            'phone' => 'sometimes|numeric',
            'password' => 'sometimes|string|max:50',
            'username' => 'sometimes|string|max:50|unique:users,username',
            'role_id' => 'sometimes|numeric|exists:user_roles,id',
            'status_id' => 'sometimes|string|max:50|exists:user_statuses,id',
        ]);

        $this->userService->updateUserDetailsById(
                $request->all(),
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->userService->deleteUserDetailsById(
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ], 200);
    }
}
