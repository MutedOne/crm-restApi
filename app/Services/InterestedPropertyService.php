<?php

namespace App\Services;

use App\Models\InterestedProperty;
use Illuminate\Support\Facades\DB;
class InterestedPropertyService
{
    public function getAllInterestedProperty(array $paginationDetails)
    {
        $limit = $paginationDetails['limit'];
        $page = $paginationDetails['page'];
        $searchPropertyID = $paginationDetails['searchPropertyID'] ?? '';
        $searchLeadID = $paginationDetails['searchLeadID'] ?? '';
        return InterestedProperty::with(['property','lead'])
            ->when($searchPropertyID, function ($query) use ($searchPropertyID) {
                $query->where('property_id', $searchPropertyID);
            })
            ->when($searchLeadID, function ($query) use ($searchLeadID) {
                $query->where('lead_id', $searchLeadID);
            })
            ->paginate(
                $limit,
                ['*'],
                'page',
                $page
            );
    }

    public function createInterestedProperty(array $data)
    {
        try {
            $result = DB::transaction(function () use ($data) {
                return InterestedProperty::create($data);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

     public function getInterestedPropertyDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
               return InterestedProperty::findOrFail($id);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

      public function updateInterestedPropertyDetailsById(array $data,string $id)
    {
        try {
            $result = DB::transaction(function () use ($data,$id) {
                  $interestedProperty = InterestedProperty::findOrFail($id);
                  $interestedProperty->update($data);

                  return $interestedProperty;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
     public function deleteInterestedPropertyDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $interestedProperty = InterestedProperty::findOrFail($id);
                $interestedProperty->delete();

                return $interestedProperty;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
}