@extends('core::AdminLTE.app')

@section('htmlheader_title')
Appearance
@endsection

@section('contentheader_title')
Appearance
@endsection

@section('contentheader_description')
Appearance
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-gears"></i> Appearance</a></li>
<li class="active">Set</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-laptop"></i> Appearance
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if (count($errors) > 0)
                    <div class="box-body">
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (session('message'))
                    <div class="box-body">
                        <div class="alert alert-success alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                            {!! session('message') !!}
                        </div>
                    </div>
                @endif

                <form role="form" method="POST"
                    action="{{ route('appearance.update', $appearance->uniqueid()) }}">
                    {!! csrf_field() !!}
                    <input name="_method" value="PATCH" type="hidden">

                    <div class="box-body">
                        <div class="form-group">
                            <label for="override_main_header">Override main header</label>
                            <select name="override_main_header" id="override_main_header" class="form-control">
                                <option value="0" {{ (!$appearance->override_main_header) ? 'selected="selected"' : '' }}>No</option>
                                <option value="1" {{ ($appearance->override_main_header) ? 'selected="selected"' : '' }}>Yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="skin">Skin</label>
                            <select name="skin" id="skin" class="form-control">
                                <option value="skin-blue"
                                    {{ ($appearance->skin == 'skin-blue') ? 'selected="selected"' : '' }}>Blue
                                </option>
                                <option value="skin-black"
                                    {{ ($appearance->skin == 'skin-black') ? 'selected="selected"' : '' }}>Black
                                </option>
                                <option value="skin-purple"
                                    {{ ($appearance->skin == 'skin-purple') ? 'selected="selected"' : '' }}>Purple
                                </option>
                                <option value="skin-yellow"
                                    {{ ($appearance->skin == 'skin-yellow') ? 'selected="selected"' : '' }}>Yellow
                                </option>
                                <option value="skin-red"
                                    {{ ($appearance->skin == 'skin-red') ? 'selected="selected"' : '' }}>Red
                                </option>
                                <option value="skin-green"
                                    {{ ($appearance->skin == 'skin-green') ? 'selected="selected"' : '' }}>Green
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="messenger_theme">Messenger theme</label>
                            <select name="messenger_theme" id="messenger_theme" class="form-control">
                                <option value="flat"
                                    {{ ($appearance->messenger_theme == 'flat') ? 'selected="selected"' : '' }}>Flat
                                </option>
                                <option value="future"
                                    {{ ($appearance->messenger_theme == 'future') ? 'selected="selected"' : '' }}>Future
                                </option>
                                <option value="block"
                                    {{ ($appearance->messenger_theme == 'block') ? 'selected="selected"' : '' }}>Block
                                </option>
                                <option value="air"
                                    {{ ($appearance->messenger_theme == 'air') ? 'selected="selected"' : '' }}>Air
                                </option>
                                <option value="ice"
                                    {{ ($appearance->messenger_theme == 'ice') ? 'selected="selected"' : '' }}>Ice
                                </option>
                            </select>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-floppy-o"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal_per_page')
@endsection

@section('javascript_per_page')
<script type="text/javascript">
    $(function(){

    });
</script>
@endsection
