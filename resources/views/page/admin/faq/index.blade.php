@extends('layouts.master')

@section('content')
<section>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Admin</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('admin.faq.index') }}">FAQ</a>
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
                            <input class="form-control" name="category" id="category" placeholder="Enter Category" />

                        </div>
                        <div class="mb-3">
                            <label for="nameBasic" class="form-label">Question</label>
                            <textarea class="form-control" placeholder="Enter Question" name="question" id="question"
                                cols="30" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="emailBasic" class="form-label">Answer</label>
                            <textarea class="form-control" placeholder="Enter Answer" name="answer" id="answer"
                                cols="30" rows="5"></textarea>
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
        <h5 class="card-header bg-primary mb-3 text-white">FAQ</h5>
        <div class="card-body">
            <div class="d-flex mb-3 justify-content-end">
                <button id="addFaq" class="btn btn-primary"><i class="fas fa-plus"></i> Add FAQ</button>
            </div>
            <div class="table-responsive">
                <table id="datatable" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Question</th>
                            <th>Answer</th>
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
            ajax: "{{ route('admin.faq.getFaq') }}",

            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'category', name: 'category'},
                { data: 'question', name: 'question'},
                { data: 'answer', name: 'answer'},
                { data: 'action', name: 'action'},
            ]
        })

        $('#addFaq').click(function () {
            $('#savedata').data("action", "create-faq"); 
            $('#id').val('');
            $('#form').trigger("reset");
            $('#modal-title').html("Add FAQ");
            $('#modal').modal('show');
        });

        $(document).on('click', '.edit-faq', function () {
            var id = $(this).data('id');
            
            var url = "{{ route('admin.faq.edit',':id') }}".replace(':id',id);
            $.get(url, function (data) {
                $('#modal').modal('show');
                $('#modal-title').html("Edit FAQ");
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
            url: "{{ route('admin.faq.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#form').trigger("reset");
                $('#savedata').html("Save");
                $('#modal').modal('hide');
                Swal.fire({
                    title: "Good job!",
                    text: "You clicked the button!",
                    icon: "success"
                });
                table.draw();
                $('.invalid-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');
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

        $('body').on('click', '.delete-faq', function () {
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
                    var urlDelete = "{{ route('admin.faq.delete',':id') }}".replace(':id',id)
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