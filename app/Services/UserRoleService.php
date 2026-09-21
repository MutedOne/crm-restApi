<?php

namespace App\Services;

use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
class UserRoleService
{
    public function getAllUserRole(array $paginationDetails)
    {
        $limit = $paginationDetails['limit'];
        $page = $paginationDetails['page'];
        $searchRole = $paginationDetails['searchRole'] ?? '';
       
        return UserRole::query()
            ->when($searchRole, function ($query) use ($searchRole) {
                $query->where('description', 'LIKE', '%' . $searchRole . '%');
            })
              ->latest('id')
            ->paginate(
                $limit,
                ['*'],
                'page',
                $page
            );
    }

    public function createUserRole(array $data)
    {
        try {
            $result = DB::transaction(function () use ($data) {
                return UserRole::create($data);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

     public function getUserRoleDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
               return UserRole::findOrFail($id);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

      public function updateUserRoleDetailsById(array $data,string $id)
    {
        try {
            $result = DB::transaction(function () use ($data,$id) {
                  $userRole = UserRole::findOrFail($id);
                  $userRole->update($data);

                  return $userRole;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
     public function deleteUserRoleDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $userRole = UserRole::findOrFail($id);
                $userRole->delete();

                return $userRole;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
}