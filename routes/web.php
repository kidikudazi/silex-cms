<?php

use App\Http\Controllers\{
    AdminController,
    WebController,
    AuthController,
    BlogPostController,
    GalleryController,
    PartnerController,
    PageController,
    TeamController,
    UtilityController,
    MenuController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# web views
Route::group([
    'prefix' => '/'
], function () {
    Route::controller(WebController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('about', 'about')->name('about');
        Route::get('blog', 'blog')->name('blog');
        Route::get('blog/{slug}', 'blogDetails')->name('blog_details');
        Route::get('contact', 'contact')->name('contact');
        Route::post('contact', 'sendContactMessage')->name('contact_message');
        Route::get('gallery', 'gallery')->name('gallery');
        Route::get('videos', 'videos')->name('videos');
        Route::get('team', 'team')->name('team');
    });
});

# admin
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'user.auth']
], function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('home', [AdminController::class, 'index'])->name('admin.home');
        Route::get('profile', 'profile')->name('admin.profile');
        Route::post('profile', 'updateProfile')->name('admin.update_profile');
        Route::post('security', 'updateSecurity')->name('admin.update_security');
        Route::get('users', 'users')->name('admin.users');
        Route::group([
            'prefix' => 'user'
        ], function () {
            Route::post('create', 'registerUser')->name('admin.register_user');
            Route::get('edit', 'editUser')->name('admin.edit_user');
            Route::post('update', 'updateUser')->name('admin.update_user');
            Route::any('role', 'manageUserRole')->name('admin.manage_user_role');
            Route::delete('delete', 'deleteUser')->name('admin.delete_user');
        });
        Route::post('logout', 'logout')->name('logout');
    });

    Route::controller(BlogPostController::class)->group(function () {
        Route::get('blog/post', 'blogPost')->name('admin.blog_post');
        Route::post('blog/post', 'createBlogPost')->name('admin.create_blog_post');
        Route::get('manage/blog/posts', 'manageBlogPosts')->name('admin.manage_blog_posts');
        Route::get('blog/post/{post}', 'editBlogPost')->name('admin.edit_blog_post');
        Route::post('blog/post/{post}', 'updateBlogPost')->name('admin.update_blog_post');
        Route::delete('blog/post/delete', 'deleteBlogPost')->name('admin.delete_blog_post');
    });

    Route::controller(UtilityController::class)->group(function () {
        Route::get('site/setting', 'siteSetting')->name('admin.site_setting');
        Route::post('site/setting', 'updateSiteSetting')->name('admin.update_setting');
        Route::get('videos', 'videos')->name('admin.videos');
        Route::post('videos', 'uploadVideo')->name('admin.upload_video');
        Route::delete('video/delete', 'deleteVideo')->name('admin.delete_video');
        Route::get('sliders', 'slider')->name('admin.sliders');
        Route::post('sliders', 'createSlider')->name('admin.create_slider');
        Route::delete('slider/delete', 'deleteSlider')->name('admin.delete_slider');
    });

    Route::controller(GalleryController::class)->group(function () {
        Route::get('gallery', 'gallery')->name('admin.gallery');
        Route::post('gallery', 'uploadGalleryFile')->name('admin.upload_gallery_file');
        Route::delete('gallery/delete', 'deleteGalleryFile')->name('admin.delete_gallery_file');
    });

    Route::controller(PartnerController::class)->group(function () {
        Route::get('partner', 'partner')->name('admin.partner');
        Route::post('partner', 'createPartner')->name('admin.create_partner');
        Route::delete('partner/delete', 'deletePartner')->name('admin.delete_partner');
    });

    Route::controller(TeamController::class)->group(function () {
        Route::get('team', 'teams')->name('admin.team');
        Route::post('team', 'createTeamMember')->name('admin.create_team_member');
        Route::delete('team/delete', 'deleteTeamMember')->name('admin.delete_team_member');
    });

    Route::controller(PageController::class)->group(function () {
        Route::group([
            'prefix' => 'page'
        ], function () {
            Route::get('/', 'pages')->name('admin.pages');
            Route::get('/add', 'addPage')->name('admin.add_page');
            Route::post('/add', 'createPage')->name('admin.create_page');
            Route::get('/edit/{uuid}', 'editPage')->name('admin.editPage');
            Route::post('/edit/{uuid}', 'updatePage')->name('admin.update_page');
            Route::delete('/delete', 'deletePage')->name('admin.delete_page');
        });
    });

    Route::controller(MenuController::class)->group(function () {
        Route::group([
            'prefix' => 'menu'
        ], function () {
            Route::get('/', 'menu')->name('admin.menu');
            Route::get('/add', 'addMenu')->name('admin.add_menu');
            Route::post('/add', 'createMenu')->name('admin.create_menu');
            Route::get('/edit/{uuid}', 'editMenu')->name('admin.edit_menu');
            Route::post('/edit/{uuid}', 'updateMenu')->name('admin.update_menu');
            Route::delete('/delete', 'deleteMenu')->name('admin.delete_menu');
        });
    });
});

# auth
Route::group([
    'prefix' => 'auth'
], function () {
    Route::view('login', 'auth.login')->name('login');
    Route::view('reset/password', 'auth.reset_password')->name('reset_password');
    Route::controller(AuthController::class)->group(function () {
        Route::get('new/password/{token}', 'verifyPasswordToken');
        Route::post('login', 'login');
        Route::post('reset/password', 'resetPassword');
        Route::post('new/password/{token}', 'updatePassword');
    });
});

# page viewer
Route::controller(WebController::class)->group(function () {
    Route::get('/{menu}', 'page');
    Route::get('/{menu}/{sub_menu}', 'page');
    Route::get('/{menu}/{sub_menu}/{link}', 'page');
});