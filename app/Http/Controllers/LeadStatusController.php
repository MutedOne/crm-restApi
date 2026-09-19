<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\LeadStatusService;

class LeadStatusController extends Controller
{
    private LeadStatusService $leadStatusService;

    public function __construct(LeadStatusService $leadStatusService)
    {
        $this->leadStatusService = $leadStatusService;
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
       $result = $this->leadStatusService->getAllLeadStatus($request->all());
       
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

         $this->leadStatusService->createLeadStatus(
                $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'New lead status created successfully.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->leadStatusService->getLeadStatusDetailsById(
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

        $this->leadStatusService->updateLeadStatusDetailsById(
                $request->all(),
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Lead status updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->leadStatusService->deleteLeadStatusDetailsById(
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Lead status deleted successfully',
        ], 200);
    }
}
