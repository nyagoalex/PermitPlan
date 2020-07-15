<?php

namespace App\Traits;

use Illuminate\Support\Facades\Config;

trait HelperTrait
{
    public function getPerPage()
    {
        $request = Request();
       return !($request->input('per_page')) ? Config::get('constants.records_per_page') : $request->input('per_page');
    }

    public function getSort()
    {
        $request = Request();
       return !($request->input('sort')) ? 'asc' : $request->input('sort');;
    }

    public function getOrderColumn($column)
    {
        $request = Request();
       return !($request->input('orderby')) ? $column : $request->input('orderby');
    }
}
