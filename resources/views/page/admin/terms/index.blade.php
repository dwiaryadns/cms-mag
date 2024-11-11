@extends('layouts.master')

@section('content')
<section>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Admin</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('admin.terms.index') }}">Terms</a>
            </li>
        </ol>
    </nav>
    <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="emailBasic" class="form-label">Type (Indonesia)</label>
                            <input id="type" type="text" class="form-control" name="type">
                        </div>
                        <div class="mb-3">
                            <label for="nameBasic" class="form-label">Description (Indonesia)</label>
                            <textarea id="description" class="form-control" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="emailBasic" class="form-label">Type (English)</label>
                            <input id="type_en" type="text" class="form-control" name="type">
                        </div>
                        <div class="mb-3">
                            <label for="nameBasic" class="form-label">Description (English)</label>
                            <textarea id="description_en" class="form-control" name="description"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="savedata" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="read-more" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="description-read-more">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header bg-primary mb-3 text-white">Terms</h5>
        <div class="card-body">
            <div class="d-flex mb-3 justify-content-end">
                <button id="addTerms" class="btn btn-primary"><i class="fas fa-plus"></i> Add Terms</button>
            </div>
            <div class="table-responsive">
                <table id="datatable" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th style="width: 500px">Description</th>
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
    const description = document.querySelector("#description")
    var myEditor;

    $(document).ready(function() {
        $('#description').summernote(  {
        placeholder: 'Description (Indonesia)',
        tabsize: 2,
        height: 120,
        toolbar: [
        ['style', ['style']],
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['fontname', ['fontname']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                document.execCommand('insertText', false, bufferText);
            }
        }
    });
    })
    $(document).ready(function() {
        $('#description_en').summernote(  {
        placeholder: 'Description (English)',
        tabsize: 2,
        height: 120,
        toolbar: [
        ['style', ['style']],
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['fontname', ['fontname']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                document.execCommand('insertText', false, bufferText);
            }
        }
    });
    })
    var table = $('#datatable').DataTable({
            responsive:true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.terms.getTerms') }}",

            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'type', name: 'type'},
                { data: 'description', name: 'description'},
                { data: 'action', name: 'action'},
            ]
        })

        $('#addTerms').click(function () {
            $('#savedata').data("action", "create-terms");
            $('#id').val('');
            $('#form').trigger("reset");
            $('#modal-title').html("Add Terms");
            $('#modal').modal('show');
        });

        $(document).on('click', '.read-more', function () {
            var id = $(this).data('id');
            var url = "{{ route('admin.terms.edit',':id') }}".replace(':id',id);
                $.get(url, function (data) {
                $('#read-more').modal('show');
                $("#description-read-more").html(data.description);
            })
        });

        $(document).on('click', '.edit-terms', function () {
            var id = $(this).data('id');
            var url = "{{ route('admin.terms.edit',':id') }}".replace(':id',id);
                $.get(url, function (data) {
                $('#modal').modal('show');
                $('#modal-title').html("Edit Terms");
                $('#savedata').html('Save');
                $('#id').val(data.id);
                $('#type').val(data.type);
                $("#description").summernote("code",data.description);
                $('#type_en').val(data.type_en);
                $("#description_en").summernote("code",data.description_en);
            })
        });

        $('#savedata').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
            data: {
                id: $("#id").val(),
                type: $("#type").val(),
                description: $('#description').summernote('code'),
                type_en: $("#type_en").val(),
                description_en: $('#description_en').summernote('code'),
            },
            url: "{{ route('admin.terms.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                console.log(data)
                $('#form').trigger("reset");
                $('#savedata').html("Save");
                $('#modal').modal('hide');
                $('#description').summernote('reset');
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

        $('body').on('click', '.delete-terms', function () {
        var id = $(this).data("id");
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
                var urlDelete = "{{ route('admin.terms.delete',':id') }}".replace(':id',id)
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