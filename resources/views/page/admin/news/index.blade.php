@extends('layouts.master')

@section('content')
<section>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Admin</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('admin.news.index') }}">News</a>
            </li>
        </ol>
    </nav>
    <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="">Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Title">
                        </div>
                        <div class="mb-3">
                            <label for="">Author</label>
                            <input type="text" class="form-control" name="author" id="author" placeholder="Author">
                        </div>
                        <div class="mb-3">
                            <label for="">Link URL</label>
                            <input type="text" class="form-control" name="link_url" id="link_url"
                                placeholder="Link URL">
                        </div>
                        <div class="mb-3">
                            <label for="">Image</label>
                            <input type="file" class="form-control" name="image" id="image" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Description</label>
                            <textarea type="text" class="form-control" name="description" id="description"></textarea>
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
        <h5 class="card-header bg-primary mb-3 text-white">News</h5>
        <div class="card-body">
            <div class="d-flex mb-3 justify-content-end">
                <button id="addNews" class="btn btn-primary"><i class="fas fa-plus"></i> Add News</button>
            </div>
            <div class="table-responsive">
                <table id="datatable" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Image</th>
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
        placeholder: 'Description',
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
        ]
    });
    })
    var table = $('#datatable').DataTable({
            responsive:true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.news.getNews') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'title', name: 'title'},
                { data: 'author', name: 'author'},
                { data: 'image', name: 'image'},
                { data: 'description', name: 'description'},
                { data: 'action', name: 'action'},
            ]
        })

        $('#addNews').click(function () {
            $('#savedata').data("action", "create-news");
            $('#id').val('');
            // $('#form').trigger("reset");
            $('#modal-title').html("Add NEWS");
            $('#modal').modal('show');
        });

        $(document).on('click', '.read-more', function () {
            var id = $(this).data('id');
            var url = "{{ route('admin.news.edit',':id') }}".replace(':id',id);
                $.get(url, function (data) {
                $('#read-more').modal('show');
                $("#description-read-more").html(data.description);
            })
        });
        $(document).on('click', '.edit-news', function () {
            var id = $(this).data('id');
            var url = "{{ route('admin.news.edit',':id') }}".replace(':id',id);
                $.get(url, function (data) {
                $('#modal').modal('show');
                $('#modal-title').html("Edit News");
                $('#savedata').html('Save');
                $('#id').val(data.id);
                $('#title').val(data.title);
                $('#author').val(data.author);
                $('#link_url').val(data.link_url);
                $("#description").summernote("code",data.description);
            })
        });

        $('#savedata').click(function (e) {
        e.preventDefault();

        $(this).html('Sending..');
        var formData = new FormData();
        var imageFile = $('#image')[0].files[0]; // Ambil file gambar dari input


        formData.append('id', $("#id").val());
        formData.append('title', $("#title").val());
        formData.append('author', $("#author").val());
        formData.append('link_url', $("#link_url").val());
        formData.append('image', imageFile);
        if($('#description').summernote('isEmpty')) {
            console.log('contents is empty, fill it!');
        } else {
            formData.append('description', $('#description').summernote('code'));
        }
        $.ajax({
            data:formData,
            processData: false, 
            contentType: false,
            url: "{{ route('admin.news.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
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
                console.log(error)
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

        $('body').on('click', '.delete-news', function () {
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
                var urlDelete = "{{ route('admin.news.delete',':id') }}".replace(':id',id)
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