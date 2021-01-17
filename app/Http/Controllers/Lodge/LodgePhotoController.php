<?php

namespace App\Http\Controllers\Lodge;

use App\Http\Resources\LodgePhotoResource;
use App\Models\Lodge;
use App\Models\LodgePhoto;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class LodgePhotoController
{
    use HelperTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lodge_id)
    {
        $per_page = $this->getPerPage();
        $photos = LodgePhoto::whereLodgeId($lodge_id)->paginate($per_page);
        return LodgePhotoResource::collection($photos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($lodge_id)
    {
        // Storage::disk('images')->url($name)
        #insert new user
        DB::beginTransaction();
        $lodge = Lodge::findOrFail($lodge_id);
        $data = $this->validateData();
        $data['name'] = $this->uploadFile('photo');
        $lodge->photos()->create($data);
        DB::commit();
        // return new LodgeFacilityResource($activity);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LodgePhoto  $lodgePhoto
     * @return \Illuminate\Http\Response
     */
    public function show($file_name)
    {
        $folder = Config::get('constants.lodge_photo_path') . '/';
        $file = Storage::disk('images')->get($folder.$file_name);
        return (new Response($file, 200))
            ->header('content-type', 'image/jpeg');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LodgePhoto  $lodgePhoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LodgePhoto $lodgePhoto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LodgePhoto  $lodgePhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy(LodgePhoto $lodgePhoto)
    {
        //
    }

    private function validateData()
    {
        $request = Request();
        return $request->validate([
            'title' => 'required|alpha_dash:max:250',
            'description' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:6000' // allow 6MBs
        ]);
    }

    function uploadFile($file_name, $file_type = 'lodge_photo')
    {
        $folder = Config::get('constants.lodge_photo_path') . '/';

        if (request()->hasFile($file_name)) {
            // Get just ext
            $image = request()->file($file_name);
            $extension = $image->extension();
            //Filename to store
            $fileNameToStore = time() . Str::uuid()->toString().'.jpg';

            //resize image
            $image = Image::make($image)->resize(620, 480,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            )->encode('jpg', 80);// return string
            Storage::disk('images')->put($folder.$fileNameToStore, $image);
            return $fileNameToStore;
        }
        return null;
    }
}
