<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Support\Facades\DB;
class PropertyService
{
    public function getAllProperty(array $paginationDetails)
    {
        $limit = $paginationDetails['limit'];
        $page = $paginationDetails['page'];
        $searchTypeID = $paginationDetails['searchTypeID'] ?? '';
        $searchListingID = $paginationDetails['searchListingID'] ?? '';
        $searchPrice = $paginationDetails['searchPrice'] ?? '';
        $searchAddress = $paginationDetails['searchAddress'] ?? '';
        $searchStatusID = $paginationDetails['searchStatusID'] ?? '';
        $searchAssignedAgentID = $paginationDetails['searchAssignedAgentID'] ?? '';
        $searchDescription = $paginationDetails['searchDescription'] ?? '';

        return Property::with(['status','type','assignedAgent','listing','interestedProperties'])
            ->when($searchTypeID, function ($query) use ($searchTypeID) {
                $query->where('type_id', $searchTypeID);
            })
            ->when($searchListingID, function ($query) use ($searchListingID) {
                $query->where('listing_id', $searchListingID);
            })
            ->when($searchPrice, function ($query) use ($searchPrice) {
                $query->where('price', $searchPrice);
            })
            ->when($searchAddress, function ($query) use ($searchAddress) {
                $query->where('address', 'LIKE', '%' . $searchAddress . '%');
            })
            ->when($searchStatusID, function ($query) use ($searchStatusID) {
                $query->where('status_id', $searchStatusID);
            })
            ->when($searchAssignedAgentID, function ($query) use ($searchAssignedAgentID) {
                $query->where('assigned_agent_id', $searchAssignedAgentID);
            })
            ->when($searchDescription, function ($query) use ($searchDescription) {
                $query->where('description', 'LIKE', '%' . $searchDescription . '%');
            })
              ->latest('id')
            ->paginate(
                $limit,
                ['*'],
                'page',
                $page
            );
    }

    public function createProperty(array $data)
    {
        try {
            $result = DB::transaction(function () use ($data) {
                return Property::create($data);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

     public function getPropertyDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
               return Property::findOrFail($id);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

      public function updatePropertyDetailsById(array $data,string $id)
    {
        try {
            $result = DB::transaction(function () use ($data,$id) {
                  $property = Property::findOrFail($id);
                  $property->update($data);

                  return $property;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
     public function deletePropertyDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $property = Property::findOrFail($id);
                $property->delete();

                return $property;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
}