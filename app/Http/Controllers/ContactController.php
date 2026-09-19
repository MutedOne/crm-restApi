<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\ContactService;

class ContactController extends Controller
{
    private ContactService $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }
    /**
     * Display a contact of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'searchName' => 'sometimes|string',
            'searchPhone' => 'sometimes|string',
            'searchEmail' => 'sometimes|string|email',
            'searchAddress' => 'sometimes|string',
            'searchNotes' => 'sometimes|string',
            'limit' => 'required|numeric',
            'page' => 'required|numeric',
        ]);
       $result = $this->contactService->getAllContact($request->all());
       
       return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|max:50',
            'phone' => 'required|numeric',
            'email' => 'required|string|max:50|email',
            'address' => 'required|string|max:50',
            'notes' => 'required|string|max:50'
        ]);

         $this->contactService->createContact(
                $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'New contact  created successfully.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->contactService->getContactDetailsById(
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
            'name' => 'sometimes|string|max:50',
            'phone' => 'sometimes|numeric',
            'email' => 'sometimes|string|max:50|email',
            'address' => 'sometimes|string|max:50',
            'notes' => 'sometimes|string|max:50'
        ]);


        $this->contactService->updateContactDetailsById(
                $request->all(),
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Contact updated successfully.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->contactService->deleteContactDetailsById(
                $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Contact deleted successfully.',
        ], 200);
    }
}
