@extends('layouts.master')

@section('content')
<section>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Admin</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('admin.list-branches.index') }}">List Branches</a>
            </li>
        </ol>
    </nav>
    <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="">Category</label>
                            <select class="form-select" name="category" id="category" required>
                                <option value="" hidden selected>-- Select Category --</option>
                                <option value="">None</option>
                                <option value="Branch Office">Branch Office</option>
                                <option value="Representative Office">Representative Office</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Domicile</label>
                            <input class="form-control" name="domicile" id="domicile" />
                        </div>
                        <div class="mb-3">
                            <label for="">Address</label>
                            <textarea class="form-control" name="address" id="address" cols="30" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Latitude</label>
                                    <input type="text" class="form-control" required id="lat" name="lat">
                                </div>
                                <div class="col-6">
                                    <label for="">Longitude</label>
                                    <input type="text" class="form-control" required id="long" name="long">
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label for="">Telephone</label>
                                    <input class="form-control" type="text" name="telp" id="telp">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="">Faximile</label>
                                    <input class="form-control" type="text" name="fax" id="fax">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="">Email</label>
                                    <input class="form-control" type="text" name="email" id="email">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="savedata" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header bg-primary mb-3 text-white">List Branches</h5>
        <div class="card-body">
            <div class="d-flex mb-3 justify-content-end">
                <button id="addListBranches" class="btn btn-primary"><i class="fas fa-plus"></i> Add Branches</button>
            </div>
            <div class="table-responsive">
                <table id="datatable" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 100px">Category</th>
                            <th>Domicile</th>
                            <th>Address</th>
                            <th style="width: 200px">Contact</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('#datatable').DataTable({
            responsive:true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.list-branches.getListBranches') }}",

            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'category', name: 'category'},
                { data: 'domicile', name: 'domicile'},
                { data: 'address', name: 'address'},
                { data: 'contact', name: 'contact'},
                { data: 'action', name: 'action'},
            ]
        })

        $('#addListBranches').click(function () {
            $('#savedata').data("action", "create-faq"); 
            $('#id').val('');
            $('#form').trigger("reset");
            $('#modal-title').html("Add Branches");
            $('#modal').modal('show');
        });

        $(document).on('click', '.edit-list-branches', function () {
            var id = $(this).data('id');
            
            var url = "{{ route('admin.list-branches.edit',':id') }}".replace(':id',id);
            $.get(url, function (data) {
                $('#modal').modal('show');
                $('#modal-title').html("Edit Branches");
                $('#savedata').html('Save'); 
                $('#id').val(data.id);
                $('#category').val(data.category);
                $('#domicile').val(data.domicile);
                $('#address').val(data.address);
                $('#telp').val(data.telp);
                $('#fax').val(data.fax);
                $('#email').val(data.email);
                $('#lat').val(data.lat);
                $('#long').val(data.long);
            })
        });

        $('#savedata').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
            data: $('#form').serialize(),
            url: "{{ route('admin.list-branches.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#form').trigger("reset");
                $('#savedata').html("Save");
                $('#modal').modal('hide');
                Swal.fire({
                    title: "Success!",
                    text: data.success,
                    icon: "success"
                });
                table.draw();
                $('.invalid-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');

            },
            error: function (xhr, status, error) {
                console.log(xhr.responseJSON);
                $('#savedata').html('Save');

                // Tanggapi pesan kesalahan dari respons JSON
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $('.invalid-feedback').remove();
                        $('.is-invalid').removeClass('is-invalid');

                        // Tambahkan pesan kesalahan baru
                        $.each(errors, function (key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).after('<div class="invalid-feedback">' + value + '</div>');
                        });
                    }
                }
            })
        });

        $('body').on('click', '.delete-list-branches', function () {
            var id = $(this).data("id");
            console.log(id)
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    var urlDelete = "{{ route('admin.list-branches.delete',':id') }}".replace(':id',id)
                    $.ajax({
                        type: "DELETE",
                        url: urlDelete,
                        success: function (data) {
                            Swal.fire({
                                title: "Deleted!",
                                text: data.success,
                                icon: "success"
                            });
                            table.draw();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
        });
</script>
@endsection