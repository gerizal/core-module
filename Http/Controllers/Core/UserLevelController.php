<?php

namespace Modules\Core\Http\Controllers\Core;

use Illuminate\Http\Request;

use Modules\Core\UserLevel;
use Modules\Core\Feature;
use Nwidart\Modules\Routing\Controller;

class UserLevelController extends Controller
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
        $features = Feature::all();
        return view('core::core.userlevel.index', compact('features'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        $features               = Feature::all();
        $lastrecentuserlevels   = UserLevel::orderBy('updated_at', '=', 'DESC')->take(3)->get();
        return view('core::core.userlevel.create', compact('lastrecentuserlevels', 'features'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'slug' => 'required|unique:cwa_user_levels'
        ]);

        $keys       = $request->keys;
        $values     = $request->values;
        $features   = [];

        if (!empty($keys)) {
            foreach ($keys as $k => $key) {
                $features[$key]     = true;
                $valueTemp          = trim($values[$k]);
                if (isset($valueTemp) && !empty($valueTemp)) {
                    $features[$key] = $valueTemp;
                }
            }
        }

        $userlevel              = new UserLevel;
        $userlevel->name        = $request->name;
        $userlevel->slug        = $request->slug;
        $userlevel->redirect    = $request->redirect;
        $userlevel->features    = json_encode($features);
        $userlevel->time_limit  = $request->time_limit;
        $userlevel->save();

        $redir      = 'user_level';

        if ($request->destination == 'create') {
            $redir  = 'user_level/' . $request->destination;
        }

        return redirect($redir)->with(
            'message',
            sprintf(
                'User level <a href="%s">%s</a> was created.',
                url('user_level', $userlevel->uniqueid()),
                $userlevel->name
            )
        );
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show(UserLevel $userlevel)
    {
        $features = Feature::all();
        return view('core::core.userlevel.show', compact('userlevel', 'features'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit(UserLevel $userlevel)
    {
        $features = Feature::all();
        return view('core::core.userlevel.edit', compact('userlevel', 'features'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request, $userlevel)
    {
        $slugValidation     = '';
        if ($userlevel->slug !== $request->slug) {
            $slugValidation = '|unique:cwa_user_levels';
        }
        
        $this->validate($request, [
            'name'  => 'required|max:100',
            'slug'  => 'required'.$slugValidation
        ]);

        $keys       = $request->keys;
        $values     = $request->values;
        $features   = [];

        if (!empty($keys)) {
            foreach ($keys as $k => $key) {
                $features[$key]     = true;
                $valueTemp          = trim($values[$k]);
                if (isset($valueTemp) && !empty($valueTemp)) {
                    $features[$key] = $valueTemp;
                }
            }
        }

        $userlevel->name        = $request->name;
        $userlevel->slug        = $request->slug;
        $userlevel->redirect    = $request->redirect;
        $userlevel->features    = json_encode($features);
        $userlevel->time_limit  = $request->time_limit;
        $userlevel->update();

        return redirect()->route('user_level.edit', $userlevel->uniqueid())
            ->with(
                'message',
                sprintf(
                    'User level <a href="%s">%s</a> was updated.',
                    url('user_level', $userlevel->uniqueid()),
                    $userlevel->name
                )
            );
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy(UserLevel $userlevel)
    {
        $userlevel->delete();
        return 'TRASHED';
    }

    public function display($s = 0)
    {
        $alluserlevels  = UserLevel::orderBy('updated_at', 'DESC')->skip($s)->take(3)->get();
        $s              = $s+3;
        $createlink     = url('/user_level/create');

        if ($alluserlevels->count() > 0) {
            foreach ($alluserlevels as $ulevel) {
                $date       = date('M j, Y', strtotime($ulevel->updated_at));
                $time       = date('h:i a', strtotime($ulevel->updated_at));
                $viewlink   = url('user_level', $ulevel->uniqueid());
                $editlink   = route('user_level.edit', $ulevel->uniqueid());
                $trashlink  = route('user_level.destroy', $ulevel->uniqueid());

                echo <<<NEWS
<li class="time-label ulevel_list_{$ulevel->uniqueid()}">
    <span class="bg-navy">
        {$date}
    </span>
</li>
<li class="ulevel_list_{$ulevel->uniqueid()}">
    <i class="fa fa-hand-o-up bg-blue"></i>
    <div class="timeline-item">
        <span class="time"><i class="fa fa-clock-o"></i> {$time}</span>
        <h3 class="timeline-header"><a href="{$viewlink}">{$ulevel->name}</a></h3>
        <div class="timeline-body">
            <ul class="nav nav-pills nav-stacked">
                <li><a href="#">Slug <span class="pull-right text-red">{$ulevel->slug}</span></a></li>
                <li><a href="#">Redirect <span class="pull-right text-red">{$ulevel->redirect}</span></a></li>
                <li><a href="#">Time limit <span class="pull-right text-red">{$ulevel->time_limit}</span></a></li>
            </ul>
        </div>
        <div class="timeline-footer">
            <button type="button" class="btn btn-danger btn-xs trash_userlevel"
                data-name="{$ulevel->name}"
                data-panel="ulevel_list_{$ulevel->uniqueid()}"
                data-trashlink="{$trashlink}">
                <i class="fa fa-trash-o" data-toggle="tooltip" data-placement="left" data-title="Trash"></i>
            </button>
            <a class="btn btn-default btn-xs" href="{$viewlink}">
                <i class="fa fa-eye" data-toggle="tooltip" data-placement="bottom" data-title="View"></i>
            </a>
            <a class="btn btn-primary btn-xs" href="{$editlink}">
                <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="right" data-title="Edit"></i>
            </a>
        </div>
    </div>
</li>
NEWS;
            }

            echo <<<NEWS
<li class="time-label">
    <button type="button" class="btn btn-success btn-sm"
        id="loadmore_user_level"
        data-s="{$s}"
        style="width:75px;">Load more
    </button>
</li>
<li>
    <i class="fa fa-clock-o bg-gray"></i>
</li>
NEWS;
        }

        if ($alluserlevels->count() == 0) {
            echo <<<NEWS
<ul class="timeline">
    <li class="time-label">
        <span class="bg-red">
            Not available
        </span>
    </li>
    <li>
        <i class="fa fa-hand-o-up bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> N/A</span>
            <h3 class="timeline-header">No user level available</h3>
            <div class="timeline-body">
                <a href="{$createlink}" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> Create User Level</a>
            </div>
        </div>
    </li>
    <li>
        <i class="fa fa-clock-o bg-gray"></i>
    </li>
</ul>
NEWS;
        }
    }
}
