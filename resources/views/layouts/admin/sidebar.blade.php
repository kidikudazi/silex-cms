@php
    $role = \Session::get('role');    
@endphp
<div 
    id="kt_app_sidebar" 
    class="app-sidebar flex-column" 
    data-kt-drawer="true" 
    data-kt-drawer-name="app-sidebar" 
    data-kt-drawer-activate="{default: true, lg: false}" 
    data-kt-drawer-overlay="true" 
    data-kt-drawer-width="225px" 
    data-kt-drawer-direction="start" 
    data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle"
>
    <div class="app-sidebar-logo px-6" style="background-color: white;" id="kt_app_sidebar_logo" >
        <a href="{{ route('admin.home') }}">
            <img 
                src="{{ asset('assets/frontend/images/logos/logo.png') }}" 
                alt="ANRIN"
                class="img-responsive"
                height="50px;"
            >
        </a>
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div
            id="kt_app_sidebar_menu_wrapper" 
            class="app-sidebar-wrapper hover-scroll-overlay-y my-5" 
            data-kt-scroll="true" 
            data-kt-scroll-activate="true" 
            data-kt-scroll-height="auto" 
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" 
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" 
            data-kt-scroll-offset="5px" 
            data-kt-scroll-save-state="true"
        >
            <div 
                class="menu menu-column menu-rounded menu-sub-indention px-3" 
                id="#kt_app_sidebar_menu" 
                data-kt-menu="true" 
                data-kt-menu-expand="false"
            >
                <div class="menu-item here show">
                    <a class="menu-link" href="{{ route('admin.home') }}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>
                @if ($role->account === true)
                    <div class="menu-item pt-5">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7">Account</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('admin.users') }}">
                            <span class="menu-icon">
                                <i class="bi bi-person-lines-fill fs-3"></i>
                            </span>
                            <span class="menu-title">User Account</span>
                        </a>
                    </div>
                @endif
                <div class="menu-item pt-5">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">Others</span>
                    </div>
                </div>
                @if ($role->blog === true)
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="bi bi-file-earmark-richtext fs-3"></i>
                            </span>
                            <span class="menu-title">Blog</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('admin.blog_post') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">New Blog Post</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('admin.manage_blog_posts') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Manage Blog Posts</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($role->videos === true)
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('admin.videos') }}">
                            <span class="menu-icon">
                            <i class="bi bi-film fs-3"></i>
                            </span>
                            <span class="menu-title">Videos</span>
                        </a>
                    </div>
                @endif
                @if ($role->gallery === true)    
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('admin.gallery') }}">
                            <span class="menu-icon">
                            <i class="bi bi-hr fs-3"></i>
                            </span>
                            <span class="menu-title">Gallery</span>
                        </a>
                    </div>
                @endif
                @if ($role->team === true)
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('admin.team') }}">
                            <span class="menu-icon">
                            <i class="bi bi-people fs-3"></i>
                            </span>
                            <span class="menu-title">Team</span>
                        </a>
                    </div>
                @endif
                @if ($role->partners === true)    
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('admin.partner') }}">
                            <span class="menu-icon">
                            <i class="bi bi-people fs-3"></i>
                            </span>
                            <span class="menu-title">Partners</span>
                        </a>
                    </div>
                @endif
                @if ($role->site_settings === true || $role->page_builder === true)    
                    <div class="menu-item pt-5">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7">Settings</span>
                        </div>
                    </div>
                    @if ($role->page_builder === true)
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="bi bi-sliders fs-3"></i>
                                </span>
                                <span class="menu-title">Page Builder</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link" href="{{ route('admin.sliders') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Sliders</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="{{ route('admin.menu') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Menus</span>
                                    </a>
                                </div>
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <span class="menu-link">
                                        <span class="menu-bullet">
                                            <i class="bullet bullet-dot"></i>
                                        </span>
                                        <span class="menu-title">Page</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion">
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{ route('admin.add_page') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">New Page</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{ route('admin.pages') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Manage Pages</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>                               
                            </div>
                        </div>
                    @endif
                    @if ($role->site_settings === true)
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('admin.site_setting') }}">
                                <span class="menu-icon">
                                    <i class="bi bi-gear fs-3"></i>
                                </span>
                                <span class="menu-title">Site Settings</span>
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>