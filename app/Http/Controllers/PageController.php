<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Page,
    Menu
};
use Illuminate\Support\Facades\{
    Session,
    View,
    Validator
};
use Illuminate\Support\Str;
use App\Traits\Helper;
use Carbon\Carbon;

class PageController extends Controller
{
    use Helper;

    /**
     * Pages
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Page $pages
     * @param \App\Models\Menu $menus
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function pages(Request $request, Page $pages, Menu $menus)
    {
        try {
            return view::make('admin.pages')->with([ 
                'pages' =>  $pages->with(['menu' => function($query){
                    $query->select("title", "id");
                }])->orderBy('created_at', 'DESC')->get(["uuid", "title", "menu_id", "created_at"])
            ]);
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            return redirect()->route('admin.home');
        }
    }

    /**
     * Add Page
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menus
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function addPage(Request $request, Menu $menus)
    {
        try {
            return view::make('admin.add_page')->with([
                'menus' => $menus->where('is_sub', true)->orderBy('title', 'ASC')->get()
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.home');
        }
    }

    /**
     * Create Page
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Page $pages
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function createPage(Request $request, Page $pages)
    {
        try {
            $rules = [
                'title' => 'required',
                'content' => 'required',
                'menu' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $checkPageExistence = $pages->where('title', $request->title)->where('menu_id', $request->menu)->first();
            if ($checkPageExistence) {
                $error = Session::flash('error', "A page with this title already exist for the selected menu.");
                return redirect()->back()->with($error)->withInput();
            }

            $pages->create([
                'uuid' => $this->checkField($pages, 'uuid', Str::uuid()),
                'title' => $request->title,
                'content' => $request->content,
                'menu_id' => $request->menu,
                'slug' => Str::slug(strtolower($request->title))
            ]);

            $message = Session::flash('success', 'Page created successfully.');
            return redirect()->route('admin.pages')->with($message);
        } catch (\Exception $ex) {
            $error = Session::flash('error', 'Error creating page. Please try again.');
            return redirect()->back()->withInput()->with($error);
        }
    }

    /**
     * Edit Page
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Page $pages
     * @param \App\Models\Menu $menus
     * @param string $uuid
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function editPage(Request $request, Page $pages, Menu $menus, $uuid)
    {
        try {
            return view::make('admin.add_page')->with([
                'menus' => $menus->where('is_sub', true)->orderBy('title', 'ASC')->get(),
                'edit' => $pages->where('uuid', $uuid)->first()
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.home');
        }
    }

    /**
     * Update Page
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Page $pages
     * @param string $uuid
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function updatePage(Request $request, Page $pages, $uuid)
    {
        try {
            $rules = [
                'title' => 'required',
                'content' => 'required',
                'menu' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $checkPageExistence = $pages->where('title', $request->title)->where('menu_id', $request->menu)->first();
            if ($checkPageExistence && $checkPageExistence->uuid != $uuid) {
                $error = Session::flash('error', "A page with this title already exist for the selected menu.");
                return redirect()->back()->with($error)->withInput();
            }

            $pages->where('uuid', $uuid)->first()->update([
                'title' => $request->title,
                'content' => $request->content,
                'menu_id' => $request->menu,
                'slug' => Str::slug(strtolower($request->title))
            ]);

            $message = Session::flash('success', 'Page update successfully.');
            return redirect()->route('admin.pages')->with($message);
        } catch (\Exception $ex) {
            $error = Session::flash('error', 'Error updating page.');
            return redirect()->back()->withInput()->with($error);
        }
    }

    /**
     * Delete Programme
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Page $pages
     * @param \App\Models\Menu $menus
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function deletePage(Request $request, Page $pages, Menu $menus)
    {
        try {
            $toDelete = $pages->where('uuid', $request->uuid)->first();
            $toDelete->delete();

            $data = collect();
            $pages->with('menu')->get()->each(function ($page) use ($data, $menus){
                $data->push((Object)[
                    "uuid" => $page->uuid,
                    "title" => $page->title,
                    "menu" => $page->menu->title,
                    "last_modified" => Carbon::parse($page->updated_at)->format('jS M, Y')
                ]);
            });

            return response()->json([
                'status' => 200, 
                'message' => 'Page deleted.',
                'data' => $data
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 203,
                'message' => 'Error deleting page'
            ], 203);
        }
    }
}