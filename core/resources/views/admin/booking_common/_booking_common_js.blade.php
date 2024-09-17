{{-- jQuery 2.1.4 --}}
<script src="{!!asset('assets/booking/admin/plugins/jQuery/jQuery-2.1.4.min.js')!!}" type="text/javascript"></script>

{{-- jQuery UI 1.11.4 --}}
<script src="{!!asset('assets/booking/admin/plugins/jQueryUI/jquery-ui.min.js')!!}" type="text/javascript"></script>

{{-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip --}}
<script type="text/javascript">
    $.widget.bridge('uibutton', $.ui.button);
</script>

{{-- Bootstrap 3.3.2 JS --}}
<script src="{!!asset('assets/booking/admin/bootstrap/js/bootstrap.min.js')!!}" type="text/javascript"></script>

{{-- InputMask --}}
<script src="{!!asset('assets/booking/admin/plugins/input-mask/jquery.inputmask.js')!!}" type="text/javascript"></script>
<script src="{!!asset('assets/booking/admin/plugins/input-mask/jquery.inputmask.date.extensions.js')!!}" type="text/javascript"></script>
<script src="{!!asset('assets/booking/admin/plugins/input-mask/jquery.inputmask.extensions.js')!!}" type="text/javascript"></script>

{{-- for number input field force numeric --}}
<script src="{!!asset('assets/booking/admin/js/numeric.js')!!}" type="text/javascript"></script>

{{-- date-picker --}}
<script src="{!!asset('assets/booking/admin/plugins/datepicker/js/bootstrap-datepicker.js')!!}" type="text/javascript"></script>

{{-- Datetime Picker --}}

<script src="{!!asset('assets/booking/admin/plugins/bootstrap-datetimepicker/js/moment.min.js')!!}" type="text/javascript"></script>
<script src="{!!asset('assets/booking/admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')!!}" type="text/javascript"></script>

{{-- jQuery Validation js --}}
<script src="{!!asset('assets/booking/admin/plugins/validation/jquery.validate.min.js')!!}" type="text/javascript"></script>
<script src="{!!asset('assets/booking/admin/plugins/validation/additional-methods.js')!!}" type="text/javascript"></script>
@if(config('app.locale')!='en')
<script src="{!!asset('assets/booking/admin/plugins/validation/localization/messages_'.config('app.locale').'.js')!!}" type="text/javascript"></script>
@endif

{{-- jQuery dataTables js --}}
<script src="{!!asset('assets/booking/admin/plugins/datatables_1.10.8/jquery.dataTables.js')!!}" type="text/javascript"></script>
<script src="{!!asset('assets/booking/admin/plugins/datatables_1.10.8/dataTables.bootstrap.js')!!}" type="text/javascript"></script>

{{-- ckeditor --}}
<script type="text/javascript" src="{!!asset('assets/booking/admin/plugins/ckeditor/ckeditor.js')!!}"></script>

{{-- AdminLTE App --}}
<script src="{!!asset('assets/booking/admin/dist/js/app.min.js')!!}" type="text/javascript"></script>
<script src="{!!asset('assets/booking/admin/js/common.js')!!}" type="text/javascript"></script>
<script src="{!!asset('assets/booking/admin/js/custom.js')!!}" type="text/javascript"></script>

<script type="text/javascript">
    $(function () {
        //hide alert message when click on remove icon
        $(".close").click(function () {
            $(this).closest('.alert').addClass('hide');
        });
    });
</script>

