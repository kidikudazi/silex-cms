<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{
    View,
    Auth,
    Validator,
    Session,
    Hash
};
use App\Models\{
    Gallery,
    User
};
use App\Traits\Helper;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    use Helper;

    /**
     * Gallery Page
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function gallery(Request $request)
    {
        try {
            if($this->roleCheck("gallery") == false) return redirect()->route('admin.home');
            $galleries = Gallery::orderBy('created_at', 'DESC')->simplePaginate(9);
            return view::make('admin.gallery')->with([ "galleries" => $galleries ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.home');
        }
    }

    /**
     * Upload Gallery File
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function uploadGalleryFile(Request $request)
    {
        try {
            $rules = [ 'image' => 'required|image|mimes:jpeg,png,jpg|max:10096', 'caption' => 'sometimes' ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 403);
            }

            # upload image
            $imageFile = $request->file('image');
            $extension = $imageFile->getClientOriginalExtension();
            $name = 'IMG'.'_'.time().'.'.Str::uuid();
            $path = "gallery/{$name}.{$extension}";

            $image = Image::make($imageFile->getRealPath())->resize(540, 370, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 75);
            $url = $this->storeFile($path, (string)$image, 'public');

            Gallery::create([
                "url" => $url, 
                "key" => $path, 
                "caption" => $request->caption ?? NULL 
            ]);
            
            return response()->json([
                "status" => 201,
                "message" => "Gallery file upload successfully"
            ], 201);
        } catch (\Exception $ex) {
            dd($ex);
            return response()->json([
                "status" => 203,
                "message" => "Gallery file upload failed. Please try again."
            ], 203);
        }
    }

    /**
     * Delete Gallery File
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function deleteGalleryFile(Request $request)
    {
        try {
            $gallery = Gallery::find($request->gallery);
            $this->removeFile($gallery->key);
            $gallery->delete();
            return response()->json([
                "status" => 200,
                "message" => "Gallery file deleted."
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                "status" => 203,
                "message" => "Error deleting gallery file. Please try again."
            ], 203);
        }
    }
}