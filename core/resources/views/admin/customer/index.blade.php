@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Customers</h4>
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
        <a href="#">Customers</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Customers </a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Customers</div>
          <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#createModal" data-role-id="{{ $role_id }}"><i class="fas fa-plus"></i> Add Company</a>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($companies) == 0)
                <h3 class="text-center">NO USER FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col"> First Name</th>
                        <th scope="col"> Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col"> Phone number</th>
                        {{-- <th scope="col">Address</th> --}}
                        <th scope="col">Established year</th>
                        {{-- <th scope="col"></th>
                        <th scope="col">Status</th> --}}
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        {{-- <p>{{$technicians?->experience_years}}</p> --}}
                        @foreach ($companies as  $company)
                        {{-- @if ($user->id != Auth::guard('admin')->user()->id) --}}
                          <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$company->user?->first_name}}</td>
                            <td>{{$company->user?->last_name}}</td>
                            <td>{{$company->user?->email ? $company->user->email: 'N/A'}}</td>
                            <td>{{$company->user?->phone_number ? $company->user->phone_number: 'N/A'}}</td>
                            {{-- <td>{{$technician->user?->address ? $technician->user->address: 'N/A'}}</td> --}}
                            <td>{{$company?->establised_year}}</td>

                            <td>
                                <a class="btn btn-secondary btn-sm" href="">
                                        <i class="fas fa-edit"></i>
                                </span>
                                Edit
                              </a>
                              <form class="deleteform d-inline-block" action="{{route('admin.technician.delete')}}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{$company->user->id}}">
                                <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                  <span class="btn-label">
                                    <i class="fas fa-trash"></i>
                                  </span>
                                  Delete
                                </button>
                              </form>
                            </td>
                          </tr>
                        {{-- @endif --}}
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

@section('scripts')
<script>
$('#createModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var roleId = button.data('role-id');
    console.log(roleId); // Debugging: Check if this logs the correct role_id value
    var modal = $(this);
    modal.find('input[name="role_id"]').val(roleId);
});

    </script>
@endsection
  <!-- Create Users Modal -->
  @includeif('admin.customer.create')

@endsection
