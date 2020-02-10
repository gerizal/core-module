<?php

namespace Modules\Core\Http\Controllers\Core;

use Illuminate\Http\Request;
use Nwidart\Modules\Routing\Controller;

use Modules\Core\Helpers\AppearanceHelper;

class AppearanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
        $this->middleware('administrator');
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $appearance = AppearanceHelper::appearance();
        return view('core::core.appearance.index', compact('appearance'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request, $appearance)
    {
        $this->validate($request, [
            'override_main_header' => 'required|integer'
            ]);

        $appearance->override_main_header   = $request->override_main_header;
        $appearance->skin                   = $request->skin;
        $appearance->messenger_theme        = $request->messenger_theme;
        $appearance->update();
        
        return redirect('appearance')->with('message', 'Your appearance was updated.');
    }
}
