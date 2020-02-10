@extends('core::core.auth.auth')

@section('htmlheader_title')
Log in
@endsection

@section('content')
<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            @if (file_exists(public_path() . SettingHelper::setting()->application_logo->url('thumb')))
                <div>
                    <a href="/">
                        <img src="{{ SettingHelper::logo('thumb') }}">
                    </a>
                </div>
            @endif
            <a href="/">{{SettingHelper::application_title()}}</a>
        </div><!-- /.login-logo -->

        @if (isset($errors) && count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('msgAccountDeletion'))
            <div class="box-body">
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                    {!! session('msgAccountDeletion') !!}
                </div>
            </div>
        @endif

        @if (session('message'))
            <div class="box-body">
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                    {!! session('message') !!}
                </div>
            </div>
        @endif

        <div class="login-box-body">
            <p class="login-box-msg">
                {!! SettingHelper::login_text_above() !!}
            </p>
            <form action="/auth/login" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="email"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> {{ SettingHelper::remember_me_text() }}
                            </label>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ SettingHelper::button_login_text() }}</button>
                    </div><!-- /.col -->
                </div>
            </form>
            @if (SettingHelper::allow_reset_password() == 'YES')
                <a href="/password/email">{{ SettingHelper::link_forgot_password_text() }}</a><br>
            @endif
            @if (SettingHelper::allow_public_signup() == 'YES')
                <a href="/auth/register" class="text-center">{{ SettingHelper::link_register_new_membership_text() }}</a>
            @endif
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- Bootstrap JS CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- iCheck CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js" type="text/javascript"></script>
    <script>
        $(function(){
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        });
    </script>
</body>
@endsection
