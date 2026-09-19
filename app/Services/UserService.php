<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserService
{
    public function getAllUser(array $paginationDetails)
    {
        $limit = $paginationDetails['limit'];
        $page = $paginationDetails['page'];
        $searchEmail = $paginationDetails['searchEmail'] ?? '';
        $searchPhone = $paginationDetails['searchPhone'] ?? '';
        $searchUsername = $paginationDetails['searchUsername'] ?? '';
        $searchRoleId = $paginationDetails['searchRoleId'] ?? '';
        $searchStatusId = $paginationDetails['searchStatusId'] ?? '';

        return User::query()
            ->when($searchEmail, function ($query) use ($searchEmail) {
                $query->where('email', 'LIKE', '%' . $searchEmail . '%');
            })
            ->when($searchPhone, function ($query) use ($searchPhone) {
                $query->where('phone', 'LIKE', '%' . $searchPhone . '%');
            })
            ->when($searchUsername, function ($query) use ($searchUsername) {
                $query->where('username', 'LIKE', '%' . $searchUsername . '%');
            })
            ->when($searchRoleId, function ($query) use ($searchRoleId) {
                $query->where('role_id', $searchRoleId);
            })
            ->when($searchStatusId, function ($query) use ($searchStatusId) {
                $query->where('status_id', $searchStatusId);
            })
            ->paginate(
                $limit,
                ['*'],
                'page',
                $page
            );
    }

    public function createUser(array $data)
    {
        try {
            $result = DB::transaction(function () use ($data) {
                $data['password'] = Hash::make($data['password']);
                
                return User::create($data);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

     public function getUserDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
               return User::findOrFail($id);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

      public function updateUserDetailsById(array $data,string $id)
    {
        try {
            $result = DB::transaction(function () use ($data,$id) {
                  $user = User::findOrFail($id);
                    if (!empty($data['password'])) {
                        $data['password'] = Hash::make($data['password']);
                    }
                  $user->update($data);

                  return $user;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
     public function deleteUserDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $user = User::findOrFail($id);
                $user->delete();

                return $user;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
}