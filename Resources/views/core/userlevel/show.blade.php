@extends('core::AdminLTE.app')

@section('htmlheader_title')
User Level - {{ $userlevel->name }}
@endsection

@section('contentheader_title')
{{ $userlevel->name }}
@endsection

@section('contentheader_description')
{{ $userlevel->slug }}
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-hand-o-up"></i> User Levels</a></li>
<li class="active">Show</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a class="btn btn-default" href="{{ url('/user_level') }}">
                        <i class="fa fa-chevron-circle-left"></i> Back
                    </a>
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="form-group text-center">
                    <label for="title"><h3>{{ $userlevel->name }}</h3></label>
                </div>
                <div class="form-group">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="#">Slug <span class="pull-right text-red">{{ $userlevel->slug }}</span></a></li>
                        <li><a href="#">Time limit <span class="pull-right text-red">{{ $userlevel->time_limit }}</span></a></li>
                        <li>
                            <a href="#">
                                Redirect
                                <span class="pull-right text-red">{{ $userlevel->redirect }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Created at 
                                <span class="pull-right text-red">{{ date('M j, Y g:ia', strtotime($userlevel->created_at)) }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Updated at 
                                <span class="pull-right text-red">{{ date('M j, Y g:ia', strtotime($userlevel->updated_at)) }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div><!-- ./box-body -->
        </div>
    </div>
</div>
@endsection
