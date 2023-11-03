<header class="header">
  <div class="header-top bg-theme-colored sm-text-center p-0">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="widget no-border m-0">
            <ul class="styled-icons icon-theme-colored icon-dark icon-circled icon-sm pull-left sm-pull-none sm-text-center mt-5 mt-sm-15">
              @php $siteSetting =  \DB::table('site_settings')->first(); @endphp
              @foreach (json_decode($siteSetting->socials) ?? [] as $social => $value)                  
                <li><a href="https://{{$social}}.com/{{$value}}" target="_blank"><i class="fa fa-{{$social}}"></i></a></li>
              @endforeach              
            </ul>
          </div>
        </div>
        <div class="col-md-8">
          <div class="widget no-border m-0 mt-10">
            <ul class="list-inline sm-text-center pull-right">
              <li class="mt-sm-10 mb-sm-10">
                <a class="btn btn-default btn-flat btn-xs bg-light p-5 font-11 pl-10 pr-10" href="{{ route('login') }}">
                  Login
                </a>
              </li> 
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="header-middle p-0 bg-lightest xs-text-center">
    <div class="container pt-0 pb-0">
      <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-8">
          <div class="widget no-border m-0">
            <a class="menuzord-brand pull-left flip xs-pull-center mb-15" href="{{ route('index') }}">
              <img src="{{ asset('assets/frontend/images/logos/logo.png') }}" alt="">
            </a>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-2">
          <div class="widget no-border m-0">
            <div class="mt-10 mb-10 text-right flip sm-text-center">
              @foreach (json_decode($siteSetting->phone_numbers) ?? [] as $number => $value)                
                <div class="font-15 text-black-333 mb-5 font-weight-600">
                  <i class="fa fa-phone-square text-theme-colored font-18"></i> {{ $value }}
                </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-2">
          <div class="widget no-border m-0">
            <div class="mt-10 mb-10 text-right flip sm-text-center">
              <div class="font-15 text-black-333 mb-5 font-weight-600">
                <i class="fa fa-building-o text-theme-colored font-18"></i> Office Location
              </div>
              <a class="font-12 text-gray">{{ $site_setting->address ?? "" }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="header-nav">
    <div class="header-nav-wrapper navbar-scrolltofixed bg-light">
      <div class="container-fluid">
        <nav id="menuzord" class="menuzord default bg-light">
          <ul class="menuzord-menu">
            <li class="menu">
              <a href="{{ route('index') }}">Home</a>
              <ul class="dropdown">
                <li><a href="{{ route('about') }}">About</a></li>
              </ul>
            </li>
            @foreach ($menus as $menu)
              <li class="menu">
                <a href="{{ url("/{$menu->slug}") }}">{{ $menu->title }}</a>
                @if (count($menu->children))
                  <ul class="dropdown">
                    @foreach ($menu->children as $child)
                      <li>
                        <a href="{{ url("/{$menu->slug}/{$child->slug}/") }}">{{ $child->title }}</a>
                        @if (count($child->pages))
                          <ul class="dropdown">
                            @foreach ($child->pages as $page)
                              <li>
                                <a href="{{ url("/{$menu->slug}/{$child->slug}/{$page->slug}") }}">{{ $page->title }}</a>
                              </li>
                            @endforeach
                          </ul>
                        @endif
                      </li>  
                    @endforeach
                  </ul>
                @endif
              </li>
            @endforeach            
          </ul>
        </nav>
      </div>
    </div>
  </div>
</header>