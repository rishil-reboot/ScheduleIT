<?php 

	$theads = json_decode($fromData->body,true);
	
	$labelArray = array();

	if (isset($theads) && !empty($theads)) {

		foreach($theads as $key=>$v){

			$labelArray[$v['name']] = $v['label'];
		}
	}

?>
@if(isset($data) && !empty($data) && !empty($labelArray))

    <table class="table" bgcolor="#eee" width="100%">
        <tbody>

            @foreach($data as $key=>$v)	

				@if($key != 'g-recaptcha-response')

		        	<tr>
	                    <td bgcolor="#8492a6" style="border-right: 1px solid #000000;border-bottom:1px dashed;padding: 12px"><b>
	                    	@if(in_array($key, array_keys($labelArray))) 
				        		<?php  $stringReplace = str_replace('<br>',' ',$labelArray[$key]);  ?>
				        		{{$stringReplace}}
				        	@endif
	                    </b></td>
	                    <td bgcolor="#eee" style="border-bottom:1px dashed;padding: 12px">{{$v}}<br></td>
	                </tr>
			
			    @endif

		    @endforeach

        </tbody>
    </table>
@endif
