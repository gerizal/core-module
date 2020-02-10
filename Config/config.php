<?php

return [
    'name'      => 'Core',
    'assets'    => [
        'css'   => [
            'bootstrap'                 => ConfigHelper::cssUrl('bootstrap.css'),
            'ionslider'                 => ConfigHelper::pluginsUrl('ionslider/ion.rangeSlider.css'),
            'ionslider_skin_nice'       => ConfigHelper::pluginsUrl('ionslider/ion.rangeSlider.skinNice.css'),
            'bootstrap_slider'          => ConfigHelper::pluginsUrl('bootstrap-slider/slider.css'),
            'adminlte'                  => ConfigHelper::cssUrl('AdminLTE.css'),
            'adminlte_skin_all'         => ConfigHelper::cssUrl('skins/_all-skins.min.css'),
            'icheck_square_blue'        => ConfigHelper::pluginsUrl('iCheck/square/blue.css'),
            'bootstrap_datetimepicker'  => ConfigHelper::pluginsUrl('datetimepicker/css/bootstrap-datetimepicker.min.css'),
            'datatables'                => ConfigHelper::pluginsUrl('datatables/jquery.dataTables.min.css'),
            'bootstrap_wysihtml5'       => ConfigHelper::pluginsUrl('bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'),
            'messenger'                 => ConfigHelper::pluginsUrl('messenger/css/messenger.css'),
            'messenger_theme_future'    => ConfigHelper::pluginsUrl('messenger/css/messenger-theme-future.css'),
            'messenger_theme_air'       => ConfigHelper::pluginsUrl('messenger/css/messenger-theme-air.css'),
            'messenger_theme_block'     => ConfigHelper::pluginsUrl('messenger/css/messenger-theme-block.css'),
            'messenger_theme_flat'      => ConfigHelper::pluginsUrl('messenger/css/messenger-theme-flat.css'),
            'messenger_theme_ice'       => ConfigHelper::pluginsUrl('messenger/css/messenger-theme-ice.css'),
            'messenger_spinner'         => ConfigHelper::pluginsUrl('messenger/css/messenger-spinner.css'),
            'fileupload'                => ConfigHelper::pluginsUrl('fileupload/css/jquery.fileupload.css'),
            'select2'                   => ConfigHelper::pluginsUrl('select2/select2.min.css'),
            'bootstrap_colorpicker'     => ConfigHelper::pluginsUrl('colorpicker/bootstrap-colorpicker.min.css'),
            'daterangepicker'           => ConfigHelper::pluginsUrl('daterangepicker/daterangepicker-bs3.css'),
            'jvectormap'                => ConfigHelper::pluginsUrl('jvectormap/jquery-jvectormap-1.2.2.css'),
        ],
        'js'    => [
            'jquery_214'                            => ConfigHelper::pluginsUrl('jQuery/jQuery-2.1.4.min.js'),
            'bootstrap'                             => ConfigHelper::jsUrl('bootstrap.min.js'),
            'icheck'                                => ConfigHelper::pluginsUrl('iCheck/icheck.min.js'),
            'moment'                                => ConfigHelper::pluginsUrl('moment/moment.js'),
            'slimscroll'                            => ConfigHelper::pluginsUrl('slimScroll/jquery.slimscroll.min.js'),
            'fastclick'                             => ConfigHelper::pluginsUrl('fastclick/fastclick.min.js'),
            'app'                                   => ConfigHelper::jsUrl('app.js'),
            'fileupload_jquery_ui_widget'           => ConfigHelper::pluginsUrl('fileupload/js/vendor/jquery.ui.widget.js'),
            'fileupload_jquery_iframe_transport'    => ConfigHelper::pluginsUrl('fileupload/js/jquery.iframe-transport.js'),
            'fileupload'                            => ConfigHelper::pluginsUrl('fileupload/js/jquery.fileupload.js'),
            'datatables'                            => ConfigHelper::pluginsUrl('datatables/jquery.dataTables.min.js'),
            'datatables_bootstrap'                  => ConfigHelper::pluginsUrl('datatables/dataTables.bootstrap.min.js'),
            'bootstrap_wysihtml5'                   => ConfigHelper::pluginsUrl('bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'),
            'messenger'                             => ConfigHelper::pluginsUrl('messenger/js/messenger.min.js'),
            'messenger_theme_future'                => ConfigHelper::pluginsUrl('messenger/js/messenger-theme-future.js'),
            'messenger_min'                         => ConfigHelper::pluginsUrl('messenger/js/messenger.min.js'),
            'messenger_theme_flat'                  => ConfigHelper::pluginsUrl('messenger/js/messenger-theme-flat.js'),
            'bootstrap_datetimepicker'              => ConfigHelper::pluginsUrl('datetimepicker/js/bootstrap-datetimepicker.min.js'),
            'cropit'                                => ConfigHelper::pluginsUrl('cropit/jquery.cropit.js'),
            'ionslider'                             => ConfigHelper::pluginsUrl('ionslider/ion.rangeSlider.min.js'),
            'bootstrap_slider'                      => ConfigHelper::pluginsUrl('bootstrap-slider/bootstrap-slider.js'),
            'app_custom'                            => ConfigHelper::jsUrl('app.custom.js'),
            'select2'                               => ConfigHelper::pluginsUrl('select2/select2.full.min.js'),
            'bootstrap_colorpicker'                 => ConfigHelper::pluginsUrl('colorpicker/bootstrap-colorpicker.min.js'),
            'daterangepicker'                       => ConfigHelper::pluginsUrl('daterangepicker/daterangepicker.js'),
            'chartjs'                               => ConfigHelper::pluginsUrl('chartjs/Chart.min.js'),
            'jquery_ui'                             => ConfigHelper::pluginsUrl('jQueryUI/jquery-ui.min.js'),
            'jvectormap'                            => ConfigHelper::pluginsUrl('jvectormap/jquery-jvectormap-1.2.2.min.js'),
            'jvectormap_world_mill_en'              => ConfigHelper::pluginsUrl('jvectormap/jquery-jvectormap-world-mill-en.js'),
        ],
        'image'     => [
            'avatar_dummy'                          => ConfigHelper::imgUrl('avatar04.png'),
            'logo_dummy'                            => ConfigHelper::imgUrl('laravel.png'),
        ]
    ]
];
