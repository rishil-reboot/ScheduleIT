<div class="form-group">
  <label for="">Product</label>
  <select name="product_id[]" class="form-control" id="product_id" multiple="multiple">
    @if(!empty($prodcut))
      @foreach($prodcut as $key=>$v)
        <option value="{{ $key }}">{{$v}}</option>
      @endforeach
    @endif
  </select>
  <p id="errproduct_id" class="em text-danger mb-0"></p>
</div>

<script>
      
  $("#product_id").select2({

    placeholder:"Select Product"

  });  

</script>