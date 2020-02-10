@extends('core::AdminLTE.app')

@section('htmlheader_title')
Feature
@endsection

@section('contentheader_title')
Feature
@endsection

@section('contentheader_description')
Edit Feature
@endsection

@section('breadcrumb')
<li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/feature') }}">Features</a></li>
<li class="active">Create</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{{ url('/feature') }}" class="btn btn-default"><span class="fa fa-chevron-left"></span> Back</a>
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if (count($errors) > 0)
                    <div class="box-body">
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (session('message'))
                    <div class="box-body">
                        <div class="alert alert-success alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                            {!! session('message') !!}
                        </div>
                    </div>
                @endif

                <form action="{{ url('/feature/' . $feature->uniqueid() ) }}" method="post">
                    {!! csrf_field() !!}
                    {!! method_field('PATCH') !!}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('tag') ? ' has-error' : '' }}">
                            <label for="tag" class="col-md-2 control-label">Tag</label>
                            <input type="text" name="tag" value="{{ $feature->tag }}" class="form-control" id="tag">
                            @if ($errors->has('tag'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tag') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-2 control-label">Description</label>
                            <input type="text" name="description" value="{{ $feature->description }}" class="form-control" id="description">
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                    </div>
                </form>
            </div><!-- ./box-body -->
        </div>
    </div>
</div>
@endsection

@section('javascript_per_page')

@endsection
