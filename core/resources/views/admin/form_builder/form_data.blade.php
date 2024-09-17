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
    <h4 class="page-title">Form Data</h4>
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
        <a href="#">Form Data</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Lists</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Form Data</div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.form_builder.index') . '?language=' . request()->input('language')}}">
              <span class="btn-label">
                <i class="fas fa-backward" style="font-size: 12px;"></i>
              </span>
              Back
            </a>
          </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if($form_data->isEmpty())
                <h2 class="text-center">NO LINK ADDED</h2>
              @else
  
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        
                        @foreach($theads as $thead)
                          
                          @if(isset($thead['type']) && $thead['type'] !='file' && $thead['type'] !='textarea' && isset($thead['label']) && isset($thead['name']))
                            <th scope="col">{{$thead['label']}}</th>
                          @endif
                        @endforeach
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
            
                      @foreach ($form_data as $key => $apage)
                        <?php $json_data = (array)json_decode($apage->json_data);  

                        ?>
                        <tr>
                          @foreach($theads as $thead)
                              
                            @if(isset($thead['type']) && $thead['type'] !='file' && $thead['type'] !='textarea' && isset($thead['name']))
                              <td scope="col"><?php echo isset($json_data[$thead['name']])? $json_data[$thead['name']]:''; ?></td>
                            @endif
                          @endforeach
                          <td scope="col">
                          <a class="btn btn-info btn-sm" href="{{route('admin.form_builder.view', $apage->id) . '?language=' . request()->input('language')}}"><span class="btn-label"><i class="fas fa-eye"></i></span>View</a>
                            <form action="{{ route('admin.form_builder.deleteFormData', $apage->id) . '?language=' . request()->input('language') }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <span class="btn-label"><i class="fas fa-trash"></i></span> Delete
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
      </div>
    </div>
  </div>
@endsection
