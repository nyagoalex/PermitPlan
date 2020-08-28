<?php

namespace App\Traits;

use Illuminate\Support\Carbon;
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


    function getAge($dob)
    {
        $interval = Carbon::parse($dob)->diffAsCarbonInterval(Carbon::now(), false);
        if ($interval->y >= 1)
            $age = $this->pluralize($interval->y, 'year');
        elseif ($interval->m >= 1)
            $age = $this->pluralize($interval->m, 'month');
        elseif ($interval->d >= 1)
            $age = $this->pluralize($interval->d, 'day');
        else 
            $age = "0 years";
        
        return $age;
    }

    function pluralize ($count, $text)
    {
        return $count.' '.(($count ==1) ? $text : $text."s");
    }

    function nextNumber($model, $column, $prefix)
    {
        $last_number = $model->max($column);
        $last_number = (int) filter_var($last_number, FILTER_SANITIZE_NUMBER_INT);
        return $prefix.sprintf('%04d', $last_number + 1);
    }
}
