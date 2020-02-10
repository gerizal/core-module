@extends('core::AdminLTE.app')

@section('htmlheader_title')
User - {{ $user->name }}
@endsection

@section('contentheader_title')
{{ $user->name }}
@endsection

@section('contentheader_description')
{{ $user->email }}
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-users"></i> Users</a></li>
<li class="active">Show</li>
@endsection

<?php
use Modules\Core\Userlevel;

$strLastLoggedIn    = $user->userpreference->last_logged_in;
if ($strLastLoggedIn == '1970-01-01 00:00:00') {
    $lastLoggedIn   = 'Unknown';
} else {
    $lastLoggedIn   = date('M j, Y g:ia', strtotime($strLastLoggedIn));
}

$userLevelIds       = json_decode($user->userpreference->userlevel_id);
$ulName             = '';

if (!empty($userLevelIds)) {
    foreach ($userLevelIds as $ulId) {
        $ulObj      = Userlevel::where('id', '=', $ulId)->first();
        $ulName    .= $ulObj->name . '&nbsp;';
    }
}
?>

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
                <div class="form-group">
                    <label for="title"><h3>{{ $user->name }}</h3></label>
                </div>
                <div class="form-group">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="#">Email <span class="pull-right text-red">{{ $user->email }}</span></a></li>
                        <li>
                            <a href="#">
                                Is user active 
                                <span class="pull-right text-red">{{ $user->userpreference->is_user_active }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Display notice 
                                <span class="pull-right text-red">{{ $user->userpreference->display_notice }}</span>
                            </a>
                        </li>
                        <li><a href="#">Last logged in <span class="pull-right text-red">{{ $lastLoggedIn }}</span></a></li>
                        <li><a href="#">User levels <span class="pull-right text-red">{{ $ulName }}</span></a></li>
                        <li>
                            <a href="#">API Key <span class="pull-right text-red">{{ $user->userpreference->api_key }}</span></a>
                        </li>
                        <li>
                            <a href="#">
                                Affiliate ID 
                                <span class="pull-right text-red">{{ $user->userpreference->affiliate_id }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Created at 
                                <span class="pull-right text-red">{{ date('M j, Y g:ia', strtotime($user->created_at)) }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Updated at 
                                <span class="pull-right text-red">{{ date('M j, Y g:ia', strtotime($user->updated_at)) }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>
@endsection
