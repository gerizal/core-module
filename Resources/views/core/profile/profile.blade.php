@extends('core::AdminLTE.app')

@section('htmlheader_title')
Profile
@endsection

@section('contentheader_title')
Profile
@endsection

@section('contentheader_description')
{{ $profile->email }}
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-newspaper-o"></i> Profile</a></li>
<li class="active">View</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Welcome, {{ $profile->email }}.
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="li_menu {{ ($uNode == 'profile') ? 'active' : '' }}">
                            <a href="{{ url('/profile') }}">Profile</a>
                        </li>
                        <li class="li_menu {{ ($uNode == 'subscription') ? 'active' : '' }}">
                            <a href="{{ url('/profile?subscription') }}">News and Notifications</a>
                        </li>
                        <li class="li_menu {{ ($uNode == 'advance') ? 'active' : '' }}">
                            <a href="{{ url('/profile?advance') }}">Advance</a>
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

                        <div id="profile" class="tab-pane {{ ($uNode == 'profile') ? 'active' : '' }}">
                            <form role="form" method="POST" action="{{ route('profile.update', $profile->uniqueid()) }}"
                                enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <input name="_method" value="PATCH" type="hidden">
                                <input name="_node" value="profile" type="hidden">
                                <div class="box-body">
                                    <div class="row text-center">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <button class="btn btn-default btn-sm select-image-btn pull-left"
                                                        type="button">
                                                        <i class="fa fa-image"></i> Select image
                                                    </button>
                                                    <button class="btn btn-default btn-sm pull-right"
                                                        id="update_avatar" type="button">
                                                        <i class="fa fa-save"></i> Update avatar
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div id="image-cropper">
                                                        <div class="cropit-image-preview"
                                                            style="{{ !empty($avatarOriginal) ? 'cursor:default;' : '' }} background-image:url('{{ $avatarOriginal }}');
                                                                background-repeat:no-repeat;">
                                                        </div>
                                                        <input type="file" class="cropit-image-input"/>
                                                        <div class="col-xs-2 text-right avatar_hidden_tools">
                                                            <i class="fa fa-fw fa-search-minus"></i>
                                                        </div>
                                                        <div class="col-xs-8 text-right avatar_hidden_tools">
                                                            <input type="range" class="cropit-image-zoom-input"/>
                                                        </div>
                                                        <div class="col-xs-2 text-left avatar_hidden_tools">
                                                            <i class="fa fa-fw fa-search-plus"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="my_level">My level</label>
                                                <p>{!! $ulName !!}</p>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input class="form-control" id="name" name="name"
                                                    type="text" value="{{ $profile->name }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            @if (SettingHelper::allow_change_email() == 'YES')
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input class="form-control" id="email"
                                                        name="email" type="email" value="{{ $profile->email }}" />
                                                </div>
                                            @else
                                                <input id="email" name="email" type="hidden" value="{{ $profile->email }}" />
                                            @endif
                                
                                            @if (SettingHelper::allow_change_password() == 'YES')
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input class="form-control" id="password" name="password" type="password" />
                                                    <p class="help-block">Leave blank if you don't want to update the password.</p>
                                                </div>
                                            @else
                                                <input id="password" name="password" type="hidden" />
                                            @endif
                                
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-floppy-o"></i> Submit
                                    </button>
                                </div>
                            </form>
                        </div><!-- /.tab-pane -->

                        <div id="subscription" class="tab-pane {{ ($uNode == 'subscription') ? 'active' : '' }}">
                            <form role="form" method="POST"
                                action="{{ route('profile.update', $profile->uniqueid()) }}"
                                enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <input name="_method" value="PATCH" type="hidden">
                                <input name="_node" value="subscription" type="hidden">
                                <div class="box-body">
                                    <div class="box-body">
                                        <div class="form-group">
                                            Receive news <input type="radio" name="news" value="YES" {{ ($userSubscription->news == 'YES') ? 'checked="checked"' : '' }}/> Yes <input type="radio" name="news" value="NO" {{ ($userSubscription->news == 'NO') ? 'checked="checked"' : '' }}/> No
                                        </div>
                                        <div class="form-group">
                                            Receive notifications <input type="radio" name="notifications" value="YES" {{ ($userSubscription->notifications == 'YES') ? 'checked="checked"' : '' }}/> Yes <input type="radio" name="notifications" value="NO" {{ ($userSubscription->notifications == 'NO') ? 'checked="checked"' : '' }}/> No
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-floppy-o"></i> Submit
                                    </button>
                                </div>
                            </form>
                        </div><!-- /.tab-pane -->

                        <div id="advance" class="tab-pane {{ ($uNode == 'advance') ? 'active' : '' }}">
                            <div class="box-body">
                                <div class="form-group">
                                    <a href="#" data-deleteaccountlink="{{ url('/profile/'.$profile->uniqueid().'/delete_my_account') }}"
                                        class="btn btn-danger" id="delete_my_account">
                                        <i class="fa fa-fw fa-trash-o"></i> Delete My Account
                                    </a>
                                    <p class="help-block">
                                        WARNING: Your account and all data will be permanently deleted.
                                    </p>
                                </div>
                            </div>
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
        $('#image-cropper').cropit();

        $(document).on('click', '.select-image-btn', function () {
            $('.cropit-image-input').click();
        });

        $(document).on('change', '.cropit-image-input', function () {
            $('.cropit-image-preview').css('cursor', 'move');
            $('.avatar_hidden_tools').show();
        });

        $(document).on('click', '#update_avatar', function (e) {
            var el = $(this);
            var avatar = $('#image-cropper').cropit('export', {
                type: 'image/jpeg',
                originalSize: true,
            });
 
            var data = {'_method':'POST', '_token':'{{ csrf_token() }}', 'avatar':avatar};

            $.ajax({
                url: '{{ $updateAvatarUrl }}',
                type: 'POST',
                data: data,
                dataType: 'HTML',
                beforeSend: function () {
                    el.prop('disabled', true);
                    showTemporaryMessage('Updating your avatar...', 'info', 50);
                },
                complete: function () {
                    el.prop('disabled', false);
                },
                success: function (res) {
                    if (res == 'AVATAR_UPDATED') {
                        showTemporaryMessage('Avatar was updated.', 'success', 5);
                    } else {
                        showTemporaryMessage(res, 'error', 5);
                    }
                },
                error: function (a,b,c) {
                    showTemporaryMessage(c, 'error', 5);
                    return false;
                }
            });
        });

        $(document).on('click', '#delete_my_account', function (e) {
            e.preventDefault();

            var el = $(this);
            var deleteaccountlink = el.data('deleteaccountlink');

            msgDeleteAccount = Messenger().post({
                message: 'Are you sure you want to delete your account?',
                type: 'info',
                actions: {
                    deactivate: {
                        label: 'Continue',
                        action: function () {
                            try {
                                window.location.href = deleteaccountlink;
                            } catch (err) {
                                showTemporaryMessage(err.message, 'error', 5);
                            }
                        }
                    },
                    cancel: {
                        action: function () {
                            msgDeleteAccount.hide();
                        }
                    }
                }
            });
            return false;
        });
    });
</script>
@endsection
