<?php

namespace App\Services;

use App\Models\LeadStatus;
use Illuminate\Support\Facades\DB;
class LeadStatusService
{
    public function getAllLeadStatus(array $paginationDetails)
    {
        $limit = $paginationDetails['limit'];
        $page = $paginationDetails['page'];
        $searchStatus = $paginationDetails['searchStatus'] ?? '';
       
        return LeadStatus::query()
            ->when($searchStatus, function ($query) use ($searchStatus) {
                $query->where('description', 'LIKE', '%' . $searchStatus . '%');
            })
              ->latest('id')
            ->paginate(
                $limit,
                ['*'],
                'page',
                $page
            );
    }

    public function createLeadStatus(array $data)
    {
        try {
            $result = DB::transaction(function () use ($data) {
                return LeadStatus::create($data);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

     public function getLeadStatusDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
               return LeadStatus::findOrFail($id);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

      public function updateLeadStatusDetailsById(array $data,string $id)
    {
        try {
            $result = DB::transaction(function () use ($data,$id) {
                  $leadStatus = LeadStatus::findOrFail($id);
                  $leadStatus->update($data);

                  return $leadStatus;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
     public function deleteLeadStatusDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $leadStatus = LeadStatus::findOrFail($id);
                $leadStatus->delete();

                return $leadStatus;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
}