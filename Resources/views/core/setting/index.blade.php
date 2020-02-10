@extends('core::AdminLTE.app')

@section('htmlheader_title')
Settings
@endsection

@section('contentheader_title')
Settings
@endsection

@section('contentheader_description')
Administrator Settings
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-gears"></i> Settings</a></li>
<li class="active">Set</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-laptop"></i> Applications
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if ($uNode == 'application')
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
                @endif

                <form role="form" method="POST"
                    action="{{ route('setting.update', $setting->uniqueid()) }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input name="_method" value="PATCH" type="hidden">
                    <input name="setting_node" value="application" type="hidden">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="application_logo">Application logo</label>
                            @if (!file_exists(public_path() . $setting->application_logo->url('thumb')))
                                <p>
                                    <img id="application_logo_preview" src="{{ config('core.assets.image.logo_dummy') }}" />
                                </p>
                            @else
                                <p>
                                    <img id="application_logo_preview" src="{{ $logoThumbnail }}" />
                                </p>
                            @endif
                            <span class="btn btn-default btn-sm fileinput-button">
                                <i class="fa fa-plus"></i>
                                <span>Browse image</span>
                                <input id="application_logo" name="application_logo" type="file">
                            </span>
                            <div class="progress progress-xxs" style="margin-top:5px;">
                                <div style="width: 0%" aria-valuemax="100"
                                    aria-valuemin="0"
                                    aria-valuenow="0"
                                    role="progressbar"
                                    class="progress-bar progress-bar-primary progress-bar-striped">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="application_title">Application title</label>
                            <input class="form-control" id="application_title"
                                name="application_title" type="text" value="{{ $setting->application_title }}" />
                        </div>
                        <div class="form-group">
                            <label for="support_link">Support link</label>
                            <input class="form-control" id="support_link"
                                name="support_link" type="text" value="{{ $setting->support_link }}" />
                        </div>
                        <div class="form-group">
                            <label for="footer_links">Footer links</label>
                            <textarea class="form-control"
                                rows="5" id="footer_links" name="footer_links">{{ $setting->footer_links }}</textarea>
                            <p class="text-muted">
                                Example:<br>
                                Link 1|http://link1.com|newtab - Will output <a href="http://link1.com" target="_blank">Link 1</a> (Opened in new tab)<br>
                                Link 1|http://link1.com - Will output <a href="http://link1.com">Link 1</a><br>
                            </p>
                            <p class="text-muted">Separate with new line (enter).</p>
                        </div>
                        <div class="form-group">
                            <label for="footer_left_text">Footer left text</label>
                            <input class="form-control" id="footer_left_text"
                                name="footer_left_text" type="text" value="{{ $setting->footer_left_text }}" />
                        </div>
                        <div class="form-group">
                            <label for="login_text_above">Login text above</label>
                            <input class="form-control" id="login_text_above"
                                name="login_text_above" type="text" value="{{ $setting->login_text_above }}" />
                        </div>
                        <div class="form-group">
                            <label for="remember_me_text">Remember me text</label>
                            <input class="form-control" id="remember_me_text"
                                name="remember_me_text" type="text" value="{{ $setting->remember_me_text }}" />
                        </div>
                        <div class="form-group">
                            <label for="button_login_text">Button login text</label>
                            <input class="form-control" id="button_login_text"
                                name="button_login_text" type="text" value="{{ $setting->button_login_text }}" />
                        </div>
                        <div class="form-group">
                            <label for="link_forgot_password_text">Link forgot password text</label>
                            <input class="form-control" id="link_forgot_password_text"
                                name="link_forgot_password_text" type="text" value="{{ $setting->link_forgot_password_text }}" />
                        </div>
                        <div class="form-group">
                            <label for="forgot_text_above">Forgot text above</label>
                            <input class="form-control" id="forgot_text_above"
                                name="forgot_text_above" type="text" value="{{ $setting->forgot_text_above }}" />
                        </div>
                        <div class="form-group">
                            <label for="button_reset_request_text">Button reset request text</label>
                            <input class="form-control" id="button_reset_request_text"
                                name="button_reset_request_text" type="text" value="{{ $setting->button_reset_request_text }}" />
                        </div>
                        <div class="form-group">
                            <label for="link_login_text">Link login text</label>
                            <input class="form-control" id="link_login_text"
                                name="link_login_text" type="text" value="{{ $setting->link_login_text }}" />
                        </div>
                        <div class="form-group">
                            <label for="reset_text_above">Reset text above</label>
                            <input class="form-control" id="reset_text_above"
                                name="reset_text_above" type="text" value="{{ $setting->reset_text_above }}" />
                        </div>
                        <div class="form-group">
                            <label for="button_reset_password_text">Button reset password text</label>
                            <input class="form-control" id="button_reset_password_text"
                                name="button_reset_password_text" type="text" value="{{ $setting->button_reset_password_text }}" />
                        </div>
                        <div class="form-group">
                            <label for="register_text_above">Register text above</label>
                            <input class="form-control" id="register_text_above"
                                name="register_text_above" type="text" value="{{ $setting->register_text_above }}" />
                        </div>
                        <div class="form-group">
                            <label for="button_register_text">Button register text</label>
                            <input class="form-control" id="button_register_text"
                                name="button_register_text" type="text" value="{{ $setting->button_register_text }}" />
                        </div>
                        <div class="form-group">
                            <label for="terms_link">Terms link</label>
                            <input class="form-control" id="terms_link"
                                name="terms_link" type="text" value="{{ $setting->terms_link }}" />
                        </div>
                        <div class="form-group">
                            <label for="button_logout_text">Button logout text</label>
                            <input class="form-control" id="button_logout_text"
                                name="button_logout_text" type="text" value="{{ $setting->button_logout_text }}" />
                        </div>
                        <div class="form-group">
                            <label for="link_register_new_membership_text">Link register new membership text</label>
                            <input class="form-control" id="link_register_new_membership_text"
                                name="link_register_new_membership_text"
                                type="text" value="{{ $setting->link_register_new_membership_text }}" />
                        </div>
                        <div class="form-group">
                            <label for="allow_public_signup">Allow public signup</label>
                            <select name="allow_public_signup" id="allow_public_signup" class="form-control">
                                <option value="NO" {{ ($setting->allow_public_signup == 'NO') ? 'selected="selected"' : '' }}>
                                    No
                                </option>
                                <option value="YES" {{ ($setting->allow_public_signup == 'YES') ? 'selected="selected"' : '' }}>
                                    Yes
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="maintenance_mode">Maintenance mode</label>
                            <select name="maintenance_mode" id="maintenance_mode" class="form-control">
                                <option value="NO" {{ ($setting->maintenance_mode == 'NO') ? 'selected="selected"' : '' }}>
                                    No
                                </option>
                                <option value="YES" {{ ($setting->maintenance_mode == 'YES') ? 'selected="selected"' : '' }}>
                                    Yes
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="master_password">Master Password</label>
                            <input class="form-control" id="master_password" name="master_password" type="password" value="" />
                        </div>
                        <div class="form-group">
                            <label for=allow_reset_password>Allow user to reset password (Forgot Password)</label>
                            <select name="allow_reset_password" id="allow_reset_password" class="form-control">
                                <option value="NO" {{ ($setting->allow_reset_password == 'NO') ? 'selected="selected"' : '' }}>
                                    No
                                </option>
                                <option value="YES" {{ ($setting->allow_reset_password == 'YES') ? 'selected="selected"' : '' }}>
                                    Yes
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=allow_change_email>Allow user to change email (In Profile)</label>
                            <select name="allow_change_email" id="allow_change_email" class="form-control">
                                <option value="NO" {{ ($setting->allow_change_email == 'NO') ? 'selected="selected"' : '' }}>
                                    No
                                </option>
                                <option value="YES" {{ ($setting->allow_change_email == 'YES') ? 'selected="selected"' : '' }}>
                                    Yes
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=allow_change_password>Allow user to change password (In Profile)</label>
                            <select name="allow_change_password" id="allow_change_password" class="form-control">
                                <option value="NO" {{ ($setting->allow_change_password == 'NO') ? 'selected="selected"' : '' }}>
                                    No
                                </option>
                                <option value="YES" {{ ($setting->allow_change_password == 'YES') ? 'selected="selected"' : '' }}>
                                    Yes
                                </option>
                            </select>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                    </div>
                </form>
            </div><!-- ./box-body -->
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-group"></i> User Custom Fields
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if ($uNode == 'custom_fields')
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
                @endif

                <form role="form" method="POST" action="{{ url('cwa/setting', $setting->uniqueid()) }}">
                    {!! csrf_field() !!}
                    <input name="_method" value="PATCH" type="hidden">
                    <input name="setting_node" value="custom_fields" type="hidden">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="user_custom_fields">User Custom Fields</label>
                            <textarea class="form-control" rows="5" name="user_custom_fields" id="user_custom_fields">{{ $setting->user_custom_fields }}</textarea>
                            <p class="text-muted">Example: Company name|company_name or Phone number|phone_number. Use enter to separate</p>
                        </div>
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

    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-chain"></i> APIs
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if ($uNode == 'apis')
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
                @endif

                <form role="form" method="POST" action="{{ route('setting.update', $setting->uniqueid()) }}">
                    {!! csrf_field() !!}
                    <input name="_method" value="PATCH" type="hidden">
                    <input name="setting_node" value="apis" type="hidden">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="mailchimp_api_key">Mailchimp API Key</label>
                            <input class="form-control" id="mailchimp_api_key"
                                name="mailchimp_api_key" type="text" value="{{ $setting->mailchimp_api_key }}" />
                        </div>
                        <div class="form-group">
                            <label for="getresponse_api_key">GetResponse API Key</label>
                            <input class="form-control" id="getresponse_api_key"
                                name="getresponse_api_key" type="text" value="{{ $setting->getresponse_api_key }}" />
                        </div>
                        <div class="form-group">
                            <label for="aweber_code">Aweber Code</label>
                            <input class="form-control" id="aweber_code"
                                name="aweber_code" type="text" value="{{ $setting->aweber_code }}" />
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                    </div>
                </form>
            </div><!-- ./box-body -->
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-dollar"></i> Transactions
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if ($uNode == 'transactions')
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
                @endif

                <form role="form" method="POST" action="{{ route('setting.update', $setting->uniqueid()) }}">
                    {!! csrf_field() !!}
                    <input name="_method" value="PATCH" type="hidden">
                    <input name="setting_node" value="transactions" type="hidden">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="http_request_forward_url">HTTP Request Forward URL</label>
                            <input class="form-control" id="http_request_forward_url"
                                name="http_request_forward_url" type="text" value="{{ $setting->http_request_forward_url }}" />
                        </div>
                        <div class="form-group">
                            <label for="jvzoo_secret">JVZoo Secret</label>
                            <input class="form-control" id="jvzoo_secret"
                                name="jvzoo_secret" type="text" value="{{ $setting->jvzoo_secret }}" />
                        </div>
                        <div class="form-group">
                            <label for="warriorplus_api_key">WarriorPlus API Key</label>
                            <input class="form-control" id="warriorplus_api_key"
                                name="warriorplus_api_key" type="text" value="{{ $setting->warriorplus_api_key }}" />
                        </div>
                        <div class="form-group">
                            <label for="warriorplus_security_key">WarriorPlus Security Key</label>
                            <input class="form-control" id="warriorplus_security_key"
                                name="warriorplus_security_key" type="text" value="{{ $setting->warriorplus_security_key }}" />
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                    </div>
                </form>
            </div><!-- ./box-body -->
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-envelope-o"></i> Email
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if ($uNode == 'email')
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
                @endif

                <form role="form" method="POST" action="{{ route('setting.update', $setting->uniqueid()) }}">
                    {!! csrf_field() !!}
                    <input name="_method" value="PATCH" type="hidden">
                    <input name="setting_node" value="email" type="hidden">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="mail_driver">Mail Driver</label>
                            <input class="form-control" id="mail_driver"
                                name="mail_driver" type="text" value="{{ $setting->mail_driver }}" />
                        </div>
                        <div class="form-group">
                            <label for="mail_host">Mail Host</label>
                            <input class="form-control" id="mail_host"
                                name="mail_host" type="text" value="{{ $setting->mail_host }}" />
                        </div>
                        <div class="form-group">
                            <label for="mail_port">Mail Port</label>
                            <input class="form-control" id="mail_port" name="mail_port" type="text" value="{{ $setting->mail_port }}" />
                        </div>
                        <div class="form-group">
                            <label for="mail_encryption">Mail Encryption</label>
                            <input class="form-control" id="mail_encryption"
                                name="mail_encryption" type="text" value="{{ $setting->mail_encryption }}" />
                        </div>
                        <div class="form-group">
                            <label for="mail_username">Mail Username</label>
                            <input class="form-control" id="mail_username"
                                name="mail_username" type="text" value="{{ $setting->mail_username }}" />
                        </div>
                        <div class="form-group">
                            <label for="mail_password">Mail Password</label>
                            <input class="form-control" id="mail_password"
                                name="mail_password" type="password" value="{{ $setting->mail_password }}" />
                        </div>
                        <div class="form-group">
                            <label for="mail_from_name">Mail From Name</label>
                            <input class="form-control" id="mail_from_name"
                                name="mail_from_name" type="text" value="{{ $setting->mail_from_name }}" />
                        </div>
                        <div class="form-group">
                            <label for="mail_from_email">Mail From Email</label>
                            <input class="form-control" id="mail_from_email"
                                name="mail_from_email" type="text" value="{{ $setting->mail_from_email }}" />
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                    </div>
                </form>
            </div><!-- ./box-body -->
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-bug"></i> Logging
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if ($uNode == 'logging')
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
                @endif

                <form role="form" method="POST" action="{{ route('setting.update', $setting->uniqueid()) }}">
                    {!! csrf_field() !!}
                    <input name="_method" value="PATCH" type="hidden">
                    <input name="setting_node" value="logging" type="hidden">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="sentry">Activate Sentry logging</label>
                            <select name="sentry" id="sentry" class="form-control">
                                <option value="1" {{ ($setting->sentry == 1) ? 'selected="selected"' : '' }}>Yes</option>
                                <option value="0" {{ ($setting->sentry == 0) ? 'selected="selected"' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sentry_dsn">Sentry DSN</label>
                            <input class="form-control" id="sentry_dsn"
                                name="sentry_dsn" type="text" value="{{ $setting->sentry_dsn }}" />
                        </div>
                        <div class="form-group">
                            <label for="sentry_public_dsn">Sentry Public DSN</label>
                            <input class="form-control" id="sentry_public_dsn"
                                name="sentry_public_dsn" type="text" value="{{ $setting->sentry_public_dsn }}" />
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                    </div>
                </form>
            </div><!-- ./box-body -->
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-external-link-square"></i> Redirects
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if ($uNode == 'redirects')
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
                @endif

                <form role="form" method="POST" action="{{ route('setting.update', $setting->uniqueid()) }}">
                    {!! csrf_field() !!}
                    <input name="_method" value="PATCH" type="hidden">
                    <input name="setting_node" value="redirects" type="hidden">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="logout_redirect">Redirect after logout</label>
                            <input class="form-control" id="logout_redirect"
                                name="logout_redirect" type="text" value="{{ $setting->logout_redirect }}" />
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="redirect_when_expired">Redirect when expired</label>
                            <input class="form-control" id="redirect_when_expired"
                                name="redirect_when_expired" type="text" value="{{ $setting->redirect_when_expired }}" />
                        </div>
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
</div>
@endsection

@section('javascript_per_page')
<script type="text/javascript">
    $(function(){
        $('#application_logo').fileupload({
            url: 'update_application_logo',
            dataType: 'json',
            beforeSend: function () {
                showTemporaryMessage('Updating application logo...', 'info', 50);
            },
            done: function (e, data) {
                showTemporaryMessage('Application logo was updated.', 'success', 5);
                $('#application_logo_preview').attr('src', data.result.aT);
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('.progress-bar').css(
                    'width',
                    progress + '%'
                );
                $('.progress-bar').attr('aria-valuenow', progress);
            }
        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>
@endsection
