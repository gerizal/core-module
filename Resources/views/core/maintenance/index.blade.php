@extends('core::AdminLTE.app')

@section('htmlheader_title')
Maintenance
@endsection

@section('contentheader_title')
Maintenance
@endsection

@section('contentheader_description')
Ops, we are doing maintenance
@endsection

@section('main-content')
<div class="error-page">
    <h1 class="text-yellow"> Maintenance</h1>
    <div class="error-content">
        <h3>
            <i class="fa fa-warning text-yellow"></i> Oops! We are doing maintenance.
        </h3>
        <p>
            Meanwhile, you may <a href='{{ url('/home') }}'>return to dashboard</a>.
        </p>
    </div><!-- /.error-content -->
</div><!-- /.error-page -->
@endsection
