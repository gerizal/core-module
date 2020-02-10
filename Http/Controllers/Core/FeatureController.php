<?php

namespace Modules\Core\Http\Controllers\Core;

use Illuminate\Http\Request;

use Nwidart\Modules\Routing\Controller;
use Modules\Core\Feature;

class FeatureController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = Feature::all();
        return view('core::core.features.index', [
            'features' => $features,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lastrecentfeatures = Feature::orderBy('updated_at', '=', 'DESC')->take(3)->get();
        return view('core::core.features.create', compact('lastrecentfeatures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tag'           => 'required|unique:cwa_features',
            'description'   => '',
        ]);

        $feature                = new Feature;
        $feature->tag           = strtoupper($request->tag);
        $feature->description   = $request->description;
        $feature->created_at    = date('Y-m-d H:i:s');
        $feature->updated_at    = date('Y-m-d H:i:s');
        $feature->save();

        $redir      = 'feature';
        if ($request->destination == 'create') {
            $redir  = 'feature/' . $request->destination;
        }

        return redirect($redir)->with('message', 'Feature with tag <b>' . $feature->tag . '</b> was created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        return view('core::core.features.show', compact('feature'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        return view('core::core.features.edit', [
            'feature' => $feature,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feature $feature)
    {
        if ($request->tag != $feature->tag) {
            $this->validate($request, [
                'tag'           => 'required|unique:cwa_features',
                'description'   => '',
            ]);
        }

        $feature->tag           = strtoupper($request->tag);
        $feature->description   = $request->description;
        $feature->updated_at    = date('Y-m-d H:i:s');
        $feature->save();

        return redirect()->route('feature.edit', $feature->uniqueid())
            ->with('message', 'Feature with tag <b>'.$feature->tag.'</b> was edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        $feature->delete();
        return 'TRASHED';
    }

    public function display($s = 0)
    {
        $allfeatures    = Feature::orderBy('updated_at', 'DESC')->skip($s)->take(3)->get();
        $s              = $s+3;
        $createlink     = url('/feature/create');

        if ($allfeatures->count() > 0) {
            foreach ($allfeatures as $feature) {
                $date       = date('M j, Y', strtotime($feature->updated_at));
                $time       = date('h:i a', strtotime($feature->updated_at));
                $viewlink   = url('feature', $feature->uniqueid());
                $editlink   = route('feature.edit', $feature->uniqueid());
                $trashlink  = route('feature.destroy', $feature->uniqueid());

                echo <<<NEWS
<li class="time-label feature_list_{$feature->uniqueid()}">
    <span class="bg-navy">
        {$date}
    </span>
</li>
<li class="feature_list_{$feature->uniqueid()}">
    <i class="fa fa-plug bg-blue"></i>
    <div class="timeline-item">
        <span class="time"><i class="fa fa-clock-o"></i> {$time}</span>
        <h3 class="timeline-header"><a href="{$viewlink}">{$feature->tag}</a></h3>
        <div class="timeline-body"></div>
        <div class="timeline-footer">
            <button type="button" class="btn btn-danger btn-xs trash_feature"
                data-name="{$feature->tag}"
                data-panel="feature_list_{$feature->uniqueid()}"
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
        id="loadmore_feature"
        data-s="{$s}"
        style="width:75px;">Load more
    </button>
</li>
<li>
    <i class="fa fa-clock-o bg-gray"></i>
</li>
NEWS;
        }

        if ($allfeatures->count() == 0) {
            echo <<<NEWS
<ul class="timeline">
    <li class="time-label">
        <span class="bg-red">
            Not available
        </span>
    </li>
    <li>
        <i class="fa fa-plug bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> N/A</span>
            <h3 class="timeline-header">No feature available</h3>
            <div class="timeline-body">
                <a href="{$createlink}" class="btn btn-primary btn-xs">
                    <i class="fa fa-plus-circle"></i> Create Feature
                </a>
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
