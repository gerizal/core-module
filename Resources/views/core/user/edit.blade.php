@extends('core::AdminLTE.app')

@section('htmlheader_title')
Edit User
@endsection

@section('contentheader_title')
Edit User
@endsection

@section('contentheader_description')
{{ $user->email }}
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-users"></i> Users</a></li>
<li class="active">Edit</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-12">
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
                <div class="row">
                    <div class="col-md-12">
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

                        <form role="form" method="POST" action="{{ route('user.update', $user->uniqueid()) }}">
                            {!! csrf_field() !!}
                            <input name="_method" value="PATCH" type="hidden">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" id="name" name="name" type="text" value="{{ $user->name }}" />
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" id="email" name="email" type="email" value="{{ $user->email }}" />
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control" id="password" name="password" type="text" />
                                    <p class="help-block">Leave blank if you don't want to update the password.</p>
                                </div>
                                @if (!empty($userlevels))
                                    <div class="form-group">
                                        <label for="userlevel_id">User level</label>
                                        <select name="userlevel_id[]" id="userlevel_id" class="form-control" multiple="">
                                            @foreach ($userlevels as $ulevel)
                                                <?php
                                                $selected = '';
                                                $userLevelIds = json_decode($user->userpreference->userlevel_id);
                                                if (in_array($ulevel->id, $userLevelIds)) :
                                                    $selected = 'selected="selected"';
                                                endif;
                                                ?>
                                                <option value="{{ $ulevel->id }}" {{ $selected }}>{{ $ulevel->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <input type="checkbox" name="reset_start_date" value="1"> Reset start date
                                </div>
                                <div class="form-group">
                                    <label for="affiliate_id">Affiliate ID</label>
                                    <input class="form-control" id="affiliate_id"
                                        name="affiliate_id" type="text" value="{{ $user->userpreference->affiliate_id }}" />
                                </div>
                                <hr>
                                <h3>User Custom Fields</h3>
                                @if (!empty($customFields))
                                    @foreach ($customFields as $cFields)
                                        <div class="form-group">
                                            <label for="{{ $cFields['field'] }}">{{ $cFields['name'] }}</label>
                                            <input class="form-control" id="{{ $cFields['field'] }}"
                                                name="custom_fields[{{ $cFields['field'] }}]" type="text" value="{{ Modules\Core\Helpers\UserHelper::getValueCustomField($user, $cFields['field']) }}" />
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
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- ./box-body -->
        </div>
    </div>
</div>
@endsection
