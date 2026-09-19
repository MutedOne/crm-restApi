<?php

namespace App\Services;

use App\Models\UserStatus;
use Illuminate\Support\Facades\DB;
class UserStatusService
{
    public function getAllUserStatus(array $paginationDetails)
    {
        $limit = $paginationDetails['limit'];
        $page = $paginationDetails['page'];
        $searchStatus = $paginationDetails['searchStatus'] ?? '';
       
        return UserStatus::query()
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

    public function createUserStatus(array $data)
    {
        try {
            $result = DB::transaction(function () use ($data) {
                return UserStatus::create($data);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

     public function getUserStatusDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
               return UserStatus::findOrFail($id);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

      public function updateUserStatusDetailsById(array $data,string $id)
    {
        try {
            $result = DB::transaction(function () use ($data,$id) {
                  $userStatus = UserStatus::findOrFail($id);
                  $userStatus->update($data);

                  return $userStatus;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
     public function deleteUserStatusDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $userStatus = UserStatus::findOrFail($id);
                $userStatus->delete();

                return $userStatus;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
}