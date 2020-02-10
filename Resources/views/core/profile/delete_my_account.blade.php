@extends('core::AdminLTE.app')

@section('htmlheader_title')
Delete My Account
@endsection

@section('contentheader_title')
Delete My Account
@endsection

@section('contentheader_description')
{{ $profile->email }}
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-newspaper-o"></i> Profile</a></li>
<li class="active">Delete My Account</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Confirm to delete account {{ $profile->email }}.
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

                @if (session('errorPassConf'))
                    <div class="box-body">
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                            {!! session('errorPassConf') !!}
                        </div>
                    </div>
                @endif

                <form role="form" method="POST" action="{{ url('profile/'.$profile->uniqueid().'/confirm_delete_my_account') }}">
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" id="password" name="password" type="password" style="width:50%;"/>
                            <p class="help-block">Please provide us your password and then click Delete My Account to continue.</p>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete My Account</button>
                    </div>
                </form>
            </div><!-- ./box-body -->
        </div>
    </div>
</div>
@endsection
