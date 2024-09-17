<?php
namespace App\Validator;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Input;
use Hash;

class CustomeValidator extends Validator
{

	/**
	 * This function is used to check slug is already exit during creating or edit calendar
	 * @author Chirag Ghevariya
	 */
	public function validateCheckCalendarSlug($attribute, $value, $parameters)
	{	
			
		if (isset($parameters[0]) && !empty($parameters[0])) {
			
			$record = \App\Calendar::where('slug',$value)->where('id','!=',$parameters[0])->first();

		}else{

			$record = \App\Calendar::where('slug',$value)->first();
		}

		$returnTrueFalse = false;

		if ($record == null) {

			$returnTrueFalse = true;
		}

		return $returnTrueFalse;
    }

	/**
	 * This function is used to check subscriber email is alredy used or not.
	 * @author Chirag Ghevariya
	 */
	public function validateCheckSubscriberEmailExit($attribute, $value, $parameters)
	{	
		$record = \App\Subscriber::where('email',$value)->where('id','!=',$parameters[0])->first();

		$returnTrueFalse = true;

		if ($record != null) {

			$returnTrueFalse = false;
		}

		return $returnTrueFalse;
    }

	/**
	 * This function is used to check register email address is alredy used or not.
	 * @author Chirag Ghevariya
	 */
	public function validateCheckRegisterUserEmailExit($attribute, $value, $parameters)
	{		
		if (isset($parameters[0]) && !empty($parameters[0])) {
			
			$record = \App\User::where('email',$value)->where('id','!=',$parameters[0])->first();

		}else{

			$record = \App\User::where('email',$value)->first();
		}

		$returnTrueFalse = true;

		if ($record != null) {

			$returnTrueFalse = false;
		}

		return $returnTrueFalse;
    }

	/**
	 * This function is used to check register user email address alredy exits.
	 * @author Chirag Ghevariya
	 */
	public function validateCheckRegisterUserUsernameExit($attribute, $value, $parameters)
	{	

		if (isset($parameters[0]) && !empty($parameters[0])) {

			$record = \App\User::where('username',$value)->where('id','!=',$parameters[0])->first();

		}else{

			$record = \App\User::where('username',$value)->first();
		}

		$returnTrueFalse = true;

		if ($record != null) {

			$returnTrueFalse = false;
		}

		return $returnTrueFalse;
    }
}
?>