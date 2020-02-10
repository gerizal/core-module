@extends('core::AdminLTE.app')

@section('htmlheader_title')
Feature
@endsection

@section('contentheader_title')
Feature
@endsection

@section('contentheader_description')
Create New Feature
@endsection

@section('breadcrumb')
<li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/feature') }}">Features</a></li>
<li class="active">Create</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-8">
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

                <form role="form" action="{{ route('feature.store') }}" method="post">
                    <input type="hidden" name="destination" value="create"/>
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('tag') ? ' has-error' : '' }}">
                            <label for="tag">Tag</label>
                            <input type="text" name="tag" value="{{ old('tag') }}" class="form-control" id="tag">
                            @if ($errors->has('tag'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tag') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Description</label>
                            <input type="text" name="description" value="{{ old('description') }}" class="form-control" id="description">
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
    <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-plug"></i> Last updated features
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if ($lastrecentfeatures->count() === 0)
                    <ul class="timeline">
                        <!-- timeline time label -->
                        <li class="time-label">
                            <span class="bg-red">
                                Not available
                            </span>
                        </li>
                        <!-- /.timeline-label -->

                        <!-- timeline item -->
                        <li>
                            <!-- timeline icon -->
                            <i class="fa fa-plug bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> N/A</span>
                                <h3 class="timeline-header">No feature available</h3>
                                <div class="timeline-body">
                                    <a href="{{ url('/feature/create') }}"><i class="fa fa-plus-circle"></i> Create Feature</a>
                                </div>
                            </div>
                        </li>
                        <!-- END timeline item -->
                    </ul>
                @else
                    <ul class="timeline">
                        @foreach ($lastrecentfeatures as $feature)
                            <!-- timeline time label -->
                            <li class="time-label">
                                <span class="bg-navy">
                                    {{ date('M j, Y', strtotime($feature->updated_at)) }}
                                </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                                <!-- timeline icon -->
                                <i class="fa fa-plug bg-blue"></i>
                                <div class="timeline-item">
                                    <span class="time">
                                        <i class="fa fa-clock-o"></i> {{ date('h:i a', strtotime($feature->updated_at)) }}
                                    </span>
                                    <h3 class="timeline-header">
                                        <a href="{{ url('feature', $feature->uniqueid()) }}">{{ $feature->tag }}</a>
                                    </h3>
                                    <div class="timeline-body"></div>
                                    <div class="timeline-footer">
                                        <a class="btn btn-default btn-xs" href="{{ url('feature', $feature->uniqueid()) }}">
                                            <i class="fa fa-eye" data-toggle="tooltip" data-placement="left" data-title="View"></i>
                                        </a>
                                        <a class="btn btn-primary btn-xs" href="{{ route('feature.edit', $feature->uniqueid()) }}">
                                            <i class="fa fa-pencil-square-o" data-toggle="tooltip"
                                                data-placement="right" data-title="Edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        <li>
                            <i class="fa fa-clock-o bg-gray"></i>
                        </li>
                    </ul>
                @endif
            </div><!-- ./box-body -->
        </div>
    </div>
</div>
@endsection

@section('javascript_per_page')

@endsection
