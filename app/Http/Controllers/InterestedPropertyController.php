<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\InterestedPropertyService;

class InterestedPropertyController extends Controller
{
    private InterestedPropertyService $interestedPropertyService;

    public function __construct(InterestedPropertyService $interestedPropertyService)
    {
        $this->interestedPropertyService = $interestedPropertyService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'searchPropertyID' => 'sometimes|numeric',
            'searchLeadID' => 'sometimes|numeric',
            'limit' => 'required|numeric',
            'page' => 'required|numeric',
        ]);
       $result = $this->interestedPropertyService->getAllInterestedProperty($request->all());
       
       return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|numeric|exists:properties,id',
            'lead_id' => 'required|numeric|exists:leads,id',
        ]);

         $this->interestedPropertyService->createInterestedProperty(
                $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'New interested property created successfully.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->interestedPropertyService->getInterestedPropertyDetailsById(
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
            'lead_id' => 'sometimes|numeric|exists:leads,id',
        ]);

        $this->interestedPropertyService->updateInterestedPropertyDetailsById(
                $request->all(),
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Interested property updated successfully.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->interestedPropertyService->deleteInterestedPropertyDetailsById(
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Interested property deleted successfully.',
        ], 200);
    }
}
