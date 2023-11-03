<?php

namespace App\View\Components;

use App\Models\{
    Menu,
    ReportCategory,
    SiteSetting
};
use Illuminate\View\Component;

class WebHeader extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $data = collect();
        $menus = Menu::orderBy('title', 'ASC')->get(["uuid", "title", "is_sub", "parent", "slug"]);
        $menus->each(function($menu) use ($data) {
            if ((int) $menu->is_sub === 0) {
                $data->push((Object) [
                    "uuid"  => $menu->uuid,
                    "title" => $menu->title,
                    "slug"  => $menu->slug,
                    "children" => Menu::with(['pages' => function ($query) {
                        $query->select("title", "uuid", "slug", "menu_id");
                    }])->where('parent', $menu->uuid)->get(["uuid", "title", "slug", "id"]),
                ]);
            }
        });


        $siteSetting = SiteSetting::first();
        
        return view('components.web-header')->with([
            'menus' => $data, 
            'categories' => [],
            'site_setting' => $siteSetting
        ]);
    }
}