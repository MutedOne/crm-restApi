<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\PropertyService;

class PropertyController extends Controller
{
    private PropertyService $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'searchName' => 'sometimes|string',
            'searchTypeID' => 'sometimes|numeric',
            'searchListingID' => 'sometimes|numeric',
            'searchPrice' => 'sometimes|numeric',
            'searchAddress' => 'sometimes|string|max:255',
            'searchStatusID' => 'sometimes|numeric',
            'searchAssignedAgentID' => 'sometimes|numeric',
            'searchDescription' => 'sometimes|string|max:255',
            'limit' => 'required|numeric',
            'page' => 'required|numeric',
        ]);
       $result = $this->propertyService->getAllProperty($request->all());
       
       return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'type_id' => 'required|numeric|exists:property_types,id',
            'listing_id' => 'required|numeric|exists:listing_types,id',
            'price' => 'required|numeric',
            'address' => 'required|string|max:255',
            'status_id' => 'required|numeric|exists:property_statuses,id',
            'assigned_agent_id' => 'required|numeric|exists:users,id',
            'description' => 'required|string|max:255',
        ]);

         $this->propertyService->createProperty(
                $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'New property created successfully.',
        ], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->propertyService->getPropertyDetailsById(
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
            'type_id' => 'sometimes|numeric|exists:property_types,id',
            'listing_id' => 'sometimes|numeric|exists:listing_types,id',
            'price' => 'sometimes|numeric',
            'address' => 'sometimes|string|max:255',
            'status_id' => 'sometimes|numeric|exists:property_statuses,id',
            'assigned_agent_id' => 'sometimes|numeric|exists:users,id',
            'description' => 'sometimes|string|max:255',
        ]);

        $this->propertyService->updatePropertyDetailsById(
                $request->all(),
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Property updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->propertyService->deletePropertyDetailsById(
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Property deleted successfully',
        ], 200);
    }
}
