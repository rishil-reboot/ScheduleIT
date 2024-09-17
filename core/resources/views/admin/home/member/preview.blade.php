<div class="modal modal-fullscreen-xl" id="previewDataPopup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe height="650" allowTransparency="true" frameborder="0" scrolling="yes" style="width:100%;"
                    src="{{ route('front.dynamicMemberPage', ['slug' => $page->slug]) }}" type="text/javascript"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
