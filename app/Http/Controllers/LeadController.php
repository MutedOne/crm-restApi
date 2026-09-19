<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\LeadService;

class LeadController extends Controller
{
    private LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'searchAssignedAgentId' => 'sometimes|string|numeric|exists:users,id',
            'searchContactId' => 'sometimes|string|numeric|exists:contacts,id',
            'searchStatusId' => 'sometimes|string|numeric|exists:lead_statuses,id',
            'searchNotes' => 'sometimes|string',
            'limit' => 'required|numeric',
            'page' => 'required|numeric',
        ]);
       $result = $this->leadService->getAllLead($request->all());
       
       return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'assigned_agent_id' => 'required|numeric|exists:users,id',
            'notes' => 'sometimes|string',
            'contact_id' => 'required|numeric|exists:contacts,id',
            'status_id' => 'required|numeric|exists:lead_statuses,id'
        ]);

         $this->leadService->createLead(
                $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'New lead created successfully.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->leadService->getLeadDetailsById(
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
            'assigned_agent_id' => 'sometimes|numeric|exists:users,id',
            'notes' => 'sometimes|string',
            'contact_id' => 'sometimes|numeric|exists:contacts,id',
            'status_id' => 'sometimes|numeric|exists:lead_statuses,id'
        ]);

        $this->leadService->updateLeadDetailsById(
                $request->all(),
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Lead  updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->leadService->deleteLeadDetailsById(
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Lead  deleted successfully',
        ], 200);
    }
}
