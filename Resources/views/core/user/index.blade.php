@extends('core::AdminLTE.app')

@section('htmlheader_title')
Users
@endsection

@section('contentheader_title')
Users
@endsection

@section('contentheader_description')
Your awesome users
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-users"></i> Users</a></li>
<li class="active">List</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a class="btn btn-primary" href="{{ url('user/create') }}">
                        <i class="fa fa-plus-circle"></i> Create User
                    </a>
                </h3>
                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-striped" id="users_datatable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Level</th>
                            <th>Is Active</th>
                            <th>Last Logged In</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Level</th>
                            <th>Is Active</th>
                            <th>Last Logged In</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- ./box-body -->
        </div>
    </div>
</div>
@endsection

@section('modal_per_page')
<div class="modal fade" id="resetPasswordModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input class="form-control" type="text" readonly="readonly"
                        id="new_password" onclick="this.focus()" style="text-align:center;" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('javascript_per_page')
<script type="text/javascript">
    $(function(){
        /**
         * @function      Load users
         * @type          GET
         */
        try {
            $('#users_datatable')
            .dataTable({
                "ajax": "{{ url('user/display') }}",
                "processing": true,
                "serverSide": true,
                "aoColumns" : [
                    {},
                    {},
                    {bSortable:false},
                    {bSortable:false, sClass:"datatable_align_center user_status"},
                    {bSortable:false, sClass:"datatable_align_center"},
                    {bSortable:false, sClass:"datatable_align_center"}
                ]
            });
        } catch (err) {
            showTemporaryMessage('Could not load data, please try to refresh the page.', 'error', 5);
        }

        /**
         * @function      Activate user
         * @type          POST
         */
        $(document).on('click', '.admin_activate', function (e) {
            e.preventDefault();

            var el = $(this);
            var email = el.data('email');
            var data = {'_method':'POST', 'uid': el.data('uid'),'_token':'{{ csrf_token() }}'};
            var targetUrl = el.data('targetlink');

            msgActivate = Messenger().post({
                message: 'Are you sure you want to activate user '+email+'?',
                type: 'info',
                actions: {
                    deactivate: {
                        label: 'Activate',
                        action: function () {
                            try {
                                $.ajax({
                                    url : targetUrl,
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
                                        el.removeClass('btn-warning').addClass('btn-success');
                                        var title = el.attr('data-original-title').replace("Activate", "Deactivate");
                                        el.attr('data-original-title', title);
                                        el.removeClass('admin_activate').addClass('admin_deactivate');
                                        el.html('<i class="fa fa-toggle-on"></i>');
                                    },
                                    success: function (response) {
                                        if (response == 'ACTIVATED') {
                                            el.parent().parent().children('.user_status').html('<span class="label label-success">YES</span>');
                                            showTemporaryMessage('User '+email+' is activated.', 'success', 5);
                                        } else {
                                            showTemporaryMessage('The user could not be activated. Please try again.', 'error', 5);
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
                            msgActivate.hide();
                        }
                    }
                }
            });
            return false;
        });

        /**
         * @function      Deactivate user
         * @type          POST
         */
        $(document).on('click', '.admin_deactivate', function (e) {
            e.preventDefault();

            var el = $(this);
            var email = el.data('email');
            var data = {'_method':'POST', 'uid': el.data('uid'), '_token':'{{ csrf_token() }}'};
            var targetLink = el.data('targetlink');

            msgDeactivate = Messenger().post({
                message: 'Are you sure you want to deactivate user '+email+'?',
                type: 'info',
                actions: {
                    deactivate: {
                        label: 'Deactivate',
                        action: function () {
                            try {
                                $.ajax({
                                    url : targetLink,
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
                                        el.removeClass('btn-success').addClass('btn-warning');
                                        el.removeClass('admin_deactivate').addClass('admin_activate');
                                        var title = el.attr('data-original-title').replace("Deactivate", "Activate");
                                        el.attr('data-original-title', title);
                                        el.html('<i class="fa fa-toggle-on"></i>');
                                    },
                                    success: function(response){
                                        if (response == 'DEACTIVATED') {
                                            el.parent().parent().children('.user_status').html('<span class="label label-danger">NO</span>');
                                            showTemporaryMessage('User '+email+' was deactivated.', 'success', 5);
                                        } else {
                                            showTemporaryMessage('The user could not be deactivated. Please try again.', 'error', 5);
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
                            msgDeactivate.hide();
                        }
                    }
                }
            });
            return false;
        });

        /**
         * @function      Reset user password
         * @type          POST
         */
        $(document).on('click', '.admin_resetpassword', function (e) {
            e.preventDefault();

            var el = $(this);
            var email = el.data('email');
            var data = {'_method':'POST', '_token':'{{ csrf_token() }}'};
            var resetpasswordlink = el.data('resetpasswordlink');

            msgResetPassword = Messenger().post({
                message: 'Are you sure you want to reset user '+email+' password?',
                type: 'info',
                actions: {
                    deactivate: {
                        label: 'Reset Password',
                        action: function () {
                            try {
                                $.ajax({
                                    url : resetpasswordlink,
                                    type: 'POST',
                                    data: data,
                                    dataType: 'JSON',
                                    beforeSend: function () {
                                        el.prop('disabled', true);
                                        el.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
                                        showTemporaryMessage('Processing...', 'info', 50);
                                    },
                                    complete: function () {
                                        el.prop('disabled', false);
                                        el.html('<i class="fa fa-key"></i>');
                                    },
                                    success: function (response) {
                                        if (response.resCode == 'success') {
                                            hideAllMessage();
                                            $('#resetPasswordModal .modal-title').html('New password for user ' + email);
                                            $('#resetPasswordModal #new_password').val(response.resMessage);
                                            $('#resetPasswordModal').modal('show');
                                        } else {
                                            showTemporaryMessage('Could not reset user password. Message : '+response.resMessage, 'error', 5);
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
                            msgResetPassword.hide();
                        }
                    }
                }
            });
            return false;
        });

        /**
         * @function      Trash user
         * @type          POST
         */
        $(document).on('click', '.admin_trashuser', function (e) {
            e.preventDefault();

            var el = $(this);
            var email = el.data('email');
            var data = {'_method':'POST', '_token':'{{ csrf_token() }}'};
            var trashlink = el.data('trashlink');

            msgTrashUser = Messenger().post({
                message: 'Are you sure you want to trash user '+email+'?',
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
                                    dataType: 'JSON',
                                    beforeSend: function () {
                                        el.prop('disabled', true);
                                        el.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
                                        showTemporaryMessage('Processing...', 'info', 50);
                                    },
                                    complete: function () {
                                        el.prop('disabled', false);
                                        el.html('<i class="fa fa-trash"></i>');
                                    },
                                    success: function (response) {
                                        if (response.resCode == 'success') {
                                            hideAllMessage();
                                            el.parent().parent().hide('slow');
                                            showTemporaryMessage('User '+email+' was trashed.', 'success', 5);
                                        } else {
                                            showTemporaryMessage('Could not trash user. Message : '+response.resMessage, 'error', 5);
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
                            msgTrashUser.hide();
                        }
                    }
                }
            });
            return false;
        });
    });
  </script>
@endsection