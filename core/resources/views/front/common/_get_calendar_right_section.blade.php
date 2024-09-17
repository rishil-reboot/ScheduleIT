<?php 

    $featuredEvents = getFeaturedEvent();
    $randomBgColor = ['event-purple','event-ferozi','event-blue','event-pink','event-yellow'];
    
?>
@if(isset($featuredEvents) && !$featuredEvents->isEmpty())

    @foreach($featuredEvents as $key=>$v)
        <?php 

            $ranKey = array_rand($randomBgColor);
            $ranValue = $randomBgColor[$ranKey];
        ?>
        <div class="event-box {{$ranValue}}">
            <h2>{{$key+1}} <small>{{$v->title}}</small></h2>
            @if($v->start_date !=null)
                <p>
                    <b>{{date('D',strtotime($v->start_date))}}, {{date('d M , Y',strtotime($v->start_date))}}</b>
                </p>
                <p>{{date('h:i A',strtotime($v->start_date))}}</p>
            @endif
            @if($v->notes !=null)
                <p>{{$v->notes}}</p>
            @endif
        </div>

    @endforeach

@endif
