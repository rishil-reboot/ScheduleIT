<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Booking Spot time over</title>
</head>
<body>

	<?php 

		$userName = $v->booking->user->fname .' '.$v->booking->user->lname;
		$body = str_replace(array('###USERNAME###','###SERVICE_NAME###','###LINK###'),array($userName,$v->booking->service->title,route('reservation.index')),$bs->booking_spot_description);

	?>

		{!! $body !!}
</body>
</html>