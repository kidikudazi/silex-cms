<footer id="footer" class="footer" data-bg-color="#25272e">
    <div class="container pt-70 pb-40">
      <div class="row border-bottom-black">
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <img class="mt-10 mb-20" alt="" src="{{ asset('assets/frontend/images/logos/logo.png') }}" style="width: 323px; height: 60px;">
            @php $siteSetting =  \DB::table('site_settings')->first(); @endphp
            <p class="text-white">{{ $siteSetting->address ?? "" }}</p>
            <ul class="list-inline mt-5">
              @foreach (json_decode($siteSetting->phone_numbers) ?? [] as $number => $value)
                <li class="m-0 pl-10 pr-10"> 
                  <i class="fa fa-phone text-theme-colored mr-5"></i>
                  <a class="text-white" href="tel:{{$value}}">{{$value}}</a> 
                </li>
              @endforeach
              <li class="m-0 pl-10 pr-10"> 
                <i class="fa fa-envelope-o text-theme-colored mr-5"></i> 
                <a class="text-white" href="mailto:{{ env("APP_MAIL") }}">{{ env("APP_MAIL") }}</a> 
              </li>
              <li class="m-0 pl-10 pr-10"> 
                <i class="fa fa-globe text-theme-colored mr-5"></i> 
                <a class="text-white" href="{{ env("APP_URL") }}">{{ env("APP_URL") }}</a> 
              </li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            @php $posts = \App\Models\BlogPost::orderBy('created_at')->get()->take(3); @endphp
            @if (count($posts))    
              <h5 class="widget-title line-bottom">Latest News</h5>
              <div class="latest-posts">
                @foreach ($posts as $item)                    
                  <article class="post media-post clearfix pb-0 mb-10">
                    <a href="{{ url("blog/$item->slug") }}" class="post-thumb">
                      <img alt="Image" src="{{ asset($item->image) }}" style="width: 80px; height: 55px;">
                    </a>
                    <div class="post-right">
                      <h5 class="post-title mt-0 mb-5"><a href="{{ url("blog/$item->slug") }}" class="text-white">{{ $item->title }}</a></h5>
                      <p class="post-date mb-0 font-12 text-white">{{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</p>
                    </div>
                  </article>
                @endforeach
              </div>
            @endif
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <h5 class="widget-title line-bottom">Useful Links</h5>
            <ul class="list angle-double-right list-border">
              <li><a class="text-white" href="{{ route("blog") }}">Blog</a></li>
              <li><a class="text-white" href="{{ route("gallery") }}">Gallery</a></li>
              <li><a class="text-white" href="{{ route("videos") }}">Videos</a></li>
              <li><a class="text-white" href="{{ route("contact") }}">Contact</a></li>
              <li><a class="text-white" href="{{ route("about") }}">About</a></li>
              <li><a class="text-white" href="{{ route("team") }}">Our Team</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <h5 class="widget-title line-bottom">Opening Hours</h5>
            <div class="opening-hours">
              <ul class="list-border">
                <li class="clearfix"> <span class="text-white"> Mon - Tues :  </span>
                  <div class="value pull-right text-white"> 8.00 am - 4.00 pm </div>
                </li>
                <li class="clearfix"> <span class="text-white"> Wed - Thurs :</span>
                  <div class="value pull-right text-white"> 8.00 am - 4.00 pm </div>
                </li>
                <li class="clearfix"> <span class="text-white"> Fri : </span>
                  <div class="value pull-right text-white"> 8.00 pm - 2.00 pm </div>
                </li>
                <li class="clearfix"> <span class="text-white"> Sat & Sun : </span>
                  <div class="value pull-right text-white"> Closed </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-10">
        <div class="col-md-6">
          <div class="widget dark">
            <h5 class="widget-title mb-10">Connect With Us</h5>
            <ul class="styled-icons icon-dark icon-theme-colored icon-circled icon-sm">
              @foreach (json_decode($siteSetting->socials) ?? [] as $social => $value)                  
                <li><a href="https://{{$social}}.com/{{$value}}" target="_blank"><i class="fa fa-{{$social}}"></i></a></li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom bg-black-333">
      <div class="container pt-15 pb-10">
        <div class="row">
          <div class="col-md-6">
            <p class="font-11 text-black-777 m-0">
              Copyright &copy; {{ date("Y") }} {{ env("APP_NAME") }}. All Rights Reserved
            </p>
          </div>
          <div class="col-md-6 text-right">
            <div class="widget no-border m-0">
            </div>
          </div>
        </div>
      </div>
    </div>
</footer>
<a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>