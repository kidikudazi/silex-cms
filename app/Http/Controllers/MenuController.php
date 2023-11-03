<?php

namespace App\Http\Controllers;

use App\Models\{
    Menu,
    Page
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Session,
    Validator,
    View
};
use Illuminate\Support\Str;
use App\Traits\Helper;

class MenuController extends Controller
{
    use Helper;

    /**
     * Menu
     * @param \Illuminate\Http\Request $request
     * @param \App\Models Menu $menus
     * @param \App\Models\Page $page
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function menu(Request $request, Menu $menus, Page $page)
    {
        try {
            $list = collect();
            $menus->withCount('pages')->get(['id', 'uuid', 'title', 'is_sub', 'parent'])->each(function ($menu) use($list) {
                $check = Menu::where('uuid', $menu->parent)->first();
                $list->push((Object)[
                    "uuid" => $menu->uuid,
                    "title" => $menu->title,
                    "is_sub" => $menu->is_sub,
                    "pages" => $menu->pages_count,
                    "main" => $check ? $check->title : "N/A"
                ]);
            });
            return view::make('admin.menu')->with([ "menus" => $list ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.home');
        }
    }

    /**
     * Add Menu Page
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menus
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function addMenu(Request $request, Menu $menus)
    {
        try {
            return view::make('admin.add_menu')->with([
                'menus' => $menus->where('is_sub', false)->orderBy('created_at', 'DESC')->get()
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.home');
        }
    }

    /**
     * Create Menu
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menus
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function createMenu(Request $request, Menu $menus)
    {
        try {
            $rules = [
                'title' => 'required',
                'content' => 'required',
                'category' => 'sometimes',
                'type' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $checkProgrammeExistence = $menus->where('title', $request->title)->first();
            if ($checkProgrammeExistence) {
                $error = Session::flash('error', "A menu with this title already exist.");
                return redirect()->back()->with($error)->withInput();
            }

            $menus->create([
                'uuid' => $this->checkField($menus, 'uuid', Str::uuid()),
                'title' => $request->title,
                'content' => $request->content,
                'is_sub' => $request->type === "main" ? false : true,
                'parent' => $request->category ?? NULL,
                'slug' => Str::slug(strtolower($request->title))
            ]);

            $message = Session::flash('success', 'Menu created successfully.');
            return redirect()->route('admin.menu')->with($message);
        } catch (\Exception $ex) {
            $error = Session::flash('error', 'Error creating menu. Please try again');
            return redirect()->back()->with($error)->withInput();
        }
    }

    /**
     * Edit Menu
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menus
     * @param string $uuid
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function editMenu(Request $request, Menu $menus, $uuid)
    {
        try {
            return view::make('admin.add_menu')->with([
                'menus' => $menus->where('is_sub', false)->orderBy('created_at', 'DESC')->get(),
                'edit' => $menus->where('uuid', $uuid)->first()
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.home');
        }
    }

    /**
     * Update Menu
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menus
     * @param string $uuid
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function updateMenu(Request $request, Menu $menus, $uuid)
    {
        try {
            $rules = [
                'title' => 'required',
                'content' => 'required',
                'category' => 'sometimes'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $checkMenuExistence = $menus->where('title', $request->title)->first();
            if ($checkMenuExistence && $checkMenuExistence->uuid != $uuid) {
                $error = Session::flash('error', "A menu with this title already exist.");
                return redirect()->back()->with($error)->withInput();
            }

            $menus->where('uuid', $uuid)->first()->update([
                'title' => $request->title,
                'content' => $request->content,
                'is_sub' => $request->type === "main" ? false : true,
                'parent' => $request->category ?? NULL,
                'slug' => Str::slug(strtolower($request->title))
            ]);

            $message = Session::flash('success', 'Menu update successfully.');
            return redirect()->route('admin.menu')->with($message);
        } catch (\Exception $ex) {
            $error = Session::flash('error', 'Error updating menu.');
            return redirect()->back()->withInput()->with($error);
        }
    }

    /**
     * Delete Menu
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menus
     * @param \App\Models\Page $pages
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function deleteMenu(Request $request, Menu $menus, Page $pages)
    {
        try {
            $toDelete = $menus->where('uuid', $request->uuid)->first();
            if ($toDelete && (int) $toDelete->is_sub === 0) {
                $subs = $menus->where('parent', $request->uuid)->get();
                $subs->each(fn ($sub) => $sub->delete() );
            }
            if ($toDelete && (int) $toDelete->is_sub === 1) {
                $pages = $pages->where('menu_id', $toDelete->id)->get();
                $pages->each(fn ($page) => $page->delete() );
            }
            
            # delete actual menu
            $toDelete->delete();

            $data = collect();
            $menus->withCount('pages')->get(['id', 'uuid', 'title', 'is_sub', 'parent'])->each(function ($menu) use($data) {
                $check = Menu::where('uuid', $menu->parent)->first();                
                $data->push((Object)[
                    "uuid" => $menu->uuid,
                    "title" => $menu->title,
                    "category" => (int) $menu->is_sub === 0 ? "Main Menu" : "Sub Menu",
                    "pages" => $menu->pages_count,
                    "main" => $check ? $check->title : "N/A"
                ]);
            });

            return response()->json([ 
                'status' => 200, 
                'message' => 'Menu deleted.',
                'data' => $data,
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 203,
                'message' => 'Error deleting menu'
            ], 203);
        }
    }
}