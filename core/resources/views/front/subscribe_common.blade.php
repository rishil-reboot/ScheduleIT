 <div class="subscribe-section">
  <span>{{__('SUBSCRIBE')}}</span>
  <h3>{{__('SUBSCRIBE FOR NEWSLETTER')}}</h3>
  <form id="subscribeForm" class="subscribe-form" action="{{route('front.subscribe')}}" method="POST">
     @csrf
     <div class="form-element"><input name="email" type="email" placeholder="{{__('Email')}}"></div>
     <p id="erremail" class="text-danger mb-3 err-email"></p>
      @if($errors->any())
         <div style="color: red;">
            {{ implode('', $errors->all(':message')) }}
         </div>
      @endif
     <div class="form-element"><input type="submit" value="{{__('Subscribe')}}"></div>
  </form>
</div>
