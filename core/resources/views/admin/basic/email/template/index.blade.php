<div class="col-md-12">
        
         <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card-title d-inline-block">Templates</div>
                    </div>
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                        <a href="{{route('admin.email-template.template.create')}}" class="btn btn-primary float-right btn-sm"><i class="fas fa-plus"></i> Add Template</a>
                        <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.email-template.template.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  @if (count($bcategorys) == 0)
                    <h3 class="text-center">NO TEMPLATE FOUND</h3>
                  @else
                    <div class="table-responsive">
                      <table class="table table-striped mt-3">
                        <thead>
                          <tr>
                            <?php /* <th scope="col">
                                <input type="checkbox" class="bulk-check" data-val="all">
                            </th> */ ?>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Serial Number</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($bcategorys as $key => $bcategory)
                            <tr>
                              <?php /*<td>
                                <input type="checkbox" class="bulk-check" data-val="{{$bcategory->id}}">
                              </td>
                               */ ?>
                               <td>
                                <img src="{{asset('assets/front/img/template/'.$bcategory->image)}}" alt="" width="80">
                              </td>
                              <td>{{convertUtf8($bcategory->name)}}</td>
                              <td>
                                @if ($bcategory->status == 1)
                                  <h2 class="d-inline-block"><span class="badge badge-success">Active</span></h2>
                                @else
                                  <h2 class="d-inline-block"><span class="badge badge-danger">Deactive</span></h2>
                                @endif
                              </td>
                              <td>{{$bcategory->serial_number}}</td>
                              <td>
                                <a class="btn btn-secondary btn-sm" href="{{route('admin.email-template.template.edit',$bcategory->id)}}">
                                  <span class="btn-label">
                                    <i class="fas fa-edit"></i>
                                  </span>
                                  Edit
                                </a>

                                <a class="btn btn-primary btn-sm" target="_blank" href="{{route('admin.email-template.template.preview',$bcategory->id)}}">
                                  <span class="btn-label">
                                    <i class="fa fa-eye"></i>
                                  </span>
                                  Preview
                                </a>

                                
                                <?php /* <form class="deleteform d-inline-block" action="{{route('admin.email-template.template.delete')}}" method="post">
                                  @csrf
                                  <input type="hidden" name="template_id" value="{{$bcategory->id}}">
                                  <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                    <span class="btn-label">
                                      <i class="fas fa-trash"></i>
                                    </span>
                                    Delete
                                  </button>
                                </form> */ ?>
     
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
                  {{$bcategorys->appends(['language' => request()->input('language')])->links()}}
                </div>
              </div>
            </div>
          </div>
      
    </div>