<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Traits\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{
    Auth,
    Session,
    Validator,
    View,
};
use Intervention\Image\Facades\Image;

class PartnerController extends Controller
{
    use Helper;

    /**
     * Partner Page
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function partner(Request $request)
    {
        try {
            if($this->roleCheck("partners") == false) return redirect()->route('admin.home');
            $partners = Partner::orderBy('created_at', 'DESC')->get();
            return view::make('admin.partner')->with(["partners" => $partners]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.home');
        }
    }

    /**
     * Create Partner
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function createPartner(Request $request)
    {
        try {
            $rules = [
                'name' => 'required',               
                'image' => 'required|image|mimes:jpeg,png,jpg|max:10096'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 403);
            }

            # upload image
            $imageFile = $request->file('image');
            $extension = $imageFile->getClientOriginalExtension();
            $name = 'IMG'.'_'.time().'.'.Str::uuid();
            $path = "partners/{$name}.{$extension}";

            $image = Image::make($imageFile->getRealPath())->resize(200, 120, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 75);
            $url = $this->storeFile($path, (string)$image, 'public');

            Partner::create([
                "name" => $request->name,
                "image" => $url, 
                "key" => $path, 
            ]);

            return response()->json([
                "status" => 201,
                "message" => "Partner added successfully."
            ], 201);
        } catch (\Exception $ex) {
            return response()->json([
                "status" => 203,
                "message" => "Error adding partner data."
            ], 203);
        }
    }

    /**
     * Delete Partner
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function deletePartner(Request $request)
    {
        try {
            $partner = Partner::find($request->partner);
            $this->removeFile($partner->key);
            $partner->delete();
            return response()->json([
                "status" => 200,
                "message" => "Partner data deleted."
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                "status" => 203,
                "message" => "Error deleting partner data."
            ], 203);
        }
    }
}