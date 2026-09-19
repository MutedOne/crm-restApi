<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserStatusService;

class UserStatusController extends Controller
{
    private UserStatusService $userStatusService;

    public function __construct(UserStatusService $userStatusService)
    {
        $this->userStatusService = $userStatusService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'searchStatus' => 'sometimes|string',
            'limit' => 'required|numeric',
            'page' => 'required|numeric',
        ]);
       $result = $this->userStatusService->getAllUserStatus($request->all());
       
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

         $this->userStatusService->createUserStatus(
                $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'New user status created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->userStatusService->getUserStatusDetailsById(
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

        $this->userStatusService->updateUserStatusDetailsById(
                $request->all(),
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->userStatusService->deleteUserStatusDetailsById(
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'User status deleted successfully',
        ], 200);
    }
}
