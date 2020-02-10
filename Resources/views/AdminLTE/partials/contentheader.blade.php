<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @yield('contentheader_title', 'Page Header here')
        <small>@yield('contentheader_description', 'Page description here')</small>
    </h1>
    <ol class="breadcrumb">
        @yield('breadcrumb')
    </ol>
</section>
