<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">
    <title> Codeigniter 4 | CRUD Datatables Server Side</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="container">
        <h1>CRUD Datatables Server Side Codeigniter 4</h1>
        <hr>
        <button class="btn btn-success btn-sm" onclick="add_record()"><i class="fa fa-plus-circle"></i>&nbsp;Add Record</button>
        <a href="<?php echo base_url('pegawai'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i>&nbsp;Refresh</a>
        <hr>
        <div class="col-md-12">
            <div id="message"></div>
        </div>
        <table id="mytable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th width="60">Action</th>
                    <th width="1%">No</th>
                    <th>NIP</th>
                    <th>Nama Pegawai</th>
                    <th>Alamat</th>
                </tr>
            </thead>
        </table>
    </div>
</body>
</html>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    let url;
    let status = 'add';
    $(document).ready(function() {
        show_record();
    });

    function show_record() {
        $('#mytable').DataTable({
            processing: true,
            serverSide: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'
            },
            bDestroy: true,
            responsive: true,
            order: [],
            ajax: {
                url: "<?php echo base_url('pegawai/ajax_list'); ?>",
                type: "POST",
                data: {},
            },
            columnDefs: [{
                    targets: [0, 1],
                    orderable: false,
                },
                {
                    width: "1%",
                    targets: [1, -1],
                },
                {
                    className: "dt-nowrap",
                    targets: [-1],
                }
            ],

        });
    }

    function clear_error_message() {
        $('#nip-error').html('');
        $('#nama_pegawai-error').html('');
        $('#alamat-error').html('');
    }

    function add_record() {
        status = 'add';
        clear_error_message();
        $('#ajaxModal').modal('show');
        $('#form-pegawai')[0].reset();
    }

    function view_record(pegawai_id) {
        status = 'edit';
        $('#viewModal').modal('show');
        $.ajax({
            url: "<?php echo base_url('pegawai/show'); ?>"+ '/' + pegawai_id,
            type: 'GET',
            dataType: 'JSON',
            success: function(res) {
                if (res.success == true) {
                    $('#v_nip').html(res.data.nip);
                    $('#v_nama_pegawai').text(res.data.nama_pegawai);
                    $('#v_alamat').html(res.data.alamat);
                }
            }
        });
    }

    function edit_record(pegawai_id) {
        status = 'edit';
        clear_error_message();
        $('#ajaxModal').modal('show');
        $('#pegawai_id').val(pegawai_id);
        $.ajax({
            url: "<?php echo base_url('pegawai/edit'); ?>",
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-pegawai').serialize(),
            success: function(res) {
                if (res.success == true) {
                    $('#nip').val(res.data.nip);
                    $('#nama_pegawai').val(res.data.nama_pegawai);
                    $('#alamat').val(res.data.alamat);
                }
            }
        });
    }

    function delete_record(pegawai_id) {
        status = 'delete';
        $('#deleteModal').modal('show');
        $('#pegawai_id').val(pegawai_id);
        $.ajax({
            url: "<?php echo base_url('pegawai/show'); ?>"+ '/' + pegawai_id,
            type: 'GET',
            dataType: 'JSON',
            //data: $('#form-pegawai').serialize(),
            success: function(res) {
                if (res.success == true) {
                    $('#d_nip').html(res.data.nip);
                    $('#d_nama_pegawai').text(res.data.nama_pegawai);
                    $('#d_alamat').html(res.data.alamat);
                }
            }
        });
    }

    function proses() {
        if (status == 'add') {
            url = "<?php echo base_url('pegawai/store'); ?>";
        } else if (status == 'edit') {
            url = "<?php echo base_url('pegawai/update'); ?>";
        } else if (status == 'delete') {
            url = "<?php echo base_url('pegawai/destroy'); ?>";
        }
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-pegawai').serialize(),
            success: function(res) {
                //console.log(res);
                if(res.errors) {
                    if(res.errors.nip){
                        $('#nip-error').html(res.errors.nip);
                    }
                    if(res.errors.nama_pegawai){
                        $('#nama_pegawai-error').html(res.errors.nama_pegawai);
                    }
                    if(res.errors.alamat){
                        $('#alamat-error').html(res.errors.alamat);
                    }
                }
                if (res.success == true) {
                    $('#message').removeClass('hide'); 
                    $('#message').html('<div class="alert alert-success alert-dismissible">\n\
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\n\
                        <h5><i class="icon fa fa-info-circle"></i> <b>Success!</b> '+ res.message +'</h5></div>'
                    );
                    if (status == 'add') {
                        $('#ajaxModal').modal('hide');
                    } else if (status == 'edit') {
                        $('#ajaxModal').modal('hide');
                    } else if (status == 'delete') {
                        $('#deleteModal').modal('hide');
                    }
                    show_record();
                }
            }
        });
    }
</script>

<!--Add/ Update Modal-->
<div class="modal fade" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">Add/ Update Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-pegawai">
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="hidden" name="pegawai_id" id="pegawai_id">
                        <input type="text" class="form-control" id="nip" name="nip" required="true">
                        <span><i class="text-danger" id="nip-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="nama_pegawai">Nama Pegawai</label>
                        <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai">
                        <span><i class="text-danger" id="nama_pegawai-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat">
                        <span><i class="text-danger" id="alamat-error"></i></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-arrow-circle-left "></i>&nbsp;Close</button>
                <button type="button" class="btn btn-primary" onclick="proses()"><i class="fa fa-plus-circle"></i>&nbsp;Save Record</button>
            </div>
        </div>
    </div>
</div>
<!-- !. Add/ Update Modal-->

<!--View Record Modal-->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">View Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" 
                        cellspacing="0" width="100%"
                        style="font-style: Calibri;font-size:14px;
                            border: 1px solid #ccc;" >
                    <tr style="background: #eee;color: #4c4a4a;">
                        <th width="130">NIP</th>
                        <td id="v_nip"></td>
                    </tr>
                    <tr style="background: #fff;color: #4c4a4a;">
                        <th>Nama Pegawai</th>
                        <td id="v_nama_pegawai"></td>
                    </tr>
                    <tr style="background: #eee;color: #4c4a4a;">
                        <th>Alamat</th>
                        <td id="v_alamat"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-arrow-circle-left "></i>&nbsp;Close</button>
            </div>
        </div>
    </div>
</div>
<!-- !. View Record Modal-->

<!--Delete Record Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">Delete Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-pegawai">
                    <input type="hidden" name="pegawai_id" id="pegawai_id">
                </form>
                <table class="table table-bordered" 
                        cellspacing="0" width="100%"
                        style="font-style: Calibri;font-size:14px;
                            border: 1px solid #ccc;" >
                    <tr style="background: #eee;color: #4c4a4a;">
                        <th width="130">NIP</th>
                        <td id="d_nip"></td>
                    </tr>
                    <tr style="background: #fff;color: #4c4a4a;">
                        <th>Nama Pegawai</th>
                        <td id="d_nama_pegawai"></td>
                    </tr>
                    <tr style="background: #eee;color: #4c4a4a;">
                        <th>Alamat</th>
                        <td id="d_alamat"></td>
                    </tr>
                </table>
                <h5 align="right">Are you sure want to delete this record?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-arrow-circle-left "></i>&nbsp;Close</button>
                <button type="button" class="btn btn-danger" onclick="proses()"><i class="fa fa-trash"></i>&nbsp;Delete Record</button>
            </div>
        </div>
    </div>
</div>
<!-- !. Delete Record Modal-->


