@extends('core::AdminLTE.app')

@section('htmlheader_title')
User Levels
@endsection

@section('contentheader_title')
User Levels
@endsection

@section('contentheader_description')
User levels
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-hand-o-up"></i> User Levels</a></li>
<li class="active">List</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-8">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a class="btn btn-primary" href="{{ url('/user_level/create') }}">
                        <i class="fa fa-plus-circle"></i> Create User Level
                    </a>
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <ul class="timeline" id="display_user_levels"></ul>
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
                    <i class="fa fa-hand-o-up"></i> Quick Start
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

                <form role="form" method="POST" action="{{ route('user_level.store') }}">
                    <input type="hidden" name="destination" value="index"/>
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}" />
                        </div>
                        <div class="form-group">
                            <label for="name">Slug</label>
                            <input class="form-control" id="slug" name="slug" type="text" value="{{ old('slug') }}" />
                        </div>
                        <div class="form-group">
                            <label for="name">Redirect</label>
                            <input class="form-control" id="redirect" name="redirect" type="text" value="{{ old('redirect') }}" />
                        </div>
                        <div class="form-group">
                            <label for="name">Features</label>
                            <table class="table table-striped table-hover">
                                <?php $i = 0; ?>
                                @foreach($features as $feature)
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
                                    <?php $i++; ?>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="name">Time limit</label>
                            <input class="form-control" id="time_limit" name="time_limit" type="number" min="0" value="{{ old('time_limit') }}" />
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

@section('javascript_per_page')
<script type="text/javascript">
    $(function(){
        /**
         * @function    Load user levels
         * @type        GET
         */
        try {
            $.ajax({
                url: '{{ url('/user_level/display') }}',
                type: 'GET',
                dataType: 'HTML',
                beforeSend: function () {
                },
                success: function (response) {
                    $('#display_user_levels').html(response);
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
        $(document).on('click', '#loadmore_user_level', function (e) {
            e.preventDefault();

            var el = $(this);
            var s = el.data('s');

            try{
                $.ajax({
                    url: '{{ url('/user_level/display') }}'+'/'+s,
                    type: 'GET',
                    dataType: 'HTML',
                    beforeSend: function () {
                        el.prop('disabled', true);
                        el.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
                    },
                    success: function(response){
                        var cl = el.closest('li');
                        cl.hide('slow');
                        cl.next().hide('slow');
                        $('#display_user_levels').append(response);
                    },
                    complete: function(){
                        el.prop('disabled', false);
                    },
                    error: function(a, b, c){
                        showTemporaryMessage(c, 'error', 5);
                        return false;
                    }
                });
            } catch (err) {
                showTemporaryMessage(err.message, 'error', 5);
            }
        });

        /**
         * @function    Trash user level
         * @type        POST
         */
        $(document).on('click', '.trash_userlevel', function (e) {
            e.preventDefault();

            var el = $(this);
            var panel = el.data('panel');
            var name = el.data('name');
            var data = {'_method':'DELETE', '_token':'{{ csrf_token() }}'};
            var trashlink = $(this).data('trashlink');

            msgTrash = Messenger().post({
                message: 'Are you sure you want to trash user level '+name+'?',
                type: 'info',
                actions: {
                    deactivate: {
                        label: 'Trash',
                        action: function () {
                            try {
                                $.ajax({
                                    url : trashlink,
                                    type: 'POST',
                                    data: data,
                                    dataType: 'HTML',
                                    beforeSend: function(){
                                        el.prop('disabled', true);
                                        el.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
                                        showTemporaryMessage('Processing...', 'info', 50);
                                    },
                                    complete: function(){
                                        el.prop('disabled', false);
                                        el.html('<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="left" data-title="Trash"></i>');
                                    },
                                    success: function(response){
                                        if (response == 'TRASHED') {
                                            $('.'+panel).hide('slow');
                                            showTemporaryMessage('User level '+name+' was trashed.', 'success', 5);
                                        } else {
                                            showTemporaryMessage('The user level could not be trashed. Please try again.', 'error', 5);
                                            return false;
                                        }
                                    },
                                    error: function(a, b, c){
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
