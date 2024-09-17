@php
    $links = json_decode($menus, true);
    //  dd($links);
@endphp
@if (request()->is('/'))
    <header>
@else
    <header class="white_header">
@endif

<div class="container">
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <div class="toggle-wrap">
                    <span class="toggle-bar"></span>
                </div>
            </span>
        </button>
        @php $links = json_decode($menus, true); @endphp
        @foreach ($links as $link)
        @php
            $href = getHref($link);
        @endphp

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{$href}}" target="{{$link["target"]}}">{{$link["text"]}}</a>
                </li>
            </ul>
        </div>
        @endforeach

        {{-- @if ($bs->is_quote == 1)
        @php
            $quoteText = __('Request A Quote');
            $quoteRoute = route('front.quote');

            if(!empty($bs->quote_menu_text)){

                $quoteText = $bs->quote_menu_text;
            }

            if($bs->getQuotePage !=null){

                $quoteRoute = route('front.dynamicPage',$bs->getQuotePage->slug);
            }
        @endphp --}}

     {{-- <li><a href="" class="btn puprple_btn" data-aos="fade-in"
        data-aos-duration="1500"></a></li> --}}
     {{-- @endif --}}


    </nav>
    <hr>
    <!-- navigation end -->
</div>
</header>
