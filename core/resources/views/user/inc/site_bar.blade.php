@php
$default = \App\Language::where('is_default', 1)->first();
@endphp
<div class="col-lg-3">
    <div class="user-sidebar">
        <ul class="links">
            <li><a class="@if(request()->path() == 'user/dashboard') active @endif" href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a></li>

            <li><a class=" @if(request()->path() == 'user/credit') active @endif" href="{{route('front.credit.index')}}"> Buy Credit </a></li>
            <li><a class=" @if(request()->path() == 'user/chat') active @endif" href="{{route('user-get-chat')}}"> Chat </a></li>

            <li><a class=" @if(request()->path() == 'user/booking') active @endif" href="{{route('front.booking.search')}}"> My Booking </a></li>

            @if(isset($bs) && $bs->booking_payment == 1)
                <li><a class=" @if(request()->path() == 'user/transaction') active @endif" href="{{route('front.transaction.search')}}"> Transaction </a></li>
            @endif

            <li><a class=" @if(request()->path() == 'user/reservation') active @endif" href="{{route('reservation.index')}}"> Reservation </a></li>

            @if ($bex->is_shop == 1)
                <li><a class="
                    @if(request()->path() == 'user/orders') active
                    @elseif(request()->is('user/order/*')) active
                    @endif"
                    href="{{route('user-orders')}}">{{__('My Orders')}} </a></li>
            @endif

            @if ($bex->is_ticket == 1)
                <li><a class="@if(request()->path() == 'user/tickets') active
                        @elseif(request()->is('user/ticket/*')) active
                        @endif"
                        href="{{route('user-tickets')}}">{{__('Tickets')}}
                    </a>
                </li>
            @endif

            <li><a class=" @if(request()->path() == 'user/qr-code-generator') active @endif" href="{{route('qr-code-generator')}}"> QR Code </a></li>
            
            <li><a class=" @if(request()->path() == 'user/show2faForm') active @endif" href="{{route('show2faForm')}}"> Two Factor Authentication </a></li>

            <li><a class=" @if(request()->path() == 'user/profile') active @endif" href="{{route('user-profile')}}">{{__('Edit Profile')}} </a></li>

            @if ($bex->is_shop == 1)
                <li><a class=" @if(request()->path() == 'user/shipping/details') active @endif" href="{{route('shpping-details')}}">{{__('Shipping Details')}} </a></li>
                <li><a class=" @if(request()->path() == 'user/billing/details') active @endif" href="{{route('billing-details')}}">{{__('Billing Details')}} </a></li>
                <li><a class=" @if(request()->path() == 'user/reset') active @endif" href="{{route('user-reset')}}">{{__('Change Password')}} </a></li>
            @endif

            <li><a href="{{route('user-logout')}}">{{__('Logout')}} </a></li>
        </ul>
    </div>
</div>
