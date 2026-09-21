<?php

namespace App\Services;

use App\Models\ContactType;
use Illuminate\Support\Facades\DB;
class ContactTypeService
{
    public function getAllContactType(array $paginationDetails)
    {
        $limit = $paginationDetails['limit'];
        $page = $paginationDetails['page'];
        $searchType = $paginationDetails['searchType'] ?? '';
       
        return ContactType::query()
            ->when($searchType, function ($query) use ($searchType) {
                $query->where('description', 'LIKE', '%' . $searchType . '%');
            })
              ->latest('id')
            ->paginate(
                $limit,
                ['*'],
                'page',
                $page
            );
    }

    public function createContactType(array $data)
    {
        try {
            $result = DB::transaction(function () use ($data) {
                return ContactType::create($data);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

     public function getContactTypeDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
               return ContactType::findOrFail($id);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

      public function updateContactTypeDetailsById(array $data,string $id)
    {
        try {
            $result = DB::transaction(function () use ($data,$id) {
                  $contactType = ContactType::findOrFail($id);
                  $contactType->update($data);

                  return $contactType;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
     public function deleteContactTypeDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $contactType = ContactType::findOrFail($id);
                $contactType->delete();

                return $contactType;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
}