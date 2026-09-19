<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\DB;
class LeadService
{
    public function getAllLead(array $paginationDetails)
    {
        $limit = $paginationDetails['limit'];
        $page = $paginationDetails['page'];
        $searchAssignedAgentId = $paginationDetails['searchAssignedAgentId'] ?? '';
        $searchContactId = $paginationDetails['searchContactId'] ?? '';
        $searchStatusId = $paginationDetails['searchStatusId'] ?? '';
        $searchNotes = $paginationDetails['searchNotes'] ?? '';

        return Lead::query()
            ->when($searchAssignedAgentId, function ($query) use ($searchAssignedAgentId) {
                $query->where('assigned_agent_id', $searchAssignedAgentId);
            })
            ->when($searchContactId, function ($query) use ($searchContactId) {
                $query->where('contact_id', $searchContactId);
            })
            ->when($searchStatusId, function ($query) use ($searchStatusId) {
                $query->where('status_id', $searchStatusId);
            })
            ->when($searchNotes, function ($query) use ($searchNotes) {
                $query->where('notes', 'LIKE', '%' . $searchNotes . '%');
            })
            ->paginate(
                $limit,
                ['*'],
                'page',
                $page
            );
    }

    public function createLead(array $data)
    {
        try {
            $result = DB::transaction(function () use ($data) {
                return Lead::create($data);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

     public function getLeadDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
               return Lead::findOrFail($id);
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }

      public function updateLeadDetailsById(array $data,string $id)
    {
        try {
            $result = DB::transaction(function () use ($data,$id) {
                  $lead = Lead::findOrFail($id);
                  $lead->update($data);

                  return $lead;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
     public function deleteLeadDetailsById(string $id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $lead = Lead::findOrFail($id);
                $lead->delete();

                return $lead;
            });

            return $result;
        } finally {
            DB::disconnect();
        }
    }
}