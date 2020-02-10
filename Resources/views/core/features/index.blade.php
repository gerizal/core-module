@extends('core::AdminLTE.app')

@section('htmlheader_title')
Feature
@endsection

@section('contentheader_title')
Feature
@endsection

@section('contentheader_description')
Feature
@endsection

@section('breadcrumb')
<li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Feature</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-8">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a class="btn btn-primary" href="{{ url('/feature/create') }}">
                        <i class="fa fa-plus-circle"></i> Create Feature
                    </a>
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <ul class="timeline" id="display_features"></ul>
            </div><!-- ./box-body -->
            <!-- Loading (remove the following to stop the loading)-->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <!-- end loading -->
        </div>
    </div>
    <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-plug"></i> Quick Start
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

                <form role="form" action="{{ route('feature.store') }}" method="post">
                    <input type="hidden" name="destination" value="index"/>
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('tag') ? ' has-error' : '' }}">
                            <label for="tag">Tag</label>
                            <input type="text" name="tag" value="{{ old('tag') }}" class="form-control" id="tag">
                            @if ($errors->has('tag'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tag') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Description</label>
                            <input type="text" name="description" value="{{ old('description') }}" class="form-control" id="description">
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                    </div>
                </form>
            </div><!-- ./box-body -->
        </div>
    </div>
</div><!-- /.row -->
@endsection

@section('javascript_per_page')
<script type="text/javascript">
    $(function(){
        /**
         * @function    Load user levels
         * @type        GET
         */
        try {
            $.ajax({
                url: '{{ url('/feature/display') }}',
                type: 'GET',
                dataType: 'HTML',
                beforeSend: function () {
                },
                success: function (response) {
                    $('#display_features').html(response);
                },
                complete: function () {
                    $('.overlay').hide();
                },
                error: function (a, b, c) {
                    showTemporaryMessage(c, 'error', 50);
                }
            });
        } catch (err) {
            showTemporaryMessage(err.message, 'error', 50);
        }

        /**
         * @function    Load more user levels
         * @type        GET
         */
        $(document).on('click', '#loadmore_feature', function (e) {
            e.preventDefault();

            var el = $(this);
            var s = el.data('s');

            try {
                $.ajax({
                    url: '{{ url('/feature/display') }}'+'/'+s,
                    type: 'GET',
                    dataType: 'HTML',
                    beforeSend: function () {
                        el.prop('disabled', true);
                        el.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
                    },
                    success: function (response) {
                        var cl = el.closest('li');
                        cl.hide('slow');
                        cl.next().hide('slow');
                        $('#display_features').append(response);
                    },
                    complete: function () {
                        el.prop('disabled', false);
                    },
                    error: function (a, b, c) {
                        showTemporaryMessage(c, 'error', 5);
                        return false;
                    }
                });
            } catch (err) {
                showTemporaryMessage(err.message, 'error', 5);
            }
        });

        /**
         * @function    Trash feature
         * @type        POST
         */
        $(document).on('click', '.trash_feature', function (e) {
            e.preventDefault();

            var el = $(this);
            var panel = el.data('panel');
            var name = el.data('name');
            var data = {'_method':'DELETE', '_token':'{{ csrf_token() }}'};
            var trashlink = $(this).data('trashlink');

            msgTrash = Messenger().post({
                message: 'Are you sure you want to trash feature '+name+'?',
                type: 'info',
                actions: {
                    deactivate: {
                        label: 'Trash',
                        action: function () {
                            try{
                                $.ajax({
                                    url : trashlink,
                                    type: 'POST',
                                    data: data,
                                    dataType: 'HTML',
                                    beforeSend: function () {
                                        el.prop('disabled', true);
                                        el.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
                                        showTemporaryMessage('Processing...', 'info', 50);
                                    },
                                    complete: function () {
                                      el.prop('disabled', false);
                                      el.html('<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="left" data-title="Trash"></i>');
                                    },
                                    success: function (response) {
                                        if (response == 'TRASHED') {
                                            $('.'+panel).hide('slow');
                                            showTemporaryMessage('Feature '+name+' was trashed.', 'success', 5);
                                        } else {
                                            showTemporaryMessage('The feature could not be trashed. Please try again.', 'error', 5);
                                            return false;
                                        }
                                    },
                                    error: function (a, b, c) {
                                        showTemporaryMessage(c, 'error', 5);
                                        return false;
                                    }
                                });
                            } catch (err) {
                                showTemporaryMessage(err.message, 'error', 5);
                            }
                        }
                    },
                    cancel: {
                        action: function () {
                            msgTrash.hide();
                        }
                    }
                }
            });
            return false;
        });
    });
</script>
@endsection
