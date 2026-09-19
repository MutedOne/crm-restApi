<?php

namespace App\Services;

use App\Models\PropertyOwner;
use Illuminate\Support\Facades\DB;
class PropertyOwnerService
{
    public function getAllPropertyOwner(array $paginationDetails)
    {
        $limit = $paginationDetails['limit'];
        $page = $paginationDetails['page'];
        $searchPropertyID = $paginationDetails['searchPropertyID'] ?? '';
        $searchContactID = $paginationDetails['searchContactID'] ?? '';
        $searchTypeID = $paginationDetails['searchTypeID'] ?? '';
        return PropertyOwner::query()
            ->when($searchPropertyID, function ($query) use ($searchPropertyID) {
                $query->where('property_id', $searchPropertyID);
            })
            ->when($searchContactID, function ($query) use ($searchContactID) {
                $query->where('contact_id', $searchContactID);
            })
            ->when($searchTypeID, function ($query) use ($searchTypeID) {
                $query->where('type_id', $searchTypeID);
            })
            ->paginate(
                $limit,
                ['*'],
                'page',
                $page
            );
    }

    public function createPropertyOwner(array $data)
    {
        try {
            $result = DB::transaction(function () use ($data) {
                return PropertyOwner::create($data);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

     public function getPropertyOwnerDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
               return PropertyOwner::findOrFail($id);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

      public function updatePropertyOwnerDetailsById(array $data,string $id)
    {
        try {
            $result = DB::transaction(function () use ($data,$id) {
                  $propertyOwner = PropertyOwner::findOrFail($id);
                  $propertyOwner->update($data);

                  return $propertyOwner;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
     public function deletePropertyOwnerDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $propertyOwner = PropertyOwner::findOrFail($id);
                $propertyOwner->delete();

                return $propertyOwner;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
}