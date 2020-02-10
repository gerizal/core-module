<!-- Extends modals from application -->
@if (View::exists('cwaextends.modals'))
@include('cwaextends.modals')
@endif

@yield('modal_per_page')
