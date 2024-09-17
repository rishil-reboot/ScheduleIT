<div class="form-group">
  <label for="">Tag</label>
  <select name="education_tag_id[]" class="form-control" id="education_tag_id" multiple="multiple">
    @if(!$tags->isEmpty())
      @foreach($tags as $key=>$v)
        <option @if(in_array($v->id,$selectedTag)) selected @endif value="{{$v->id}}">{{$v->name}}</option>
      @endforeach
    @endif
  </select>
  <p id="erreducation_tag_id" class="em text-danger mb-0"></p>
</div>
<script>

   $("#education_tag_id").select2({

    placeholder:"Select Tag"

   });

</script>