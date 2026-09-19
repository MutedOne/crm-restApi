<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\ContactTypeService;

class ContactTypeController extends Controller
{
    private ContactTypeService $contactTypeService;

    public function __construct(ContactTypeService $contactTypeService)
    {
        $this->contactTypeService = $contactTypeService;
    }
    /**
     * Display a contact of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'searchType' => 'sometimes|string',
            'limit' => 'required|numeric',
            'page' => 'required|numeric',
        ]);
       $result = $this->contactTypeService->getAllContactType($request->all());
       
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

         $this->contactTypeService->createContactType(
                $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'New contact type created successfully.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->contactTypeService->getContactTypeDetailsById(
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

        $this->contactTypeService->updateContactTypeDetailsById(
                $request->all(),
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Contact type updated successfully.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->contactTypeService->deleteContactTypeDetailsById(
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Contact type deleted successfully.',
        ], 200);
    }
}
