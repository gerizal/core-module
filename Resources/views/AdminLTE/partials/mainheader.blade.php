<?php
    $avatar = Auth::user()->avatar->url('thumb');
    $avatar = str_ireplace('/system/App/User', '', $avatar);
    $avatar = str_ireplace('/system/Modules/Core/User', '', $avatar);

    $av = config('core.assets.image.avatar_dummy');

    if (file_exists(public_path('/system/App/User' . $avatar))) {
        $av = url('system/App/User' . $avatar);
    } elseif (file_exists(public_path('/system/Modules/Core/User' . $avatar))) {
        $av = url('system/Modules/Core/User' . $avatar);
    }
?>
<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="{{ url('/home') }}" class="navbar-brand">{{ SettingHelper::application_title() }}</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <!-- Extends application menu from application -->
                @if (View::exists('cwaextends.applicationmenu'))
                    @include('cwaextends.applicationmenu')
                @endif
            </div><!-- /.navbar-collapse -->

            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    {{--@include('core::AdminLTE.partials.messagemenu')--}}
                    {{--@include('core::AdminLTE.partials.notificationmenu')--}}
                    {{--@include('core::AdminLTE.partials.taskmenu')--}}
                    <?php
                    use Modules\Core\UserLevel;

                    $ul = UserLevel::find(1);
                    $adminUserLevelId = 1;

                    if (!is_null($ul)) :
                        $adminUserLevelId = $ul->id;
                    endif;
            
                    $arrayUserlevelIds = json_decode(Auth::user()->userpreference->userlevel_id);
                    
                    if (is_array($arrayUserlevelIds)) :
                        if (in_array($adminUserLevelId, $arrayUserlevelIds)) : ?>
                            <!-- Administrator Menu -->
                            <li class="dropdown administrator-menu">
                                <a aria-expanded="false" href="#"
                                    class="dropdown-toggle"
                                    data-toggle="dropdown">Administrator <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    @if(Module::has('Core'))
                                        <li><a href="{{ url('/user') }}">Users</a></li>
                                        <li><a href="{{ url('/user_level') }}">User Levels</a></li>
                                        <li><a href="{{ url('/feature') }}">Features</a></li>
                                        <li><a href="{{ url('/setting') }}">Settings</a></li>
                                        <li><a href="{{ url('/appearance')}}">Appearance</a></li>
                                        <li class="divider"></li>
                                    @endif
                                    @if(Module::has('Plugin'))
                                        <li><a href="{{ url('/plugin') }}">Plugins</a></li>
                                        <li class="divider"></li>
                                    @endif
                                    @if(Module::has('Trigger'))
                                        <li><a href="{{ url('/trigger') }}">Triggers</a></li>
                                        <li class="divider"></li>
                                    @endif
                                    @if(Module::has('Product'))
                                        <li><a href="{{ url('/product') }}">Products</a></li>
                                    @endif
                                    @if(Module::has('News'))
                                        <li><a href="{{ url('/news') }}">News</a></li>
                                    @endif
                                    @if(Module::has('Hook'))
                                        <li><a href="{{ url('/hook') }}">Hooks</a></li>
                                    @endif
                                    @if(Module::has('Ads'))
                                        <li><a href="{{ url('/ads') }}">Ads</a></li>
                                    @endif
                                    @if(Module::has('Notification'))
                                        <li><a href="{{ url('/notification') }}">Notifications</a></li>
                                    @endif
                                    @if(Module::has('EmailPreference'))
                                        <li class="divider"></li>
                                        <li><a href="{{ url('/email_preference') }}">Email Preferences</a></li>
                                    @endif
                                    @if(Module::has('EmailHook'))
                                        <li><a href="{{ url('/email_hook') }}">Email Hooks</a></li>
                                        <li class="divider"></li>
                                    @endif
                                    @if(Module::has('Infusionsoft'))
                                        <li><a href="{{ url('/infusionsoft') }}">Infusionsoft</a></li>
                                    @endif
                                    @if(Module::has('Slack'))
                                        <li><a href="{{ url('/slack') }}">Slack</a></li>
                                    @endif
                                </ul>
                            </li>
                        <?php
                        endif;
                        ?>
                    <?php
                    endif;
                    ?>

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ $av }}" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{ $av }}" class="img-circle" alt="User Image">
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>Member since {{ date('F Y', strtotime( Auth::user()->created_at )) }}</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="col-xs-12 text-center">
                                    @if(Module::has('Core'))
                                        <a href="{{ url('/integration') }}">Integrations</a>
                                    @endif
                                </div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    @if(Module::has('Core'))
                                        <a href="{{ url('/profile') }}" class="btn btn-default btn-flat">Profile</a>
                                    @endif
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/auth/logout') }}" class="btn btn-default btn-flat">
                                        {{ SettingHelper::button_logout_text() }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-custom-menu -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
