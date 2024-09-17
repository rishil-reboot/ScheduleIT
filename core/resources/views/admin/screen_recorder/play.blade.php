@extends('admin.layout')


@section('styles')
<style>
video {
            width: 50%;
            height: 50%;
        }
</style>
@endsection
@section('content')

<h2>Video Playback</h2>

    <div>
      
        <video controls autoplay>
            <source src="{{asset('assets/videos' . $videoUrl)}}"  type="video/webm">
        </video>
    </div>
@endsection