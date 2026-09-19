<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\ListingTypeService;

class ListingTypeController extends Controller
{
    private ListingTypeService $listingTypeService;

    public function __construct(ListingTypeService $listingTypeService)
    {
        $this->listingTypeService = $listingTypeService;
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
       $result = $this->listingTypeService->getAllListingType($request->all());
       
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

         $this->listingTypeService->createListingType(
                $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'New listing type created successfully.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->listingTypeService->getListingTypeDetailsById(
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

        $this->listingTypeService->updateListingTypeDetailsById(
                $request->all(),
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Listing type updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->listingTypeService->deleteListingTypeDetailsById(
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Listing type deleted successfully',
        ], 200);
    }
}
