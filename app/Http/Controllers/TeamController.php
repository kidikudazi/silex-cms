<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Traits\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{
    Auth,
    Session,
    Validator,
    View,
};
use Intervention\Image\Facades\Image;

class TeamController extends Controller
{
    use Helper;

    /**
     * Teams Page
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function teams(Request $request)
    {
        try {
            if($this->roleCheck("team") == false) return redirect()->route('admin.home');
            $teams = Team::orderBy('created_at', 'DESC')->get();
            return view::make('admin.team')->with([ "teams" => $teams ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.home');
        }
    }

    /**
     * Create Team Member
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function createTeamMember(Request $request)
    {
        try {
            $rules = [
                'name' => 'required',
                'position' => 'required',                
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
            $path = "teams/{$name}.{$extension}";

            $image = Image::make($imageFile->getRealPath())->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 75);
            $url = $this->storeFile($path, (string)$image, 'public');

            Team::create([
                "name" => $request->name,
                "position" => $request->position,
                "image" => $url, 
                "key" => $path, 
            ]);
            
            return response()->json([
                "status" => 201,
                "message" => "Team member created successfully."
            ], 201);
        } catch (\Exception $ex) {
            return response()->json([
                "status" => 203,
                "message" => "Error creating team member."
            ], 203);
        }
    }

    /**
     * Delete Team Member
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function deleteTeamMember(Request $request)
    {
        try {
            $post = Team::find($request->member);
            $this->removeFile($post->key);
            $post->delete();
            return response()->json([
                "status" => 200,
                "message" => "Team member deleted."
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 203,
                "message" => "Error deleting team member. Please try again."
            ], 203);
        }
    }
}