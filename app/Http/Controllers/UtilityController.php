<?php

namespace App\Http\Controllers;

use App\Models\{
    SiteSetting,
    Slider,
    Video
};
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,
    Session,
    Validator,
    View,
};
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UtilityController extends Controller
{
    use Helper;

    /**
     * Site Setting
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function siteSetting(Request $request)
    {
        try {
            if($this->roleCheck("site_settings") == false) return redirect()->route('admin.home');
            $settings = SiteSetting::first();
            return view::make('admin.site_setting')->with([
                "socials" => json_decode($settings->socials) ?? [],
                "numbers" => json_decode($settings->phone_numbers) ?? [],
                "settings" => $settings ?? "", 
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.home');
        }
    }

    /**
     * Update Site Setting
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function updateSiteSetting(Request $request)
    {
        try {
            $rules = [
                "opening_hour" => "required",
                "closing_hour" => "required",
                "first" => "required",
                "second" => "required",
                "address" => "required"
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 403);
            }

            $socials = (Object)[
                "facebook" => $request->facebook,
                "twitter" => $request->twitter,
                "instagram" => $request->instagram,
                "youtube" => $request->youtube
            ];

            $numbers = (Object)[
                "first" => $request->first,
                "second" => $request->second,  
            ];

            SiteSetting::updateOrCreate([
                "id" => 1,
            ], [
                "id" => 1,     
                "opening_hour" => $request->opening_hour,
                "closing_hour" => $request->closing_hour,
                "socials" => json_encode($socials),
                "phone_numbers" => json_encode($numbers),
                "address" => $request->address
            ]);

            return response()->json([ "status" => 202, "message" => "Site setting updated." ], 202);
        } catch (\Exception $ex) {
            return response()->json([
                "status" => 203,
                "message" => "Error updating site setting."
            ], 203);
        }
    }

    /**
     * Videos Page
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function videos(Request $request, Video $videos)
    {
        try {
            if($this->roleCheck("videos") == false) return redirect()->route('admin.home');
            return view::make('admin.videos')->with([
                "videos" => $videos->orderBy('created_at', 'DESC')->simplePaginate(9)
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.home');
        }
    }

    /**
     * Upload Videos
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function uploadVideo(Request $request)
    {
        try {
            $rules = [
                "url" => "required",
                "title" => "required",
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            # check for duplicate video
            $checkDuplicateVideo = Video::where('title', $request->title)->first();
            if ($checkDuplicateVideo) {
                return response()->json([
                    'status' => 203,
                    'message' => "A video with similar title already exist."
                ], 203);
            }

            Video::create([ 'title' => $request->title, 'url' => $request->url ]);

            return response()->json([
                'status' => 201,
                'message' => "Video added successfully.",
            ], 201);
        } catch (\Exception $ex) {
            $error = Session::flash('error', 'Error saving video url. Please try again.');
            return redirect()->route('admin.videos')->with($error);
        }
    }

    /**
     * Delete Video
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function deleteVideo(Request $request)
    {
        try {
            Video::find($request->video)->delete();
            return response()->json([
                'status' => 200,
                'message' => "Video url deleted.",
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                "status" => 203,
                "message" => "Error deleting video url. Please try again."
            ], 203);
        }
    }

    /**
     * Slider
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Slider $slider
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function slider(Request $request, Slider $sliders)
    {
        return view('admin.slider')->with([
            'sliders' => $sliders->orderBy('created_at', 'DESC')->simplePaginate(6)
        ]);
    }

    /**
     * Create Slider
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function createSlider(Request $request)
    {
        try {
            $rules = [ 'image' => 'required|image|mimes:jpeg,png,jpg|max:10096', 'caption' => 'required' ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            # upload image
            $imageFile = $request->file('image');
            $extension = $imageFile->getClientOriginalExtension();
            $name = 'IMG'.'_'.time().'.'.Str::uuid();
            $path = "sliders/{$name}.{$extension}";

            $image = Image::make($imageFile->getRealPath())->resize(787, 1180, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 75);
            $url = $this->storeFile($path, (string)$image, 'public');

            Slider::create([ 'uuid' => Str::uuid(), 'image' => $url, 'key' => $path, 'caption' => $request->caption ]);

            return response()->json([
                'status' => 201,
                'message' => "Slider added successfully.",
            ], 201);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 203,
                'message' => 'Error creating slider. Please try again.'
            ], 203);
        }
    }

    /**
     * Delete Slider
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function deleteSlider(Request $request)
    {
        try {
            Slider::find($request->slider)->delete();
            return response()->json([
                'status' => 200,
                'message' => "Slider deleted.",
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 203,
                'message' => 'Sorry, slider could not be deleted. Please try again.'
            ], 203);
        }
    }
}