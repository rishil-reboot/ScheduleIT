@extends('admin.layout')


@section('styles')
<style>

</style>
@endsection
@section('content')
<h2>Screen Recorder</h2>
<div>
    <button onclick="startRecording()">Start Recording</button>
    <button onclick="stopRecording()">Stop Recording</button>
</div>
<div>
    <video id="video-preview" autoplay></video>
</div>
<form id="save-form" action="{{route('admin.screen-recorder.save')}}" method="POST">
    @csrf
    <input type="hidden" name="videoData" id="video-data" required>
    <button type="submit">Save Video</button>
</form>
<h2>Screen Record list</h2>
<div class="card">
    <div class="card-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped mt-3">
                                <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.screen-recorder.bulkdelete')}}"><i class="flaticon-interface-5"></i> Delete</button>

                            <thead>
                                <tr>
                                    <th scope="col">
                                        <input type="checkbox" class="bulk-check" data-val="all">
                                    </th>
                                    <th>Sr.no</th>
                                    <th>Name</th>
                                    <th>Video link</th>
                                    <th>Duration</th>
                                    <th>Size</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($screenRecorders as $screenRecorder)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="bulk-check" data-val="{{$screenRecorder->id}}">
                                      </td>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td><a href="{{$screenRecorder->external_link}}"><span class="badge badge-light">{{ $screenRecorder->name }}</span></a></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm copy-url" data-url="{{$screenRecorder->external_link}}">
                                            <span class="btn-label">
                                                <i class="fas fa-copy"></i>
                                            </span>
                                            Copy URL
                                        </button>
                                    </td>
                                    <td>{{ $screenRecorder->duration }} seconds</td>
                                    <td>{{ $screenRecorder->size }}</td>
                                    <td>
                                        <a href="{{route('admin.screen-recorder.edit',['id' => $screenRecorder->id])}}" class="btn btn-secondary btn-sm"> <span class="btn-label">
                                            <i class="fas fa-edit"></i>
                                          </span>Edit</a>
                                        <form class="d-inline-block deleteform" action="{{route('admin.screen-recorder.delete')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="videoid" value="{{$screenRecorder->id}}">
                                            <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                              <span class="btn-label">
                                                <i class="fas fa-trash"></i>
                                              </span>
                                              Delete
                                            </button>
                                          </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   // Get references to HTML elements
const videoPreview = document.getElementById('video-preview');
const saveVideoForm = document.getElementById('save-form');
const videoDataInput = document.getElementById('video-data');

let mediaStream;
let mediaRecorder=null;
const chunks = [];

// Function to start recording
function startRecording() {
navigator.mediaDevices.getDisplayMedia({ video: true })
    .then(stream => {
        // Display the video stream in the preview element
        videoPreview.srcObject = stream;
        mediaStream = stream;

        // Reset the chunks array for a new recording
        chunks.length = 0;

        // Create a media recorder and set up event handlers
        mediaRecorder = new MediaRecorder(stream);
        mediaRecorder.ondataavailable = handleDataAvailable;
        mediaRecorder.start();

        // Event handler when media recording stops
        mediaRecorder.onstop = function() {
            // Create a Blob from the collected chunks
            let blob = new Blob(chunks, { type: 'video/webm' });

            // Create a URL for the recorded video
            let videoURL = URL.createObjectURL(blob);

            // Convert the Blob to a Base64 string and set it in the form field
            getBase64String(blob)
                .then(base64String => {
                    videoDataInput.value = base64String;

                    // Clear the video preview
                    videoPreview.srcObject = null;
                    videoPreview.src = videoURL;

                    // Submit the form
                    saveVideoForm.submit();
                })
                .catch(error => console.error('Error converting Blob to Base64: ', error));
        }
                })
    .catch(error => console.error('Error accessing media devices: ', error));
}

// Function to stop recording
function stopRecording() {
if (mediaRecorder && mediaStream) {
    // Stop the media recorder and release the tracks
    mediaRecorder.stop();
    mediaStream.getTracks().forEach(track => track.stop());
}
}

// Function to handle available data from the media recorder
function handleDataAvailable(event) {
if (event.data.size > 0) {
    chunks.push(event.data);
}
}


// Function to convert a Blob to a Base64 string
function getBase64String(blob) {
return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(blob);
    reader.onloadend = function() {
        const base64String = reader.result.split(',')[1];
        resolve(base64String);
    }
    reader.onerror = function(error) {
        reject(error);
    }
});
}

 // Define a function to copy the URL to clipboard
 function copyURLToClipboard(urlToCopy) {
        // Create a temporary input element to copy the URL to clipboard
        const tempInput = document.createElement('input');
        document.body.appendChild(tempInput);
        tempInput.value = urlToCopy;
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        // Show a success message
        const successMessage = document.createElement('div');
        successMessage.classList.add('alert', 'alert-success', 'mt-2');
        successMessage.textContent = 'URL copied to clipboard!';
        this.parentElement.appendChild(successMessage);

        // Remove the success message after a few seconds
        setTimeout(function () {
            successMessage.remove();
        }, 3000);
    }

    // Add a click event listener to all "Copy URL" buttons
    const copyButtons = document.querySelectorAll('.copy-url');
    
    copyButtons.forEach(button => {
        button.addEventListener('click', function () {
            const urlToCopy = this.getAttribute('data-url');
            
            // Call the copyURLToClipboard function
            copyURLToClipboard(urlToCopy);
        });
    });


</script>

@endsection