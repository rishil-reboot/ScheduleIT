@extends('admin.layout')

@section('styles')
<style>
video {
            width: 70%;
            height: 60%;
        }
</style>
@endsection

@section('content')
    <h2>Edit Screen Recorder</h2>
    <form method="POST" action="{{ route('admin.screen-recorder.update',['id' => $screenRecorder->id]) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">File Name**</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $screenRecorder->name }}" required>
        </div>
        <div class="form-group">
            <label>Meta Keywords</label>
            <input class="form-control" name="meta_keywords" value="{{$screenRecorder->meta_keywords}}" placeholder="Enter meta keywords" data-role="tagsinput">
         </div>
         <div class="form-group">
            <label>Meta Description</label>
            <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description">{{$screenRecorder->meta_description}}</textarea>
         </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <h2 class="mt-5">Video Playback</h2>

    <div>
      
        <video controls autoplay>
            <source src="{{asset('assets/videos' . $screenRecorder->name)}}"  type="video/webm">
        </video>
    </div>
@endsection
