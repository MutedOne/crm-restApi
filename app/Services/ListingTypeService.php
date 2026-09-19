<?php

namespace App\Services;

use App\Models\ListingType;
use Illuminate\Support\Facades\DB;
class ListingTypeService
{
    public function getAllListingType(array $paginationDetails)
    {
        $limit = $paginationDetails['limit'];
        $page = $paginationDetails['page'];
        $searchType = $paginationDetails['searchType'] ?? '';
       
        return ListingType::query()
            ->when($searchType, function ($query) use ($searchType) {
                $query->where('description', 'LIKE', '%' . $searchType . '%');
            })
            ->paginate(
                $limit,
                ['*'],
                'page',
                $page
            );
    }

    public function createListingType(array $data)
    {
        try {
            $result = DB::transaction(function () use ($data) {
                return ListingType::create($data);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

     public function getListingTypeDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
               return ListingType::findOrFail($id);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

      public function updateListingTypeDetailsById(array $data,string $id)
    {
        try {
            $result = DB::transaction(function () use ($data,$id) {
                  $propertyType = ListingType::findOrFail($id);
                  $propertyType->update($data);

                  return $propertyType;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
     public function deleteListingTypeDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $propertyType = ListingType::findOrFail($id);
                $propertyType->delete();

                return $propertyType;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
}