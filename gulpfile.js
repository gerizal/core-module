var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

// Probably need to update the path when in production
//elixir.config.assetsDir = "./modules/Core/Resources/assets/AdminLTE/";
elixir.config.assetsDir = "./vendor/gerizal/core-module/Resources/assets/AdminLTE/";

//var output = 'modules/Core/Assets/AdminLTE/css';
var output = 'vendor/gerizal/core-module/Assets/AdminLTE/css';

elixir(function(mix) {
  mix.less('app.less', output);
  mix.less('admin-lte/AdminLTE.less', output);
  mix.less('bootstrap/bootstrap.less', output);
});
