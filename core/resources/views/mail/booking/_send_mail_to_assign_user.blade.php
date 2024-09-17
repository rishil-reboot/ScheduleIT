<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Service Booked</title>
</head>
<body>
	<p>Dear <strong>{{ $nameOfUser }}</strong></p>
	<p>One user has booked service <strong>{{$service->title}}</strong> Check below details of user</p></br>

	<p><strong>Full Name:</strong> {{ $booking->full_name }}</p> 
	<p><strong>Email:</strong> {{  $booking->email }}</p> 
	<p><strong>Mobile:</strong> {{ $booking->phone }}</p> 
	<p><strong>Address:</strong> {{ $booking->address }}</p>
	<p><strong>Spots:</strong>  
		<?php $spots = $booking->bookingDetail; ?>
	    	
	    	<?php 
				foreach ($spots as $key => $spot):?>
	            {!! date('d-m-Y h:i A', strtotime($spot->start_time)) !!} to {!! date('d-m-Y h:i A', strtotime($spot->end_time)) !!}<br>
	    	<?php 
				endforeach;?>
	</p> <br>

	Regards,<br>{!! config('app.name') !!}

</body>
</html>