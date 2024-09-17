<script>

    $(document).on('click',".get-my-preview",function(){

        var id = $(this).attr('data-id');

        $.ajax({
            type: "POST",
            url: "{{ route('admin.member.get-preview') }}",
            data: {
              '_token':"{{ csrf_token() }}",
              'id':id
            },
            success: function(response) {
    
                $('.preview-data').html(response);
                $('#previewDataPopup').modal('show');
            },
            error: function(jqXhr) {
                
            }
        });

    });

</script>