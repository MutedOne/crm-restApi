<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\PropertyOwnerService;

class PropertyOwnerController extends Controller
{
    private PropertyOwnerService $propertyOwnerService;

    public function __construct(PropertyOwnerService $propertyOwnerService)
    {
        $this->propertyOwnerService = $propertyOwnerService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'searchPropertyID' => 'sometimes|numeric',
            'searchContactID' => 'sometimes|numeric',
            'searchTypeID' => 'sometimes|numeric',
            'limit' => 'required|numeric',
            'page' => 'required|numeric',
        ]);
       $result = $this->propertyOwnerService->getAllPropertyOwner($request->all());
       
       return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|numeric|exists:properties,id',
            'contact_id' => 'required|numeric|exists:contacts,id',
            'type_id' => 'required|numeric|exists:contact_types,id',
        ]);

         $this->propertyOwnerService->createPropertyOwner(
                $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'New property owner created successfully.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->propertyOwnerService->getPropertyOwnerDetailsById(
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
            'property_id' => 'sometimes|numeric|exists:properties,id',
            'contact_id' => 'sometimes|numeric|exists:contacts,id',
            'type_id' => 'sometimes|numeric|exists:contact_types,id',
        ]);

        $this->propertyOwnerService->updatePropertyOwnerDetailsById(
                $request->all(),
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Property owner updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->propertyOwnerService->deletePropertyOwnerDetailsById(
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Property owner deleted successfully',
        ], 200);
    }
}
