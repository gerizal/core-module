<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<?php
$skin = 'skin-black';
if (isset(AppearanceHelper::appearance()->skin)) {
    if (!empty(AppearanceHelper::appearance()->skin)) {
        $skin = AppearanceHelper::appearance()->skin;
    }
}
?>
<html>
    @include('core::AdminLTE.partials.htmlheader')
    <body class="{{ $skin }} fixed layout-top-nav">
        <div class="wrapper">
            @if (AppearanceHelper::appearance()->override_main_header)
                @if (View::exists('cwaextends.mainheader'))
                    @include('cwaextends.mainheader')
                @else
                    @include('core::AdminLTE.partials.mainheader')
                @endif
            @else
                @include('core::AdminLTE.partials.mainheader')
            @endif
            {{--@include('core::AdminLTE.partials.sidebar')--}}
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <div class="container">
                    @include('core::AdminLTE.partials.contentheader')
                    <!-- Main content -->
                    <section class="content">
                        <!-- Your Page Content Here -->
                        @yield('main-content')
                    </section><!-- /.content -->
                </div>
            </div><!-- /.content-wrapper -->
            
            {{--@include('core::AdminLTE.partials.controlsidebar')--}}
            @if (View::exists('cwaextends.footer'))
                @include('cwaextends.footer')
            @else
                @include('core::AdminLTE.partials.footer')
            @endif
        </div><!-- ./wrapper -->
        
        @include('core::AdminLTE.partials.modals')
        @include('core::AdminLTE.partials.scripts')
    </body>
</html>
