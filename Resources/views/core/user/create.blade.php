@extends('core::AdminLTE.app')

@section('htmlheader_title')
Create User
@endsection

@section('contentheader_title')
Create User
@endsection

@section('contentheader_description')
Create new user
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-users"></i> Users</a></li>
<li class="active">Create</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-8">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a class="btn btn-default" href="{{ url('/user') }}">
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

                <form role="form" method="POST" action="{{ route('user.store') }}">
                    <input type="hidden" name="destination" value="create"/>
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}" />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" />
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" id="password" name="password" type="password" value="{{ old('password') }}" />
                        </div>
                        @if (!empty($userlevels))
                            <div class="form-group">
                                <label for="userlevel_id">User level</label>
                                <select name="userlevel_id[]" id="userlevel_id" class="form-control" multiple="">
                                    @foreach ($userlevels as $ulevel)
                                        <option value="{{ $ulevel->id }}">{{ $ulevel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="affiliate_id">Affiliate ID</label>
                            <input class="form-control" id="affiliate_id"
                                name="affiliate_id" type="text" value="{{ old('affiliate_id') }}" />
                        </div>
                        <hr>
                        <h3>User Custom Fields</h3>
                        @if (!empty($customFields))
                            @foreach ($customFields as $cFields)
                                <div class="form-group">
                                    <label for="{{ $cFields['field'] }}">{{ $cFields['name'] }}</label>
                                    <input class="form-control" id="{{ $cFields['field'] }}"
                                        name="custom_fields[{{ $cFields['field'] }}]" type="text"/>
                                </div>
                            @endforeach
                        @endif
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-floppy-o"></i> Submit
                        </button>
                    </div>
                </form>
            </div><!-- ./box-body -->
        </div>
    </div>
    <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-users"></i> Last updated users
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if ($lastrecentusers->count() === 0)
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
                            <i class="fa fa-user bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> N/A</span>
                                <h3 class="timeline-header">No user available</h3>
                                <div class="timeline-body">
                                    <a href="{{ url('/user/create') }}"><i class="fa fa-plus-circle"></i> Create User</a>
                                </div>
                            </div>
                        </li>
                        <!-- END timeline item -->
                    </ul>
                @else
                    <ul class="timeline">
                        @foreach ($lastrecentusers as $user)
                            <!-- timeline time label -->
                            <li class="time-label">
                                <span class="bg-navy">
                                    {{ date('M j, Y', strtotime($user->updated_at)) }}
                                </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                                <!-- timeline icon -->
                                <i class="fa fa-user bg-blue"></i>
                                <div class="timeline-item">
                                    <span class="time">
                                        <i class="fa fa-clock-o"></i> {{ date('h:i a', strtotime($user->updated_at)) }}
                                    </span>
                                    <h3 class="timeline-header">
                                        <a href="{{ url('user', $user->uniqueid()) }}">{{ $user->name }}</a>
                                    </h3>
                                    <div class="timeline-body">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li><span class="pull-right text-red">{{ $user->email }}</span></li>
                                        </ul>
                                    </div>
                                    <div class="timeline-footer">
                                        <a class="btn btn-default btn-xs" href="{{ url('user', $user->uniqueid()) }}">
                                            <i class="fa fa-eye" data-toggle="tooltip" data-placement="left" data-title="View"></i>
                                        </a>
                                        <a class="btn btn-primary btn-xs" href="{{ route('user.edit', $user->uniqueid()) }}">
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
