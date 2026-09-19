<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\PropertyTypeService;

class PropertyTypeController extends Controller
{
    private PropertyTypeService $propertyTypeService;

    public function __construct(PropertyTypeService $propertyTypeService)
    {
        $this->propertyTypeService = $propertyTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'searchType' => 'sometimes|string',
            'limit' => 'required|numeric',
            'page' => 'required|numeric',
        ]);
       $result = $this->propertyTypeService->getAllPropertyType($request->all());
       
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

         $this->propertyTypeService->createPropertyType(
                $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'New property type created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->propertyTypeService->getPropertyTypeDetailsById(
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

        $this->propertyTypeService->updatePropertyTypeDetailsById(
                $request->all(),
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Property type updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->propertyTypeService->deletePropertyTypeDetailsById(
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Property type deleted successfully',
        ], 200);
    }
}
