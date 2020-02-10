@extends('core::AdminLTE.app')

@section('htmlheader_title')
Integrations
@endsection

@section('contentheader_title')
Integrations
@endsection

@section('contentheader_description')
Integrations
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-leaf"></i> Integrations</a></li>
<li class="active">Set</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-gears"></i> Integrations
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="li_menu {{ ($uNode == 'autoresponders') ? 'active' : '' }}">
                            <a href="{{ url('/integration') }}">Autoresponders</a>
                        </li>
                        <li class="li_menu {{ ($uNode == 'twilio') ? 'active' : '' }}">
                            <a href="{{ url('/integration?twilio') }}">Twilio</a>
                        </li>
                        <li class="li_menu {{ ($uNode == 'google') ? 'active' : '' }}">
                            <a href="{{ url('/integration?google') }}">Google</a>
                        </li>
                    </ul>
                    <div class="tab-content">
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

                        <div id="autoresponders" class="tab-pane {{ ($uNode == 'autoresponders') ? 'active' : '' }}">
                            <form role="form" method="POST" action="{{ route('integration.update', $userintegration->uniqueid()) }}">
                                {!! csrf_field() !!}
                                <input name="_method" value="PATCH" type="hidden">
                                <input name="integration_node" value="autoresponders" type="hidden">
                                <div class="box-body">
                                    <div id="accordion" class="box-group">
                                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                        <div class="panel box box-primary">
                                            <div class="box-header with-border">
                                                <h4 class="box-title">
                                                    <a href="#Aweber" data-parent="#accordion" data-toggle="collapse">
                                                        Aweber
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse in" id="Aweber">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label for="aweber_code">Aweber Code</label>
                                                        <input class="form-control" id="aweber_code"
                                                            name="aweber_code" type="text" value="{{ $userintegration->aweber_code }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel box box-danger">
                                            <div class="box-header with-border">
                                                <h4 class="box-title">
                                                    <a href="#GetResponse" data-parent="#accordion" data-toggle="collapse">
                                                        GetResponse
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse" id="GetResponse">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label for="getresponse_api_key">GetResponse API Key</label>
                                                        <input class="form-control" id="getresponse_api_key"
                                                            name="getresponse_api_key"
                                                            type="text" value="{{ $userintegration->getresponse_api_key }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel box box-success">
                                            <div class="box-header with-border">
                                                <h4 class="box-title">
                                                    <a href="#MailChimp" data-parent="#accordion" data-toggle="collapse">
                                                        MailChimp
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse" id="MailChimp">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label for="mailchimp_api_key">Mailchimp API Key</label>
                                                        <input class="form-control" id="mailchimp_api_key"
                                                            name="mailchimp_api_key"
                                                            type="text" value="{{ $userintegration->mailchimp_api_key }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel box box-primary">
                                            <div class="box-header with-border">
                                                <h4 class="box-title">
                                                    <a href="#ActiveCampaign" data-parent="#accordion" data-toggle="collapse">
                                                        ActiveCampaign
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse" id="ActiveCampaign">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label for="activecampaign_api_url">ActiveCampaign API Url</label>
                                                        <input class="form-control" id="activecampaign_api_url"
                                                            name="activecampaign_api_url"
                                                            type="text" value="{{ $userintegration->activecampaign_api_url }}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="activecampaign_api_key">ActiveCampaign API Key</label>
                                                        <input class="form-control" id="activecampaign_api_key"
                                                            name="activecampaign_api_key"
                                                            type="text" value="{{ $userintegration->activecampaign_api_key }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel box box-danger">
                                            <div class="box-header with-border">
                                                <h4 class="box-title">
                                                    <a href="#MadMimi" data-parent="#accordion" data-toggle="collapse">
                                                        MadMimi
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse" id="MadMimi">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label for="madmimi_email">MadMimi Email</label>
                                                        <input class="form-control" id="madmimi_email" name="madmimi_email"
                                                            type="text" value="{{ $userintegration->madmimi_email }}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="madmimi_api_key">MadMimi API Key</label>
                                                        <input class="form-control" id="madmimi_api_key" name="madmimi_api_key"
                                                            type="text" value="{{ $userintegration->madmimi_api_key }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel box box-success">
                                            <div class="box-header with-border">
                                                <h4 class="box-title">
                                                    <a href="#ConstantContact" data-parent="#accordion" data-toggle="collapse">
                                                        ConstantContact
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse" id="ConstantContact">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label for="constantcontact_api_key">ConstantContact API Key</label>
                                                        <input class="form-control" id="constantcontact_api_key"
                                                            name="constantcontact_api_key"
                                                            type="text" value="{{ $userintegration->constantcontact_api_key }}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="constantcontact_access_token">ConstantContact Access Token</label>
                                                        <input class="form-control" id="constantcontact_access_token"
                                                            name="constantcontact_access_token"
                                                            type="text" value="{{ $userintegration->constantcontact_access_token }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel box box-primary">
                                            <div class="box-header with-border">
                                                <h4 class="box-title">
                                                    <a href="#iContact" data-parent="#accordion" data-toggle="collapse">
                                                        iContact
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse" id="iContact">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label for="icontact_app_id">iContact App ID</label>
                                                        <input class="form-control" id="icontact_app_id"
                                                            name="icontact_app_id"
                                                            type="text" value="{{ $userintegration->icontact_app_id }}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="icontact_api_password">iContact API Password</label>
                                                        <input class="form-control" id="icontact_api_password"
                                                            name="icontact_api_password"
                                                            type="text" value="{{ $userintegration->icontact_api_password }}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="icontact_api_username">iContact API Username</label>
                                                        <input class="form-control" id="icontact_api_username"
                                                            name="icontact_api_username"
                                                            type="text" value="{{ $userintegration->icontact_api_username }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                                </div>
                            </form>
                        </div><!-- /.tab-pane -->

                        <div id="twilio" class="tab-pane {{ ($uNode == 'twilio') ? 'active' : '' }}">
                            <form role="form" method="POST" action="{{ route('integration.update', $userintegration->uniqueid()) }}">
                                {!! csrf_field() !!}
                                <input name="_method" value="PATCH" type="hidden">
                                <input name="integration_node" value="twilio" type="hidden">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="twilio_account_sid">Twilio Account SID</label>
                                        <input class="form-control" id="twilio_account_sid"
                                            name="twilio_account_sid" type="text" value="{{ $userintegration->twilio_account_sid }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="twilio_auth_token">Twilio Auth Token</label>
                                        <input class="form-control" id="twilio_auth_token"
                                            name="twilio_auth_token" type="text" value="{{ $userintegration->twilio_auth_token }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="twilio_number">Twilio Number</label>
                                        <input class="form-control" id="twilio_number"
                                            name="twilio_number" type="text" value="{{ $userintegration->twilio_number }}" />
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-floppy-o"></i> Submit
                                    </button>
                                </div>
                            </form>
                        </div><!-- /.tab-pane -->

                        <div id="google" class="tab-pane {{ ($uNode == 'google') ? 'active' : '' }}">
                            <form role="form" method="POST" action="{{ route('integration.update', $userintegration->uniqueid()) }}">
                                {!! csrf_field() !!}
                                <input name="_method" value="PATCH" type="hidden">
                                <input name="integration_node" value="google" type="hidden">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="google_client_id">Google Client ID</label>
                                        <input class="form-control" id="google_client_id"
                                            name="google_client_id" type="text" value="{{ $userintegration->google_client_id }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="google_client_secret">Google Client Secret</label>
                                        <input class="form-control" id="google_client_secret"
                                            name="google_client_secret" type="text" value="{{ $userintegration->google_client_secret }}" />
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                                </div>
                            </form>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div>
            </div><!-- ./box-body -->
        </div>
    </div>
</div>
@endsection

@section('javascript_per_page')
<script type="text/javascript">
    $(function(){
        
    });
</script>
@endsection
