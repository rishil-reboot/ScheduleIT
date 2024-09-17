<div class="card">
    <div class="card-header">
        <div class="card-title d-inline-block">Meta Info</div>

    </div>
    <div class="card-body pb-5">
        <div class="payment-information">
            <div class="row mb-2">
                @if(isset($exifData) && !empty($exifData))

                    @foreach($exifData as $key=>$v)

                        <div class="col-lg-12">

                            <div class="card-title d-inline-block">
                                <strong>{{ $key }}</strong>
                            </div>

                        </div>

                        @foreach($v as $key2=>$v2)

                            <div class="col-lg-6">
                                {{$key2}}:
                            </div>
                            <div class="col-lg-6">
                                <span class="badge badge-success"> {{$v2}} </span>
                            </div>

                        @endforeach
                            <hr>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
