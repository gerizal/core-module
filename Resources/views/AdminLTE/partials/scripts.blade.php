<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!-- Moment CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<!-- Slimscroll -->
<script src="{{ config('core.assets.js.slimscroll') }}"></script>
<!-- Fastclick -->
<script src="{{ config('core.assets.js.fastclick') }}"></script>
<!-- Bootstrap JS CDN -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- AdminLTE App -->
<script src="{{ config('core.assets.js.app') }}" type="text/javascript"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.12.6/js/vendor/jquery.ui.widget.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.12.6/js/jquery.iframe-transport.min.js"></script>
<!-- The basic File Upload plugin CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.12.6/js/jquery.fileupload.js"></script>
<!-- Datatables CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
<!-- Datatables Bootstrap CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>
<!-- Bootstrap WYSIHTML5 CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.all.min.js"></script>
<!-- jQuery Messenger -->
<script src="{{ config('core.assets.js.messenger_min') }}"></script>
<script src="{{ config('core.assets.js.messenger_theme_future') }}"></script>
<script src="{{ config('core.assets.js.messenger_theme_flat') }}"></script>
<!-- Datetimepicker CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<!-- Cropit -->
<script src="{{ config('core.assets.js.cropit') }}"></script>
<!-- Ion Slider -->
<script src="{{ config('core.assets.js.ionslider') }}" type="text/javascript"></script>
<!-- Bootstrap Slider CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.2.2/bootstrap-slider.min.js" type="text/javascript"></script>
<!--
    Optionally, you can add Slimscroll and FastClick plugins.
  Both of these plugins are recommended to enhance the
  user experience. Slimscroll is required when using the
  fixed layout.
-->

<?php
$messengerTheme = 'future';
if (isset(AppearanceHelper::appearance()->messenger_theme)) {
    if (!empty(AppearanceHelper::appearance()->messenger_theme)) {
        $messengerTheme = AppearanceHelper::appearance()->messenger_theme;
    }
}
?>
<script type="text/javascript">
    $(function(){
        /**
         * jQuery messenger style
         */
        try {
            Messenger.options = {
                extraClasses: 'messenger-fixed messenger-on-top messenger-on-right',
                theme: '{{ $messengerTheme }}'
            }
            $('.wysihtml5').wysihtml5();
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD HH:mm'
            });
            $('.slider').slider();
            $('#range').ionRangeSlider({
                type: "single",
                step: 1,
                hideMinMax: true
            });
        } catch (err) {}
    });
</script>
<script src="{{ config('core.assets.js.app_custom') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        /**
         * Track Displayed Notification
         */
        try {
            if ($('.dismiss_notification').length) {
                $('.dismiss_notification').each(function (i) {
                    var el = $(this);
                    var dataNotificationTrack = {
                        '_method':'POST',
                        '_token':'{{ csrf_token() }}',
                        'notification':el.data('notification'),
                        'status':'VIEWED'
                    };

                    trackNotification(dataNotificationTrack, '{{ url('/track_notification') }}');
                });
            }
        } catch(err) {}

        /**
         * Dismiss Notification
         */
        $(document).on('click', '.dismiss_notification', function (e) {
            e.preventDefault();

            var el = $(this);
            var notification = el.data('notification');

            try {
                var dataNotificationTrack = {
                    '_method':'POST',
                    '_token':'{{ csrf_token() }}',
                    'notification':notification,
                    'status':'DISMISSED'
                };

                trackNotification(dataNotificationTrack, '{{ url('/track_notification') }}');
            } catch (err) {
                showTemporaryMessage(err.message, 'error', 5);
            }
        });
    });
</script>

<!-- Extends scripts from application -->
@if (View::exists('cwaextends.scripts'))
@include('cwaextends.scripts')
@endif

@yield('javascript_per_page')
