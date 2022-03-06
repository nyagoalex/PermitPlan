<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::first();
        return new SettingResource($settings);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(SettingRequest $request)
    {
        DB::beginTransaction();
        $data = $request->validated();
        $settings = Setting::first();
        $settings->update($data);;
        DB::commit();
        return new SettingResource($settings);
    }

    public function logo()
    {
        DB::beginTransaction();
        $this->validateData();
        $logo = $this->uploadFile();
        $settings = Setting::first();
        $settings->update([
            'logo' => $logo
        ]);
        DB::commit();
        return new SettingResource($settings);
    }

    private function validateData()
    {
        $request = Request();
        return $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048' // allow 6MBs
        ]);
    }

    function uploadFile()
    {
        if (request()->hasFile('photo')) {
            $image = request()->file('photo'); // Get just ext

            //resize image
            $image = Image::make($image)->resize(100, 100,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            )->encode('png', 80) // Encodes image to jpg with 80% quality
            ->encode('data-url'); // encode image to base64
            return  $image->getEncoded(); // return string
        }
        return null;
    }
}
