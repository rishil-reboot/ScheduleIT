<div class="modal fade" id="mediaSelectionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Existing Media</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @php
                $mediaData = \App\Gallery::all();
                @endphp
                <div class="row">
                    @foreach ($mediaData as $key => $media)
                        <div class="col-4 mb-4">
                            <div class="card">
                                <!-- Media content -->
                                <div class="media-container">
                                    @if ($media->media_type == 1)
                                        <img src="{{ asset('assets/front/img/gallery/' . $media->image) }}"
                                            class="card-img-top" alt="{{ $media->title }}">
                                    @elseif ($media->media_type == 3)
                                        <video controls width="135" height="135">
                                            <source src="{{ asset('assets/front/videos/' . $media->video_name) }}"
                                                type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @elseif ($media->media_type == 4)
                                        <img src="{{ asset('assets/front/img/icon/audio.png') }}" alt="audio"
                                            width="80">
                                    @elseif ($media->media_type == 2)
                                        <img src="{{ asset('assets/front/img/icon/doc.png') }}" alt="document"
                                            width="80">
                                    @endif
                                </div>
                                <!-- Media info and individual insert button -->
                                <div class="media-info">
                                    <p>{{ $media->title }}</p>
                                </div>
                                <div class="card-body">
                                    <button class="btn btn-primary insert-media-button"
                                        data-media-id="{{ $key }}"
                                        data-media-type="{{ $media->media_type }}"
                                        data-media-path="{{ $media->media_type == 1
                                            ? asset('assets/front/img/gallery/' . $media->image)
                                            : ($media->media_type == 3
                                                ? asset('assets/front/videos/' . $media->video_name)
                                                : ($media->media_type == 4
                                                    ? asset('assets/front/img/audio/' . $media->audio_file)
                                                    : ($media->media_type == 2
                                                        ? asset('assets/front/doc/' . $media->document_file)
                                                        : ''))) }}">Insert
                                        Media</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>