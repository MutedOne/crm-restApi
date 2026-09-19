<?php

namespace App\Services;

use App\Models\PropertyType;
use Illuminate\Support\Facades\DB;
class PropertyTypeService
{
    public function getAllPropertyType(array $paginationDetails)
    {
        $limit = $paginationDetails['limit'];
        $page = $paginationDetails['page'];
        $searchType = $paginationDetails['searchType'] ?? '';
       
        return PropertyType::query()
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

    public function createPropertyType(array $data)
    {
        try {
            $result = DB::transaction(function () use ($data) {
                return PropertyType::create($data);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

     public function getPropertyTypeDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
               return PropertyType::findOrFail($id);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

      public function updatePropertyTypeDetailsById(array $data,string $id)
    {
        try {
            $result = DB::transaction(function () use ($data,$id) {
                  $propertyType = PropertyType::findOrFail($id);
                  $propertyType->update($data);

                  return $propertyType;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
     public function deletePropertyTypeDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $propertyType = PropertyType::findOrFail($id);
                $propertyType->delete();

                return $propertyType;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
}