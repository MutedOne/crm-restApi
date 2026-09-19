<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserRoleService;

class UserRoleController extends Controller
{
    private UserRoleService $userRoleService;

    public function __construct(UserRoleService $userRoleService)
    {
        $this->userRoleService = $userRoleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'searchRole' => 'sometimes|string',
            'limit' => 'required|numeric',
            'page' => 'required|numeric',
        ]);
       $result = $this->userRoleService->getAllUserRole($request->all());
       
       return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'description' => 'required|string|max:50',
        ]);

         $this->userRoleService->createUserRole(
                $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'New user role created successfully.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->userRoleService->getUserRoleDetailsById(
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
            'description' => 'sometimes|required|string|max:255'
        ]);

        $this->userRoleService->updateUserRoleDetailsById(
                $request->all(),
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'User role updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->userRoleService->deleteUserRoleDetailsById(
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'User role deleted successfully',
        ], 200);
    }
}
