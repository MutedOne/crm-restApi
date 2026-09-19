<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\PropertyStatusService;

class PropertyStatusController extends Controller
{
    private PropertyStatusService $propertyStatusService;

    public function __construct(PropertyStatusService $propertyStatusService)
    {
        $this->propertyStatusService = $propertyStatusService;
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
       $result = $this->propertyStatusService->getAllPropertyStatus($request->all());
       
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

         $this->propertyStatusService->createPropertyStatus(
                $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'New property status created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->propertyStatusService->getPropertyStatusDetailsById(
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

        $this->propertyStatusService->updatePropertyStatusDetailsById(
                $request->all(),
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Property status updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->propertyStatusService->deletePropertyStatusDetailsById(
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Property status deleted successfully',
        ], 200);
    }
}
