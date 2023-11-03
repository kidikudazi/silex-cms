<?php

namespace App\Http\Controllers;

use App\Models\{
    BlogPost
};
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{
    Auth,
    Session,
    Validator,
    View,
};
use Intervention\Image\Facades\Image;

class BlogPostController extends Controller
{
    use Helper;

    /**
     * Blog Post Page
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function blogPost(Request $request)
    {
        try {
            if($this->roleCheck("blog") == false) return redirect()->route('admin.home');
            return view::make('admin.blog_post');
        } catch (\Exception $ex) {
            return redirect()->to('/');
        }
    }

    /**
     * Create Blog Post
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function createBlogPost(Request $request)
    {
        try {
            $auth = Auth::user();

            $rules = [
                'title' => 'required',
                'body' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10096',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $validateBlogPost = BlogPost::where('title', $request->title)->first();
            if ($validateBlogPost) {
               $error = Session::flash('error', 'An article with this title already exist');
               return redirect()->back()->with($error)->withInput();
            }

            # upload image
            $imageFile = $request->file('image');
            $extension = $imageFile->getClientOriginalExtension();
            $name = 'IMG'.'_'.time().'.'.Str::uuid();
            $path = "blog/{$name}.{$extension}";

            $image = Image::make($imageFile->getRealPath())->resize(360, 245, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 75);
            $url = $this->storeFile($path, (string)$image, 'public');

            BlogPost::create([
                'title' => $request->title,
                'body' => $request->body,
                'user_id' => $auth->id,
                'slug' => Str::slug($request->title),
                'is_published' => true,
                'image' => $url,
                'key' => $path,
            ]);

            $success = Session::flash('success', 'Blog post created successfully');
            return redirect()->route('admin.manage_blog_posts')->with($success);
        } catch (\Exception $ex) {
            $error = Session::flash('error', 'Sorry an error occurred');
            return redirect()->back()->with($error)->withInput();
        }
    }

    /**
     * Manage Blog Posts
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */ 
    public function manageBlogPosts(Request $request)
    {
        try {
            if($this->roleCheck("blog") == false) return redirect()->route('admin.home');

            # filter blog post using search keyword
            if ($request->has('keyword')) {
                return view::make('admin.manage_blog_posts')->with([
                    'posts' => BlogPost::with(['user' => function ($query) {
                        $query->withTrashed();
                    }])->orderBy('created_at', "DESC")->where(function ($query) use($request) {
                        $query->where('title', 'LIKE', "%$request->keyword%")->orWhereHas('user', function($query) use($request) {
                            $query->where('name', 'LIKE', "%$request->keyword%");
                        });
                    })->simplePaginate(6),
                ]);
            }

            # blog post withoug search keyword
            $posts = BlogPost::with(['user' => function ($query) {
                $query->withTrashed();
            }])->orderBy('created_at', 'DESC')->simplePaginate(6);

            return view::make('admin.manage_blog_posts')->with([ 'posts' => $posts ]);
        } catch (\Exception $ex) {
            return redirect()->back();
        }
    }

    /**
     * Edit Blog Post
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function editBlogPost(Request $request, $post)
    {
        try {
            $data = BlogPost::where('slug', $post)->firstOrFail();
            return view::make('admin.blog_post')->with(['edit' => $data ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.home');
        }
    }

    /**
     * Update Blog Post
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */ 
    public function updateBlogPost(Request $request, $post)
    {
        try {
            $rules = [
                'title' => 'required',
                'body' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $verifyBlogPost = BlogPost::where('slug', $post)->firstOrFail();

            $validateBlogPost = BlogPost::where('title', $request->title)->first();
            if ($validateBlogPost && $validateBlogPost->id != $verifyBlogPost->id) {
               $error = Session::flash('error', 'A blog post with this title already exist');
               return redirect()->back()->with($error);
            }

            if ($request->hasFile('image')) {
                $rules = [
                    'image' => 'required|image|mimes:jpeg,png,jpg|max:10096'
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                # delete previous image
                if (!empty($validateBlogPost->key)) {
                    $this->removeFile($validateBlogPost->key);
                }

                # upload image
                $imageFile = $request->file('image');
                $extension = $imageFile->getClientOriginalExtension();
                $name = 'IMG'.'_'.time().'.'.Str::uuid();
                $path = "blog/{$name}.{$extension}";

                $image = Image::make($imageFile->getRealPath())->resize(360, 245, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('jpg', 75);
                $url = $this->storeFile($path, (string)$image, 'public');

                BlogPost::where('slug', $post)->update([
                    'title' => $request->title,
                    'body' => $request->body,
                    'slug' => Str::slug($request->title),
                    'image' => $url,
                    'key' => $path
                ]);
    
                $success = Session::flash('success', 'Blog post updated successfully');
                return redirect()->route('admin.manage_blog_posts')->with($success);
            } else {
                BlogPost::where('slug', $post)->update([
                    'title' => $request->title,
                    'body' => $request->body,
                    'slug' => Str::slug($request->title)
                ]);
    
                $success = Session::flash('success', 'Blog post updated successfully');
                return redirect()->route('admin.manage_blog_posts')->with($success);
            }
        } catch (\Exception $ex) {
            $error = Session::flash('error', 'Sorry an error occurred');
            return redirect()->back()->with($error);
        }
    }

    /**
     * Delete Blog Post
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function deleteBlogPost(Request $request)
    {
        try {
            $post = BlogPost::find($request->post);
            
            if (!empty($post->key)) {
                $this->removeFile($post->key);
            }
            
            $post->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Blog post deleted successfully',
            ], 200);
        } catch (\Exception) {
            return response()->json([
                'status' => 203,
                'message' => 'Sorry, an error occurred. Blog post could not be delete.'
            ], 203);
        }
    }
}