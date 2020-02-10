@extends('core::AdminLTE.app')

@section('htmlheader_title')
Feature - {{ $feature->tag }}
@endsection

@section('contentheader_title')
{{ $feature->tag }}
@endsection

@section('contentheader_description')
{{ $feature->tag }}
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-plug"></i> Feature</a></li>
<li class="active">Show</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a class="btn btn-default" href="{{ url('/feature') }}">
                        <i class="fa fa-chevron-circle-left"></i> Back
                    </a>
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    <label for="title"><h3>{{ $feature->tag }}</h3></label>
                </div>
            </div><!-- ./box-body -->
        </div>
    </div>
</div>
@endsection
