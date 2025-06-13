<?php

namespace App\Services\Admin;

use App\Models\CommonMaster;

class CommonMasterService
{
    public function all()
    {
        return CommonMaster::latest()->paginate(10);
    }

    public function create(array $data)
    {
        $data['category_id'] = $data['category'];
        return CommonMaster::create($data);
    }

    public function find($id)
    {
        return CommonMaster::findOrFail($id);
    }

    public function update(CommonMaster $commonMaster, array $data)
    {
        $data['category_id'] = $data['category'];
        $commonMaster->update($data);
        return $commonMaster;
    }

    public function delete(CommonMaster $commonMaster)
    {
        $commonMaster->delete();
    }

    public function restore(CommonMaster $commonMaster)
    {
        $commonMaster->restore();
    }

    public function updateStatus(CommonMaster $commonMaster, string $status)
    {
        $commonMaster->status = $status;
        $commonMaster->save();

        return $commonMaster;
    }
}
