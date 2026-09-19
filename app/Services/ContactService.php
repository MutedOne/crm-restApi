<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\DB;
class ContactService
{
    public function getAllContact(array $paginationDetails)
    {
        $limit = $paginationDetails['limit'];
        $page = $paginationDetails['page'];
        $searchName = $paginationDetails['searchName'] ?? '';
        $searchPhone = $paginationDetails['searchPhone'] ?? '';
        $searchEmail = $paginationDetails['searchEmail'] ?? '';
        $searchAddress = $paginationDetails['searchAddress'] ?? '';
        $searchNotes = $paginationDetails['searchNotes'] ?? '';
        return Contact::query()
            ->when($searchName, function ($query) use ($searchName) {
                $query->where('name', 'LIKE', '%' . $searchName . '%');
            })
            ->when($searchPhone, function ($query) use ($searchPhone) {
                $query->where('phone', 'LIKE', '%' . $searchPhone . '%');
            })
            ->when($searchEmail, function ($query) use ($searchEmail) {
                $query->where('email', 'LIKE', '%' . $searchEmail . '%');
            })
            ->when($searchAddress, function ($query) use ($searchAddress) {
                $query->where('address', 'LIKE', '%' . $searchAddress . '%');
            })
            ->when($searchNotes, function ($query) use ($searchNotes) {
                $query->where('notes', 'LIKE', '%' . $searchNotes . '%');
            })
            ->paginate(
                $limit,
                ['*'],
                'page',
                $page
            );
    }

    public function createContact(array $data)
    {
        try {
            $result = DB::transaction(function () use ($data) {
                return Contact::create($data);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

     public function getContactDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
               return Contact::findOrFail($id);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

      public function updateContactDetailsById(array $data,string $id)
    {
        try {
            $result = DB::transaction(function () use ($data,$id) {
                  $contact = Contact::findOrFail($id);
                  $contact->update($data);

                  return $contact;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
     public function deleteContactDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $contact = Contact::findOrFail($id);
                $contact->delete();

                return $contact;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
}