@extends('core::AdminLTE.app')

@section('htmlheader_title')
Edit User Level
@endsection

@section('contentheader_title')
Edit User Level
@endsection

@section('contentheader_description')
{{ $userlevel->name }}
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-hand-o-up"></i> User Levels</a></li>
<li class="active">Edit</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a class="btn btn-default" href="{{ url('/user_level') }}">
                        <i class="fa fa-chevron-circle-left"></i> Back
                    </a>
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if (count($errors) > 0)
                    <div class="box-body">
                        <div class="alert alert-danger">
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
                        <div class="alert alert-success">
                            {!! session('message') !!}
                        </div>
                    </div>
                @endif

                <form role="form" method="POST" action="{{ route('user_level.update', $userlevel->uniqueid()) }}">
                    {!! csrf_field() !!}
                    <input name="_method" value="PATCH" type="hidden">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" id="name" name="name" type="text" value="{{ $userlevel->name }}" />
                        </div>
                        <div class="form-group">
                            <label for="name">Slug</label>
                            <input class="form-control" id="slug" name="slug" type="text" value="{{ $userlevel->slug }}" />
                        </div>
                        <div class="form-group">
                            <label for="name">Redirect</label>
                            <input class="form-control" id="redirect" name="redirect" type="text" value="{{ $userlevel->redirect }}" />
                        </div>
                        <div class="form-group">
                            <label for="name">Features</label>
                            <table class="table table-striped table-hover">
                                <?php $i = 0; ?>
                                @foreach($features as $feature)
                                    @if($userlevel->getFeatureAccess($feature->tag) != null)
                                        <tr>
                                            <td width="10px">
                                                <input type="checkbox" name="keys[{{ $i }}]" value="{{ $feature->tag }}"
                                                    id="feature_boxs-{{ $i }}" checked>
                                            </td>
                                        <td>
                                            <label for="feature_boxs-{{ $i }}">{{ $feature->tag }}</label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="values[{{ $i }}]"
                                                value="{{ $userlevel->getFeatureAccess($feature->tag) }}">
                                        </td>
                                        <?php $i++; ?>
                                        </tr>
                                    @else
                                    <tr>
                                        <td width="10px">
                                            <input type="checkbox" name="keys[{{ $i }}]" value="{{ $feature->tag }}" id="feature_boxs-{{ $i }}">
                                        </td>
                                        <td>
                                            <label for="feature_boxs-{{ $i }}">{{ $feature->tag }}</label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="values[{{ $i }}]" value="">
                                        </td>
                                        {{--*/ $i++ /*--}}
                                    </tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="name">Time limit</label>
                            <input class="form-control" id="time_limit" name="time_limit" type="number" min="0" value="{{ $userlevel->time_limit }}" />
                            <p class="text-muted">Number of days. Set to 0 for no limit.</p>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                    </div>
                </form>
            </div><!-- ./box-body -->
        </div>
    </div>
</div>
@endsection
