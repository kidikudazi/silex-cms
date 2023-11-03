<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use App\Models\{
    BlogPost,
    Gallery,
    Menu,
    Partner,
    Video,
    Page,
    Team
};
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Session,
    View,
    Mail,
    Validator
};

class WebController extends Controller
{
    use Helper;

    /**
     * Index
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BlogPost $posts
     * @param \App\Models\Gallery $galleries
     * @param \App\Models\Partner $partners
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request, BlogPost $posts, Gallery $galleries, Partner $partners)
    {
        return view::make('index')->with([
            'posts' => $posts->with(['user' => function ($query) {
                $query->withTrashed();
            }])->orderBy('created_at', "DESC")->simplePaginate(3),
            "galleries" => $galleries->orderBy('created_at', 'DESC')->get()->take(12),
            "partners" => $partners->orderBy('created_at', 'DESC')->get()
        ]);
    }

    /**
     * About
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function about(Request $request)
    {
        return view('about');
    }

    /**
     * Blog
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BlogPost $post
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function blog(Request $request, BlogPost $posts)
    {
        try {
            if ($request->has('keyword')) {
                return view::make('blog')->with([
                    'posts' => $posts->with(['user' => function ($query) {
                        $query->withTrashed();
                    }])->orderBy('created_at', "DESC")->where(function ($query) use($request) {
                        $query->where('title', 'LIKE', "%$request->keyword%")->orWhereHas('user', function ($query) use($request) {
                            $query->where('name', 'LIKE', "%$request->keyword%");
                        });
                    })->simplePaginate(6)
                ]);
            }

            return view::make('blog')->with([
                'posts' => $posts->with(['user' => function ($query) {
                    $query->withTrashed();
                }])->orderBy('created_at', "DESC")->simplePaginate(6)
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('index');
        }
    }

    /**
     * Blog Details
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BlogPost $post
     * @param string $slug
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function blogDetails(Request $request, BlogPost $post, $slug)
    {
        try {
            $post->where('slug', $slug)->increment('views');      
            return view::make('blog_details')->with([
                'post' => $post->with(['user' => function($query) {
                    $query->withTrashed();
                }])->where('slug', $slug)->first(),
                'related' => $post->with(['user' => function($query) {
                    $query->withTrashed();
                }])->where('slug', '!=', $slug)->orderBy('views', 'DESC')->get()->take(6)
            ]);
        } catch (\Exception $ex) {
            return abort(404);
        }
    }

    /**
     * Contact
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function contact(Request $request)
    {
        return view::make('contact');
    }

    /**
     * Send Contact Message
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function sendContactMessage(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|min:3|max:100',
                'email' => 'required|email|max:100',
                'subject' => 'required|min:3|max:150',
                'message' => 'required|min:5'
            ];

            # validator
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            # collate data
            $fullname = $request->name;
            $email = $request->email;
            $subject = $request->subject;
            $content = $request->message;

            # convert fullname to sentence
            $fullname = ucwords(strtolower($fullname));

            # send message
            try {
                # mail data
                $data = [
                    'fullname' => $fullname,
                    'email' => $email,
                    'subject' => $subject,
                    'content' => $content
                ];

                # receiver mail
                $receiver_mail = $this->sender_mail;

                # send message
                Mail::to($receiver_mail)->send(new ContactMessage($data, $subject));
                
                return response()->json([
                    'status' => 200,
                    'message' => 'Message sent successfully.'
                ], 200);
            } catch(\Exception $ex) {
                return response()->json([
                    'status' => 203,
                    'message' => 'Sorry, your message could not be sent. Try again later.'
                ], 203);
            }
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 203,
                'message' => 'Message could not be sent. Please try again'
            ], 203);
        }
    }

    /**
     * Gallery
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Gallery $galleries
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function gallery(Request $request, Gallery $galleries)
    {
        try {
            return view::make('gallery')->with([
                "galleries" => $galleries->orderBy('created_at', 'DESC')->get()
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('index');
        }
    }

    /**
     * Page
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function page(Request $request)
    {
        try {
            $path = explode("/", $request->path());
            switch ($path) {
                case count($path) === 1:
                    return view::make('page')->with([
                        'data' => Menu::where('slug', $path[0])->first()
                    ]);
                break;

                case count($path) === 2:
                    return view::make('page')->with([
                        'data' => Menu::where('slug', $path[1])->where('is_sub', true)->first()
                    ]);
                break;

                case count($path) === 3;
                    $assignMenu = Menu::where('slug', $path[1])->where('is_sub', true)->first();
                    return view::make('page')->with([
                        'data' => Page::where('slug', $path[2])->where('menu_id', $assignMenu->id)->first()
                    ]);
                break;
                
                default:
                    return redirect()->route('index');
                break;
            }
        } catch (\Exception $ex) {
            return redirect()->route('index');
        }
    }

    /**
     * Videos
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Video $videos
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function videos(Request $request, Video $videos)
    {
        try {
            return view::make('videos')->with([ "videos" => $videos->simplePaginate(12) ]);
        } catch (\Exception $ex) {
            return redirect()->route('index');
        }
    }

    /**
     * Team
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $teams
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function team(Request $request, Team $teams)
    {
        try {
            return view::make('team')->with([ "teams" => $teams->simplePaginate(12) ]);
        } catch (\Exception $ex) {
            return redirect()->route('index');
        }
    }   
}