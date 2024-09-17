@if(isset($input['endAction']) && $input['endAction'] == 'after')

<div class="col-lg-2 offset-lg-3">
	<div class="form-group">
		<label class="control-label">
			<input type="text" name="end_after_count" value="@if(isset($event))  {{$event->end_after_count}} @endif" class="form-control">
		</label>
	</div>
</div>

<div class="col-lg-3">
	<div class="form-group">
		<label class="control-label">
			sent scheduled SMS sessions
		</label>
	</div>
</div>


@elseif(isset($input['endAction']) && $input['endAction'] == 'date')
	
	<div class="col-lg-6 offset-lg-3">
		<div class="form-group">
			
			<input type="date" name="end_on_date" class="form-control" value="{{$event->end_on_date}}">
			
		</div>
	</div>


@endif