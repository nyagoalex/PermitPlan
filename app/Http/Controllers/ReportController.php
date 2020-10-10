<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingResource;
use App\Models\Permit;
use App\Models\PermitType;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class ReportController
{
    public function permits()
    {
        return PermitType::withCount('permits')->get()->pluck('permits_count', 'name');
    }
}
