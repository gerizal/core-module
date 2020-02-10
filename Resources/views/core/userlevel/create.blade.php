@extends('core::AdminLTE.app')

@section('htmlheader_title')
Create User Level
@endsection

@section('contentheader_title')
Create User Level
@endsection

@section('contentheader_description')
Create new user level
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-hand-o-up"></i> User Levels</a></li>
<li class="active">Create</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-8">
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

                <form role="form" method="POST" action="{{ route('user_level.store') }}">
                    <input type="hidden" name="destination" value="create"/>
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}" />
                        </div>
                        <div class="form-group">
                            <label for="name">Slug</label>
                            <input class="form-control" id="slug" name="slug" type="text" value="{{ old('slug') }}" />
                        </div>
                        <div class="form-group">
                            <label for="name">Redirect</label>
                            <input class="form-control" id="redirect" name="redirect" type="text" value="{{ old('redirect') }}" />
                        </div>
                        <div class="form-group">
                            <label for="name">Features</label>
                            <table class="table table-striped table-hover">
                                <?php $i = 0; ?>
                                @foreach($features as $feature)
                                    <tr>
                                        <td width="10px">
                                            <input type="checkbox" name="keys[{{ $i }}]" value="{{ $feature->tag }}" id="feature_boxs-{{ $i }}">
                                        </td>
                                        <td>
                                            <label for="feature_boxs-{{ $i }}">{{ $feature->tag }}</label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="values[{{ $i }}]" value="">
                                        </td>
                                    <?php $i++; ?>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="name">Time limit</label>
                            <input class="form-control" id="time_limit" name="time_limit" type="number" min="0" value="{{ old('time_limit') }}" />
                            <p class="text-muted">Number of days. Set to 0 for no limit.</p>
                        </div>
                    </div><!-- /.box-body -->
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
                    <i class="fa fa-hand-o-up"></i> Last updated user levels
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if ($lastrecentuserlevels->count() === 0)
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
                            <i class="fa fa-hand-o-up bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> N/A</span>
                                <h3 class="timeline-header">No user level available</h3>
                                <div class="timeline-body">
                                    <a href="{{ url('/user_level/create') }}"><i class="fa fa-plus-circle"></i> Create User Level</a>
                                </div>
                            </div>
                        </li>
                        <!-- END timeline item -->
                    </ul>
                @else
                    <ul class="timeline">
                        @foreach ($lastrecentuserlevels as $ulevel)
                            <!-- timeline time label -->
                            <li class="time-label">
                                <span class="bg-navy">
                                    {{ date('M j, Y', strtotime($ulevel->updated_at)) }}
                                </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                                <!-- timeline icon -->
                                <i class="fa fa-hand-o-up bg-blue"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> {{ date('h:i a', strtotime($ulevel->updated_at)) }}</span>
                                    <h3 class="timeline-header"><a href="{{ url('user_level', $ulevel->uniqueid()) }}">{{ $ulevel->name }}</a></h3>
                                    <div class="timeline-body"></div>
                                    <div class="timeline-footer">
                                        <a class="btn btn-default btn-xs" href="{{ url('user_level', $ulevel->uniqueid()) }}">
                                            <i class="fa fa-eye" data-toggle="tooltip" data-placement="left" data-title="View"></i>
                                        </a>
                                        <a class="btn btn-primary btn-xs" href="{{ route('user_level.edit', $ulevel->uniqueid()) }}">
                                            <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="right" data-title="Edit"></i>
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
