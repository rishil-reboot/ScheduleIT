@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Subscribers</h4>
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
        <a href="#">Subscribers</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Subscribers</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
          <div class="row">
              <div class="card-title d-inline-block">Subscribers</div>
              <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                  <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.subscriber.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                  
                  <a href="#" class="btn btn-primary float-lg-right btn-sm mr-2" data-toggle="modal" data-target="#createModal"><i class="fas fa-file-import"></i> Import </a>

                  <form action="{{route('admin.subscribers.export')}}" method="post">
                    @csrf
                    <button class="btn btn-primary float-right btn-sm mr-2" type="submit"> <i class="fas fa-file-export"></i> Export</button>
                  </form>
              </div>
              <div>
              </div>
          </div>
        </div>
        
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($subscs) == 0)
                <h3 class="text-center">NO SUBSCRIBER FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">email</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($subscs as $key => $subsc)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{$subsc->id}}">
                          </td>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$subsc->email}}</td>
                          <td>
                            <a class="btn btn-secondary btn-sm" href="{{route('admin.subscriber.edit', $subsc->id)}}">
                            <span class="btn-label">
                              <i class="fas fa-edit"></i>
                            </span>
                            Edit
                            </a>
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

   <!-- Create Feature Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Import Subscriber</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="modal-form" action="{{route('admin.subscribers.import')}}" method="post">
            @csrf

            <div class="form-group">
                <label for="">Import File</label>
                <input type="file" name="import_file" class="form-control" id="import_file" required>
                <a href="{{asset('assets/front/sample/subscriber_import_sample.xlsx')}}"><i class="fa fa-download" aria-hidden="true"></i> Download Sample file</a>
                <br><span><strong>Note:- </strong> Already existing email record will be skip.</span>
                <p id="errimport_file" class="mb-0 text-danger em"></p>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>

@endsection
