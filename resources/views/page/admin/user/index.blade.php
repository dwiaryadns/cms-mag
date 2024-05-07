@extends('layouts.master')

@section('content')
<section>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Admin</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('admin.user.index') }}">User</a>
            </li>
        </ol>
    </nav>
    <!-- Modal -->
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
                            <label for="">Name</label>
                            <input class="form-control" name="name" id="name" placeholder="Enter Name" />

                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input class="form-control" name="email" id="email" placeholder="Enter Email" />
                        </div>
                        <div class="mb-3">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter Password" />
                        </div>
                        <div class="mb-3">
                            <label for="">Role</label>
                            <select name="role" id="form-role" class="form-select">
                                <option value="admin">Admin</option>
                                <option value="marketing">Marketing</option>
                                <option value="user">User</option>
                            </select>
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
        <h5 class="card-header bg-primary mb-3 text-white">User</h5>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div class="">
                    <select name="role" id="role" class="form-select">
                        <option value="">-- Filter By Role --</option>
                        <option value="admin">Admin</option>
                        <option value="marketing">Marketing</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="justify-content-end">
                    <button id="addUser" class="btn btn-primary"><i class="fas fa-plus"></i> Add User</button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="datatable" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
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
            ajax: {
                url: "{{ route('admin.user.getUser') }}",
                data: function (d) {
                        d.role = $('#role').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },

            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name'},
                { data: 'email', name: 'email'},
                { data: 'role', name: 'role', orderable: true, searchable: true },
                { data: 'action', name: 'action'},
            ]
        })
        $('#role').change(function(){
            table.draw();
        });
            $('#addUser').click(function () {
            $('#savedata').data("action", "create-user"); 
            $('#id').val('');
            $('#form').trigger("reset");
            $('#modal-title').html("Add User");
            $('#modal').modal('show');
        });

        $(document).on('click', '.edit-user', function () {
            var id = $(this).data('id');
            
            var url = "{{ route('admin.user.edit',':id') }}".replace(':id',id);
            $.get(url, function (data) {
                $('#modal').modal('show');
                $('#modal-title').html("Edit User");
                $('#savedata').html('Save'); 
                $('#id').val(data.id);
                $('#category').val(data.category);
                $('#question').val(data.question);
                $('#answer').val(data.answer);
            })
        });

        $('#savedata').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
            data: $('#form').serialize(),
            url: "{{ route('admin.user.store') }}",
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
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseJSON);
                $('#savedata').html('Save');

                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $('.invalid-feedback').remove();
                        $('.is-invalid').removeClass('is-invalid');

                        $.each(errors, function (key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).after('<div class="invalid-feedback">' + value + '</div>');
                        });
                    }
                }
            })
        });

        $('body').on('click', '.delete-user', function () {
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
                    var urlDelete = "{{ route('admin.user.delete',':id') }}".replace(':id',id)
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