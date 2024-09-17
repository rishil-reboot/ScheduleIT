@if(isset($input['repeatType']) && $input['repeatType'] == 'yearly')

<div class="col-lg-1 offset-lg-3">
	<div class="form-group">
		<label class="control-label">
			<input type="radio" name="yearly_type" value="1" @if(isset($event) && $event->yearly_type == 1) checked @endif>
			on 
		</label>
	</div>
</div>

<div class="col-lg-2">
	<div class="form-group">
		<select class="form-control year-month" name="yearly_on_month">
			@foreach(recurringMonth() as $key=>$v)
				<option value="{{$key}}" @if(isset($event) && $event->yearly_on_month == $key) selected @endif>{{$v}}</option>
			@endforeach
		</select>
	</div>
</div>

<div class="col-lg-3">
		<div class="form-group">

			<select class="form-control month-day" name="yearly_on_day">
				@foreach(recurringDays() as $key=>$v)
					<option value="{{$key}}" @if(isset($event) && $event->yearly_on_day == $key) selected @endif>{{$v}}</option>
				@endforeach
			</select>
		</div>
</div>

<div class="col-lg-1 offset-lg-3">
	<div class="form-group">
		<label class="control-label">
		<input type="radio" name="yearly_type" value="2" @if(isset($event) && $event->yearly_type == 2) checked @endif>
		on the
		</label>
	</div>
</div>

<div class="col-lg-2">
	<div class="form-group">
		<select class="form-control month-day-pos" name="yearly_on_the_setpos">
			@foreach(recurringMonthDayPos() as $key=>$v)
				<option value="{{$key}}" @if(isset($event) && $event->yearly_on_the_setpos == $key) selected @endif>{{$v}}</option>
			@endforeach
		</select>
	</div>
</div>
	

<div class="col-lg-2">
	<div class="form-group">
		<select class="form-control month-days" name="yearly_on_the_mixday">
			
			@foreach(recurringWeekDayNameMix() as $key=>$v)
				<option value="{{$key}}" @if(isset($event) && $event->yearly_on_the_mixday == $key) selected @endif>{{$v}}</option>
			@endforeach
		</select>
	</div>
</div>

<span style="margin-top: 18px;">of</span>


<div class="col-lg-2">
	<div class="form-group">
		
		<select class="form-control year-month" name="yearly_on_the_month">
			@foreach(recurringMonth() as $key=>$v)
				<option value="{{$key}}" @if(isset($event) && $event->yearly_on_the_month == $key) selected @endif>{{$v}}</option>
			@endforeach
		</select>
	</div>
</div>

@elseif(isset($input['repeatType']) && $input['repeatType'] == 'monthly')

	
	<div class="col-lg-1 offset-lg-3">
		<div class="form-group">
			<label class="control-label">
				every
			</label>
		</div>
	</div>

	<div class="col-lg-3">
		<div class="form-group">
			<input type="text" name="monthly_every_month" class="form-control" value="@if(isset($event)) {{$event->monthly_every_month }} @endif">
		</div>
	</div>

	<div class="col-lg-2">
		<div class="form-group">
			<label class="control-label">
				month(s)
			</label>
		</div>
	</div>



<div class="col-lg-1 offset-lg-3">
	<div class="form-group">
		<label class="control-label">
			<input type="radio" name="monthly_type" value="1" @if(isset($event) && $event->monthly_type == 1) checked @endif>
			on day 
		</label>
	</div>
</div>

<div class="col-lg-5">
		<div class="form-group">

			<select class="form-control month-day" name="monthly_on_day_days">
				@foreach(recurringDays() as $key=>$v)
					<option value="{{$key}}" @if(isset($event) && $event->monthly_on_day_days == $key) selected @endif>{{$v}}</option>
				@endforeach
			</select>
		</div>
</div>

<div class="col-lg-1 offset-lg-3">
	<div class="form-group">
		<label class="control-label">
		<input type="radio" name="monthly_type" value="2" @if(isset($event) && $event->monthly_type == 2) checked @endif>
		on the
		</label>
	</div>
</div>

<div class="col-lg-2">
	<div class="form-group">
		<select class="form-control month-day-pos" name="monthly_on_the_setpos">
			@foreach(recurringMonthDayPos() as $key=>$v)
				<option value="{{$key}}" @if(isset($event) && $event->monthly_on_the_setpos == $key) selected @endif>{{$v}}</option>
			@endforeach
		</select>
	</div>
</div>
	

<div class="col-lg-2">
	<div class="form-group">
		<select class="form-control month-days" name="monthly_on_the_mixdays">
			
			@foreach(recurringWeekDayNameMix() as $key=>$v)
				<option value="{{$key}}" @if(isset($event) && $event->monthly_on_the_mixdays == $key) selected @endif >{{$v}}</option>
			@endforeach
		</select>
	</div>
</div>

@elseif(isset($input['repeatType']) && $input['repeatType'] == 'weekly')
	

	<div class="col-lg-1 offset-lg-3">
		<div class="form-group">
			<label class="control-label">
				every
			</label>
		</div>
	</div>

	<div class="col-lg-3">
		<div class="form-group">
			<input type="text" name="weekly_every_week" class="form-control" value="@if(isset($event)) {{$event->weekly_every_week}} @endif">
		</div>
	</div>

	<div class="col-lg-2">
		<div class="form-group">
			<label class="control-label">
				week(s)
			</label>
		</div>
	</div>

	<div class="col-lg-6 offset-lg-3">
		<div class="form-group">
			<?php 

				$myDayArray = array();

				if (isset($event) && $event->weekly_days !=null) {
					
					$myDayArray = explode(',', $event->weekly_days);

				}
			?>
			@foreach(recurringWeekDayName() as $key=>$v)
				<label class="control-label offset-lg-2">
					<input type="checkbox" @if(in_array($key,$myDayArray)) checked @endif name="weekly_days[]" class="weekly_days" value="{{$key}}">
					{{$v}}
				</label>
			@endforeach
		</div>
	</div>


@elseif(isset($input['repeatType']) && $input['repeatType'] == 'daily')
	

	<div class="col-lg-1 offset-lg-3">
		<div class="form-group">
			<label class="control-label">
				every
			</label>
		</div>
	</div>

	<div class="col-lg-3">
		<div class="form-group">
			<input type="text" name="daily_days" class="form-control" value="@if(isset($event)) {{$event->daily_days}} @endif">
		</div>
	</div>

	<div class="col-lg-1">
		<div class="form-group">
			<label class="control-label">
				day(s)
			</label>
		</div>
	</div>

@elseif(isset($input['repeatType']) && $input['repeatType'] == 'hourly')
	
	<div class="col-lg-1 offset-lg-3">
		<div class="form-group">
			<label class="control-label">
				every
			</label>
		</div>
	</div>

	<div class="col-lg-3">
		<div class="form-group">
			<input type="text" name="hourly_hour" class="form-control" value="@if(isset($event)) {{$event->hourly_hour}} @endif">
		</div>
	</div>

	<div class="col-lg-1">
		<div class="form-group">
			<label class="control-label">
				hour(s)
			</label>
		</div>
	</div>

@endif