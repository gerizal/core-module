<?php

namespace Modules\Core\Http\Controllers\Core;

use Illuminate\Http\Request;
use Nwidart\Modules\Routing\Controller;
use Modules\Core\User;
use Auth;

class MaintenanceController extends Controller
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
        return view('core::core.maintenance.index');
    }
}
