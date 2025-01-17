@extends('admin.layout')

@php
$selLang = \App\Language::where('code', request()->input('language'))->first();
@endphp
@if(!empty($selLang) && $selLang->rtl == 1)
@section('styles')
<style>
    form:not(.modal-form) input,
    form:not(.modal-form) textarea,
    form:not(.modal-form) select,
    select[name='language'] {
        direction: rtl;
    }
    form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">Products</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('admin.dashboard')}}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Products Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Products</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-2">
                    <div class="card-title d-inline-block">Products</div>
                </div>
                <div class="col-lg-3">
                    @if (!empty($langs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <?php 

                        $productType = \App\ProductType::where('status',1)->pluck('name','id')->toArray();

                     ?>
                     
                @if(isset($productType) && !empty($productType))
                     
                  <div class="col-lg-3">
                      <select name="product_type_id" id="product_type_id" onchange="window.location=this.value" class="form-control">
                          <option value="{{ route('admin.product.index') }}?language={{request()->input('language')}}" selected>Select a product type</option>
                          @foreach ($productType as $key=>$v)
                              <option @if(request()->input('product_type_id') == $key) selected @endif value="{{ route('admin.product.index') }}?language={{request()->input('language')}}&product_type_id={{$key}}">{{$v}}</option>
                          @endforeach
                      </select>
                  </div>
                @endif

                <div class="col-lg-3 offset-lg-1 mt-2 mt-lg-0">
                    <a href="{{route('admin.product.create') . '?language=' . request()->input('language')}}" class="btn btn-primary float-right btn-sm"><i class="fas fa-plus"></i> Add Product</a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.product.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($products) == 0)
                <h3 class="text-center">NO Products FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">Featured Image</th>
                        <th scope="col">Template</th>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Is Feature</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($products as $key => $product)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{$product->id}}">
                          </td>
                          <td><img src="{{asset('assets/front/img/product/featured/'.$product->feature_image)}}" width="80"></td>
                          <td><span class="badge badge-light">{{ $product->productTemplate ? $product->productTemplate->name : ''}}</span></td>
                          <td>{{strlen(convertUtf8($product->title)) > 200 ? convertUtf8(substr($product->title, 0, 200)) . '...' : convertUtf8($product->title)}}</td>
                          
                          <td>
                            @if (!empty($product->category))
                            {{convertUtf8($product->category ? $product->category->name : '')}}
                            @endif
                          </td>
                          
                          <td>
                            <form id="featureForm{{$product->id}}" class="d-inline-block" action="{{route('admin.product.feature')}}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <select class="form-control {{$product->is_featured == 1 ? 'bg-success' : 'bg-danger'}}" name="is_featured" onchange="document.getElementById('featureForm{{$product->id}}').submit();">
                                <option value="1" {{$product->is_featured == 1 ? 'selected' : ''}}>Yes</option>
                                <option value="2" {{$product->is_featured == 2 ? 'selected' : ''}}>No</option>
                            </select>
                            </form>
                          </td>

                          <td>
                            <a class="btn btn-secondary btn-sm" href="{{route('admin.product.edit', $product->id) . '?language=' . request()->input('language')}}">
                            <span class="btn-label">
                              <i class="fas fa-edit"></i>
                            </span>
                            Edit
                            </a>
                            <form class="deleteform d-inline-block" action="{{route('admin.product.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="product_id" value="{{$product->id}}">
                              <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                                Delete
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="d-inline-block mx-auto">
              {{$products->appends(['language' => request()->input('language')])->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
