@extends('core::AdminLTE.app')

@section('htmlheader_title')
Home
@endsection

@section('contentheader_title')
Home
@endsection

@section('contentheader_description')
This is your dashboard
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Meh</li>
@endsection

@section('main-content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-newspaper-o"></i> Dashboard</h3>
        <div class="box-tools pull-right">
            <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
            <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                Dashboard
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- ./box-body -->
</div>
@endsection
