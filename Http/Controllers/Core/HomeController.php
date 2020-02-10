<?php

namespace Modules\Core\Http\Controllers\Core;

use Illuminate\Http\Request;
use Nwidart\Modules\Routing\Controller;

use View;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        if (View::exists('cwaextends.home')) {
            return view('cwaextends.home');
        }

        return view('core::AdminLTE.home');
    }
}
