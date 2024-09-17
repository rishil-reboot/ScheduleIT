@extends("front.$version.layout")

@section('pagename')
 - {{convertUtf8($partnerDetail->name)}}
@endsection

@section('meta-keywords', "$partnerDetail->meta_keywords")
@section('meta-description', "$partnerDetail->meta_description")

@section('content')
   
  @if($bs->breadcum_type == 1)

    <div class="breadcrumb-area" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
  @else

      <div class="breadcrumb-area blogs video-container">
         <video autoplay muted loop>
            <source src="{{asset('assets/front/img/breadcrumb/')}}/{{$bs->breadcum_video}}" type="video/mp4" />
         </video>
  @endif
      
      <div class="container">
        <div class="breadcrumb-txt" style="padding:{{$breadcumPadding}}">
           <div class="row">
              <div class="col-xl-7 col-lg-8 col-sm-10">
                 <h1>{{strlen(convertUtf8($partnerDetail->name)) > 30 ? substr(convertUtf8($partnerDetail->name), 0, 30) . '...' : convertUtf8($partnerDetail->name)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>Partner</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  
  <div class="blog-details-section section-padding">
     <div class="container">
        <div class="row">
           <div class="col-lg-7">
               <div class="blog-details">

                 <h2 class="blog-details-title">{{convertUtf8($partnerDetail->name)}}</h2>

                @if(!empty($partnerDetail->contact_person_name) || !empty($partnerDetail->url))

                    <ul class="blog-commment mb-15 mt-15" style="display:flex;margin-bottom: 20px;">
                        
                        @if(!empty($partnerDetail->contact_person_name) && !empty($partnerDetail->url))
                            <li>
                                <span style="color:#007bff"><strong>Contact Person:</strong></span> {{$partnerDetail->contact_person_name}}
                            </li>
                            <li style="margin-left:10px">
                                | 
                                <strong>
                                    <a style="color:#007bff" href="{{$partnerDetail->url}}" target="_blank">Company Link</a>
                                </strong> 
                            </li>
                        @elseif(!empty($partnerDetail->contact_person_name))
                            <li>
                                <span style="color:#007bff"><strong>Contact Person:</strong></span> {{$partnerDetail->contact_person_name}}
                            </li>
                        @elseif(!empty($partnerDetail->url))
                            <li style="margin-left:10px">
                                <strong>
                                    <a style="color:#007bff" href="{{$partnerDetail->url}}" target="_blank">Company Link</a>
                                </strong> 
                            </li>
                            
                        @endif  

                    </ul>

                @endif


                  @if(!empty($partnerDetail->description))
                     <div style="margin-bottom:20px">
                        <p>{{ $partnerDetail->description }}</p>
                     </div>
                  @endif
                  @if(!empty($partnerDetail->long_description))
                     <div class="blog-details-body">
                      {!! replaceBaseUrl(convertUtf8($partnerDetail->long_description)) !!}
                     </div>
                  @endif
              </div>
            </div>

            <div class="col-lg-4">
              <div class="sidebar">
                 <div class="blog-sidebar-widgets">
                    <div class="searchbar-form-section">
                        <div class="img-holder zoom-effect">
                            <img width="250px" src="{{asset('assets/front/img/partners/'.$partnerDetail->image)}}" alt="">
                        </div>        
                    </div>
                 </div>
              
                @if(!empty($partnerDetail->company_address))
                     <div class="blog-sidebar-widgets category-widget">
                        <div class="category-lists job">
                           <h4>Company Address</h4>
                            {!! $partnerDetail->company_address !!}
                        </div>
                     </div>
                 @endif

               </div>
           </div>

         </div>
     </div>
  </div>
   @if(isset($partnerDetail->partnerProduct) && !$partnerDetail->partnerProduct->isEmpty())
      <section class="latest-product padding light_bg">
          <div class="container">
               
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12">

                    <div class="default-heading">
                        <h3>{{convertUtf8($bs->portfolio_section_title)}}</h3>
                    </div>
                </div>
            </div>

              <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="Featured" role="tabpanel" aria-labelledby="home-tab">
                      <div class="row">
                          @foreach ($partnerDetail->partnerProduct as $pi)
                          <?php 

                              $product = $pi->product;
                          ?>
                          <div class="col-md-4" style="margin-bottom:40px">
                              <div class="pro-box-wrapp">
                                  <div class="img-holder zoom-effect">
                                      <a href="{{route('front.product.details',$product->slug)}}">
                                          <img src="{{asset('assets/front/img/product/featured/'.$product->feature_image)}}" alt="">
                                      </a> 
                                  </div>
                                  <div class="pro-box-wrapp-detail">
                                      <div class="star-rating">
                                          <img src="{{asset('assets/front/rebootcs')}}/images/stars.png" alt="">
                                      </div>
                                      <h4><a href="{{route('front.product.details',$product->slug)}}">
                                          {{convertUtf8($product->title)}} </a>
                                      </h4>
                                      <h5>
                                          {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$product->current_price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                                          @if (!empty($product->previous_price))
                                              <del> {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}{{$product->previous_price}}{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }} </del>
                                          @endif
                                      </h5>
                                      <a class="btn-web" data-href="{{route('front.product.checkout',$product->slug)}}" data-toggle="tooltip" data-placement="top" title="{{__('Add to Cart')}}"> Cart now</a>

                                  </div>
                              </div>
                          </div>
                          @endforeach
                      </div>
                  </div>
               </div>
            </div>
      </section>
   @endif
@endsection

@section('scripts')

@endsection
