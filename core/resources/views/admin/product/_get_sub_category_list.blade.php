@if(isset($productSubcategoryData) && !empty($productSubcategoryData))
   <div class="row">
      <div class="col-md-12">
         <div class="form-group">
            <label for="">Sub Category</label>
         </div>
      </div>
      @foreach($productSubcategoryData as $key=>$v)
         <div class="col-md-6">
            <div class="form-group">
               <input @if(in_array($key,$subCateArray)) checked @endif type="checkbox" name="sub_category_id[]" value="{{$key}}">
               <label for="">{{$v}}</label>
            </div>
         </div>
      @endforeach
   </div>
@endif