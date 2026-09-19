<?php

namespace App\Services;

use App\Models\PropertyStatus;
use Illuminate\Support\Facades\DB;
class PropertyStatusService
{
    public function getAllPropertyStatus(array $paginationDetails)
    {
        $limit = $paginationDetails['limit'];
        $page = $paginationDetails['page'];
        $searchStatus = $paginationDetails['searchStatus'] ?? '';
       
        return PropertyStatus::query()
            ->when($searchStatus, function ($query) use ($searchStatus) {
                $query->where('description', 'LIKE', '%' . $searchStatus . '%');
            })
            ->paginate(
                $limit,
                ['*'],
                'page',
                $page
            );
    }

    public function createPropertyStatus(array $data)
    {
        try {
            $result = DB::transaction(function () use ($data) {
                return PropertyStatus::create($data);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

     public function getPropertyStatusDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
               return PropertyStatus::findOrFail($id);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

      public function updatePropertyStatusDetailsById(array $data,string $id)
    {
        try {
            $result = DB::transaction(function () use ($data,$id) {
                  $propertyStatus = PropertyStatus::findOrFail($id);
                  $propertyStatus->update($data);

                  return $propertyStatus;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
     public function deletePropertyStatusDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $propertyStatus = PropertyStatus::findOrFail($id);
                $propertyStatus->delete();

                return $propertyStatus;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
}