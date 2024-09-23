@extends('layouts.master')

@section('content')
<section>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Admin</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('admin.promotion.index') }}">Promotion</a>
            </li>
        </ol>
    </nav>
    <div class="modal fade" id="modal" role="dialog" aria-hidden="true">
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
                        <div class="row mb-3">
                            <div class="col">
                                <label for="">Start Date</label>
                                <input type="date" class="form-control" name="start_date" id="start_date"
                                    placeholder="Link URL">
                            </div>
                            <div class="col">
                                <label for="">End Date</label>
                                <input type="date" class="form-control" name="end_date" id="end_date"
                                    placeholder="Link URL">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Image</label>
                            <input type="file" class="form-control" name="image" id="image" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Search Group</label>
                            <div class="d-flex">
                                <input type="text" class="form-control" name="groupNameId" id="groupNameId"
                                    placeholder="Search Group">
                                <button class="btn btn-primary" id="btn-search-group" type="button"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Group</label>
                            <select id="groupId" class="form-control" style="width: 100%" multiple="multiple"
                                name="groups[]">
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Policy No</label>
                            <select id="policyNo" class="form-control" style="width: 100%" multiple="multiple"
                                name="policyNo[]">
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Member</label>
                            <select id="memberId" class="form-control" style="width: 100%" multiple="multiple"
                                name="memberId[]">
                            </select>
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
        <h5 class="card-header bg-primary mb-3 text-white">Promotion</h5>
        <div class="card-body">
            <div class="d-flex mb-3 justify-content-end">
                <button id="addPromotion" class="btn btn-primary"><i class="fas fa-plus"></i> Add Promotion</button>
            </div>
            <div class="table-responsive">
                <table id="datatable" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Image</th>
                            <th>Date</th>
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
@push('scripts')
{{-- <script>
    $(document).ready(function() {
        $('#groupId').select2({
            placeholder: 'Select groups',
            allowClear: true,
            dropdownParent: $("#modal")
        });
        $('#policyNo').select2({
            placeholder: 'Select Policy No',
            allowClear: true,
            dropdownParent: $("#modal")
        });
        $('#memberId').select2({
            placeholder: 'Select Member',
            allowClear: true,
            dropdownParent: $("#modal")
        });

        $("#btn-search-group").click(function() {
            var search = $("#groupNameId").val();
            $.ajax({
                url: "{{ route('admin.indotek.getGroupList') }}",
                method: "POST",
                data: { groupName: search },
                success: function(data) {
                    var selectedGroups = $("#groupId").val() || []; 
                    var results = JSON.parse(data.decrypt);
                    console.log(results);
                    $("#groupId").find('option').each(function() {
                        if (!selectedGroups.includes($(this).val())) {
                            $(this).remove();
                        }
                    });

                    $.each(results, function(index, value) {
                        if (!$("#groupId option[value='" + value.GroupId + "']").length) {
                            $("#groupId").append(new Option(value.GroupName+" - "+value.GroupId, value.GroupId));
                        }
                    });

                    $("#groupId").trigger('change');

                }
            });
        });

        $('#groupId').on('change', function() {
            var selectedGroupIds = $(this).val(); 
            $("#policyNo").empty();
            if (selectedGroupIds && selectedGroupIds.length > 0) {
                $.each(selectedGroupIds, function(index, groupId) {
                    console.log(groupId)
                    $.ajax({
                        url: "{{ route('admin.indotek.getGroupPolList') }}", 
                        method: "POST",
                        data: { groupId: groupId }, 
                        success: function(response) {
                            const results = JSON.parse(response.decrypt)
                            console.log(results);
                            $.each(results, function(index, value) {
                                $("#policyNo").append(new Option(value.BranchId+ " - " + value.PolicyNo, value.PolicyNo));
                            });
                            $("#policyNo").trigger('change');
                        }
                    });
                });
            }
        });

        $("#policyNo").on('change', function(){ 
            var selectedGroupIds = $('#groupId').val(); 
            var selectedPolicyNos = $(this).val(); 
            
            if (selectedGroupIds && selectedPolicyNos) {
                $.ajax({
                    url: "{{ route('admin.indotek.getGroupPolicyUserList') }}", 
                    method: "POST",
                    data: {
                        groupId: selectedGroupIds, 
                        policyNo: selectedPolicyNos
                    },
                    success: function(response) {
                        const results = JSON.parse(response.decrypt)
                        console.log('user list')
                        console.log(results);
                        $.each(results, function(index, value) {
                            $("#memberId").append(new Option(value.BranchId+ " - " + value.PolicyNo, value.PolicyNo));
                        });
                        $("#memberId").trigger('change');
                    }
                });
            }
        });
    });
</script> --}}
{{-- <script>
    $(document).ready(function() {
        // Initialize Select2 for groups, policy numbers, and members
        $('#groupId').select2({
            placeholder: 'Select groups',
            allowClear: true,
            dropdownParent: $("#modal")
        });
        $('#policyNo').select2({
            placeholder: 'Select Policy No',
            allowClear: true,
            dropdownParent: $("#modal")
        });
        $('#memberId').select2({
            placeholder: 'Select Member',
            allowClear: true,
            dropdownParent: $("#modal")
        });

        // Handle search group functionality
        $("#btn-search-group").click(function() {
            var search = $("#groupNameId").val();
            $.ajax({
                url: "{{ route('admin.indotek.getGroupList') }}",
                method: "POST",
                data: { groupName: search },
                success: function(data) {
                    var selectedGroups = $("#groupId").val() || [];
                    var results = JSON.parse(data.decrypt);
                    console.log(results);

                    // Remove groups not in selectedGroups
                    $("#groupId").find('option').each(function() {
                        if (!selectedGroups.includes($(this).val())) {
                            $(this).remove();
                        }
                    });

                    // Add new groups to the select
                    $.each(results, function(index, value) {
                        if (!$("#groupId option[value='" + value.GroupId + "']").length) {
                            $("#groupId").append(new Option(value.GroupName+" - "+value.GroupId, value.GroupId));
                        }
                    });

                    $("#groupId").trigger('change');
                }
            });
        });

        // Handle group selection change
        $('#groupId').on('change', function() {
            var selectedGroupIds = $(this).val(); 
            $("#policyNo").empty();
            if (selectedGroupIds && selectedGroupIds.length > 0) {
                $.each(selectedGroupIds, function(index, groupId) {
                    console.log(groupId)
                    $.ajax({
                        url: "{{ route('admin.indotek.getGroupPolList') }}", 
                        method: "POST",
                        data: { groupId: groupId }, 
                        success: function(response) {
                            const results = JSON.parse(response.decrypt);
                            console.log(results);

                            // Add policies for selected groupId to the select
                            $.each(results, function(index, value) {
                                $("#policyNo").append(new Option(value.BranchId + " - " + value.PolicyNo, JSON.stringify({
                                    policyNo: value.PolicyNo,
                                    groupId: groupId
                                })));
                            });

                            $("#policyNo").trigger('change');
                        }
                    });
                });
            }
        });

        // Handle policy number selection change
        $("#policyNo").on('change', function() { 
            var selectedGroupIds = $('#groupId').val(); 
            var selectedPolicy = $(this).val(); 

            if (selectedPolicy) {
                var policyData = JSON.parse(selectedPolicy);
                console.log(policyData);
                var selectedPolicyNo = policyData.policyNo;
                var policyGroupId = policyData.groupId;

                if (selectedGroupIds.includes(policyGroupId)) {
                    $.ajax({
                        url: "{{ route('admin.indotek.getGroupPolicyUserList') }}", 
                        method: "POST",
                        data: {
                            groupId: policyGroupId, 
                            policyNo: selectedPolicyNo 
                        },
                        success: function(response) {
                            const results = JSON.parse(response.decrypt);
                            console.log('user list');
                            console.log(results);

                            $.each(results, function(index, value) {
                                $("#memberId").append(new Option(value.Name + " - " + value.MemberID, value.MemberID));
                            });

                            $("#memberId").trigger('change');
                        }
                    });
                } else {
                    console.log("Selected PolicyNo does not match the selected GroupId.");
                }
            }
        });
    });
</script> --}}

<script>
    $(document).ready(function() {
        // Initialize Select2 for groups, policy numbers, and members
        $('#groupId').select2({
            placeholder: 'Select groups',
            allowClear: true,
            dropdownParent: $("#modal")
        });
        $('#policyNo').select2({
            placeholder: 'Select Policy No',
            allowClear: true,
            dropdownParent: $("#modal")
        });
        $('#memberId').select2({
            placeholder: 'Select Member',
            allowClear: true,
            dropdownParent: $("#modal")
        });

        // Handle search group functionality
        $("#btn-search-group").click(function() {
            var search = $("#groupNameId").val();
            $.ajax({
                url: "{{ route('admin.indotek.getGroupList') }}",
                method: "POST",
                data: { groupName: search },
                success: function(data) {
                    var selectedGroups = $("#groupId").val() || [];
                    var results = JSON.parse(data.decrypt);
                    console.log(results);

                    // Remove groups not in selectedGroups
                    $("#groupId").find('option').each(function() {
                        if (!selectedGroups.includes($(this).val())) {
                            $(this).remove();
                        }
                    });

                    // Add new groups to the select
                    $.each(results, function(index, value) {
                        if (!$("#groupId option[value='" + value.GroupId + "']").length) {
                            $("#groupId").append(new Option(value.GroupName+" - "+value.GroupId, value.GroupId));
                        }
                    });

                    $("#groupId").trigger('change');
                }
            });
        });

        // Handle group selection change
        $('#groupId').on('change', function() {
            var selectedGroupIds = $(this).val(); 
            $("#policyNo").empty();
            if (selectedGroupIds && selectedGroupIds.length > 0) {
                $.each(selectedGroupIds, function(index, groupId) {
                    console.log(groupId)
                    $.ajax({
                        url: "{{ route('admin.indotek.getGroupPolList') }}", 
                        method: "POST",
                        data: { groupId: groupId }, 
                        success: function(response) {
                            const results = JSON.parse(response.decrypt);
                            console.log(results);

                            $.each(results, function(index, value) {
                                $("#policyNo").append(new Option(value.BranchId + " - " + value.PolicyNo, JSON.stringify({
                                    policyNo: value.PolicyNo,
                                    groupId: groupId
                                })));
                            });

                            $("#policyNo").trigger('change');
                        }
                    });
                });
            }
        });

        $("#policyNo").on('change', function() { 
            var selectedGroupIds = $('#groupId').val(); 
            var selectedPolicyNos = $(this).val(); 

            $("#memberId").empty(); 

            if (selectedPolicyNos && selectedPolicyNos.length > 0) {
                $.each(selectedPolicyNos, function(index, selectedPolicy) {
                    var policyData = JSON.parse(selectedPolicy);
                    var selectedPolicyNo = policyData.policyNo;
                    var policyGroupId = policyData.groupId;

                    if (selectedGroupIds.includes(policyGroupId)) {
                        $.ajax({
                            url: "{{ route('admin.indotek.getGroupPolicyUserList') }}", 
                            method: "POST",
                            data: {
                                groupId: policyGroupId, 
                                policyNo: selectedPolicyNo 
                            },
                            success: function(response) {
                                const results = JSON.parse(response.decrypt);
                                console.log('user list');
                                console.log(results);

                                $.each(results, function(index, value) {
                                    console.log('value : ' + value);
                                    if (!$("#memberId option[value='" + value.PolicyNo + "']").length) {
                                        $("#memberId").append(new Option(value.Name + " - " + value.MemberID, value.MemberID));
                                    }
                                });

                                $("#memberId").trigger('change');
                            }
                        });
                    } else {
                        console.log("Selected PolicyNo does not match the selected GroupId.");
                    }
                });
            }
        });
    });
</script>

@endpush
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
        $('#description').summernote({
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
            ajax: "{{ route('admin.promotion.getPromotion') }}",

            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'title', name: 'title'},
                { data: 'author', name: 'author'},
                { data: 'image', name: 'image'},
                { data: 'date', name: 'date'},
                { data: 'description', name: 'description'},
                { data: 'action', name: 'action'},
            ]
        })

        $('#addPromotion').click(function () {
            $('#savedata').data("action", "create-promotion");
            $('#id').val('');
            $('#modal-title').html("Add Promotion");
            $('#modal').modal('show');
        });

        $(document).on('click', '.read-more', function () {
            var id = $(this).data('id');
            var url = "{{ route('admin.promotion.edit',':id') }}".replace(':id',id);
                $.get(url, function (data) {
                $('#read-more').modal('show');
                $("#description-read-more").html(data.description);
            })
        });
        $(document).on('click', '.edit-promotion', function () {
            var id = $(this).data('id');
            var url = "{{ route('admin.promotion.edit',':id') }}".replace(':id',id);
                $.get(url, function (data) {
                $('#modal').modal('show');
                $('#modal-title').html("Edit promotion");
                $('#savedata').html('Save');
                $('#id').val(data.id);
                $('#title').val(data.title);
                $('#author').val(data.author);
                $('#link_url').val(data.link_url);
                $('#start_date').val(data.start_date);
                $('#end_date').val(data.end_date);
                $("#description").summernote("code",data.description);
            })
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            var formData = new FormData();
            var imageFile = $('#image')[0].files[0]; 
            formData.append('id', $("#id").val());
            formData.append('title', $("#title").val());
            formData.append('author', $("#author").val());
            formData.append('link_url', $("#link_url").val());
            formData.append('start_date', $("#start_date").val());
            formData.append('end_date', $("#end_date").val());
            formData.append('group_id', $("#groupId").val());
            formData.append('polis_id', $("#policyNo").val());
            formData.append('member_id', $("#memberId").val());
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
            url: "{{ route('admin.promotion.store') }}",
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

        $('body').on('click', '.delete-promotion', function () {
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
                var urlDelete = "{{ route('admin.promotion.delete',':id') }}".replace(':id',id)
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