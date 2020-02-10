<!-- Messages: style can be found in dropdown.less-->
<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-envelope-o"></i>
        <span class="label label-success">4</span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">You have 4 messages</li>
        <li>
            <!-- inner menu: contains the messages -->
            <div style="position: relative; overflow: hidden; width: auto; height: 200px;" class="slimScrollDiv">
                <ul style="overflow: hidden; width: 100%; height: 200px;" class="menu">
                    <li><!-- start message -->
                        <a href="#">
                            <div class="pull-left">
                                <!-- User Image -->
                                @if (!file_exists(public_path() . Auth::user()->avatar->url('thumb')))
                                    <img src="{{ config('core.assets.image.avatar_dummy') }}"
                                        class="img-circle" alt="User Image">
                                @else
                                    <img src="{{ url() . Auth::user()->avatar->url('thumb') }}"
                                        class="img-circle" alt="User Image">
                                @endif
                            </div>
                            
                            <!-- Message title and timestamp -->
                            <h4>
                                Support Team
                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                            </h4>
                            
                            <!-- The message -->
                            <p>Why not buy a new awesome theme?</p>
                        </a>
                    </li><!-- end message -->
                </ul>
                <div style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;" class="slimScrollBar"></div>
                <div style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;" class="slimScrollRail"></div>
            </div><!-- /.menu -->
        </li>
        <li class="footer"><a href="#">See All Messages</a></li>
    </ul>
</li><!-- /.messages-menu -->
