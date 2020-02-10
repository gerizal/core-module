<head>
    <meta charset="UTF-8">
    <title>
        {{ SettingHelper::application_title() }} - @yield('htmlheader_title', 'Your title here')
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap JS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Ion Slider -->
    <link href="{{ config('core.assets.css.ionslider') }}" rel="stylesheet" type="text/css" />
    <!-- ion slider Nice -->
    <link href="{{ config('core.assets.css.ionslider_skin_nice') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Slider CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.2.2/css/bootstrap-slider.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ config('core.assets.css.adminlte') }}" rel="stylesheet" type="text/css" />
    <!--
        AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ config('core.assets.css.adminlte_skin_all') }}" rel="stylesheet" type="text/css" />
    <!-- iCheck CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/blue.css" rel="stylesheet" type="text/css" />
    <!-- Datetimepicker CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet" type="text/css" />
    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css"
        rel="stylesheet" type="text/css" />
    <!-- Bootstrap WYSIHTML5 CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    <!-- jQuery Messenger -->
    <link href="{{ config('core.assets.css.messenger') }}" rel="stylesheet" type="text/css" />
    <link href="{{ config('core.assets.css.messenger_theme_future') }}" rel="stylesheet" type="text/css" />
    <link href="{{ config('core.assets.css.messenger_theme_ice')}}" rel="stylesheet" type="text/css" />
    <link href="{{ config('core.assets.css.messenger_theme_air')}}" rel="stylesheet" type="text/css" />
    <link href="{{ config('core.assets.css.messenger_theme_block')}}" rel="stylesheet" type="text/css" />
    <link href="{{ config('core.assets.css.messenger_theme_flat')}}" rel="stylesheet" type="text/css" />
    <link href="{{ config('core.assets.css.messenger_spinner')}}" rel="stylesheet" type="text/css" />
    <!-- jQuery File Upload CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.12.6/css/jquery.fileupload.min.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Extends header from application -->
    @if (View::exists('cwaextends.htmlheader'))
    @include('cwaextends.htmlheader')
    @endif

    <style type="text/css">
        .datatable_align_center {text-align: center;}
        .avatar_hidden_tools{display: none;}
        .cropit-image-preview {
            background-color: #f8f8f8;
            border-radius: 50%;
            background-size: cover;
            border: 1px solid #ccc;
            width: 150px;
            height: 150px;
            cursor: move;
            float: none;
            margin: 0 auto;
        }
        /* Show load indicator when image is being loaded */
        .cropit-image-preview.cropit-image-loading .spinner {opacity: 1;}
        /* Show move cursor when image has been loaded */
        .cropit-image-preview.cropit-image-loaded {cursor: move;}
        /* Gray out zoom slider when the image cannot be zoomed */
        .cropit-image-zoom-input[disabled] {opacity: .2;}
        /* Hide default file input button if you want to use a custom button */
        input.cropit-image-input {visibility: hidden;}
        /* The following styles are only relevant to when background image is enabled */
        /* Translucent background image */
        .cropit-image-background {opacity: .1;}
        /* Style the background image differently when preview area is hovered */
        .cropit-image-background.cropit-preview-hovered {opacity: .2;}
        /**
         * If the slider or anything else is covered by the background image,
         * use non-static position on it
         */
        input.cropit-image-zoom-input {position: relative;}
        /* Limit the background image by adding overflow: hidden */
        #image-cropper {overflow: hidden;}
    </style>
    
    @yield('css_per_page')
</head>
