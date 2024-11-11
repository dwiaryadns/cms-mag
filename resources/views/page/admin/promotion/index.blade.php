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
                        <div id="wrap-search-group" class="mb-3">
                            <label for="">Search Group</label>
                            <div class="d-flex">
                                <input type="text" class="form-control" name="groupNameId" id="groupNameId"
                                    placeholder="Search Group">
                                <button class="btn btn-primary" id="btn-search-group" type="button"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div id="wrap-select-group" class="form-group mb-3">
                            <label for="">Group</label>
                            <select id="groupId" class="form-control" style="width: 100%" multiple="multiple"
                                name="groups[]">
                            </select>
                        </div>

                        <div id="wrap-search-policy" class="mb-3">
                            <label for="">Search Policy</label>
                            <div class="d-flex">
                                <input type="text" class="form-control" name="policyNameId" id="policyNameId"
                                    placeholder="Search Group">
                                <button class="btn btn-primary" id="btn-search-policy" type="button"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div id="wrap-select-policy" class="form-group mb-3">
                            <label for="">Policy No</label>
                            <select id="policyNo" class="form-control" style="width: 100%" multiple="multiple"
                                name="policyNo[]">
                            </select>
                        </div>

                        <div id="wrap-search-member" class="mb-3">
                            <label for="">Search Member</label>
                            <div class="d-flex">
                                <input type="text" class="form-control" name="memberNameId" id="memberNameId"
                                    placeholder="Search Group">
                                <button class="btn btn-primary" id="btn-search-member" type="button"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div id="wrap-select-member" class="form-group mb-3">
                            <label for="">Member</label>
                            <select id="memberId" class="form-control" style="width: 100%" multiple="multiple"
                                name="memberId[]">
                            </select>
                        </div>

                        <div id="wrap-edit">
                            <div>
                                <label for="">Group</label>
                                <textarea class="form-control" readonly id="show_group"></textarea>
                            </div>
                            <div>
                                <label for="">Branch</label>
                                <textarea class="form-control" readonly id="show_branch"></textarea>
                            </div>
                            <div>
                                <label for="">Policy</label>
                                <textarea class="form-control" readonly id="show_policy"></textarea>
                            </div>
                            <div>
                                <label for="">Member</label>
                                <textarea class="form-control" readonly id="show_member"></textarea>
                            </div>
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

<script>
    $(document).ready(function() {
        $('#groupId').select2({
            placeholder: 'Select groups',
            allowClear: true,
            dropdownParent: $("#modal"),
            multiple:true,
        });
        $('#policyNo').select2({
            placeholder: 'Select Policy No',
            allowClear: true,
            dropdownParent: $("#modal"),
            multiple:true,
        });
        $('#memberId').select2({
            placeholder: 'Select Member',
            allowClear: true,
            dropdownParent: $("#modal"),
            multiple:true,
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
        $("#btn-search-policy").click(function() {
            var search = $("#policyNameId").val();
            var selectedGroupId = $('#groupId').val();

            $.ajax({
                url: "{{ route('admin.indotek.getGroupPolList') }}",
                method: "POST",
                data: {
                    groupId: selectedGroupId,
                    polNoName: search
                },
                success: function(data) {
                    var results = JSON.parse(data.decrypt);
                    var selectedPolicies = $("#policyNo").val() || [];

                    $("#policyNo").empty();
                    $.each(results, function(index, value) {
                        var option = new Option(value.BranchId + " - " + value.PolicyNo, value.PolicyNo, false, selectedPolicies.includes(value.PolicyNo));
                        $("#policyNo").append(option);
                    });

                    $("#policyNo").trigger('change');
                }
            });
        });

        // $("#btn-search-member").click(function() {
        //     var search = $("#memberNameId").val();
        //     var selectedGroupId = $('#groupId').val();
        //     var selectedPolicyNo = $('#policyNo').val();
            
        //     $.ajax({
        //         url: "{{ route('admin.indotek.getGroupPolicyUserList') }}",
        //         method: "POST",
        //         data: {
        //             groupId: selectedGroupId,
        //             policyNo: selectedPolicyNo,
        //             memberName: search
        //         },
        //         success: function(data) {
        //             var results = JSON.parse(data.decrypt);
        //             var selectedMembers = $("#memberId").val() || [];

        //             // Keep existing options
        //             var existingOptions = {};
        //             $("#memberId option").each(function() {
        //                 existingOptions[$(this).val()] = $(this).text();
        //             });

        //             // Add new options from search results
        //             $.each(results, function(index, value) {
        //                 var optionText = value.Name + " - " + value.MemberID;
        //                 existingOptions[value.MemberID] = optionText;
        //             });

        //             // Rebuild the select with all options
        //             $("#memberId").empty();
        //             $.each(existingOptions, function(value, text) {
        //                 var option = new Option(text, value, false, selectedMembers.includes(value));
        //                 $("#memberId").append(option);
        //             });

        //             $("#memberId").trigger('change');
        //         }
        //     });
        // });
        $("#btn-search-member").click(function() {
    var search = $("#memberNameId").val();
    var selectedGroupId = $('#groupId').val();
    var selectedPolicyNo = $('#policyNo').val();

    $.ajax({
        url: "{{ route('admin.indotek.getGroupPolicyUserList') }}",
        method: "POST",
        data: {
            groupId: selectedGroupId,
            policyNo: selectedPolicyNo,
            memberName: search
        },
        success: function(data) {
            var results = JSON.parse(data.decrypt);
            var selectedMembers = $("#memberId").val() || [];

            // Menyimpan opsi yang sudah dipilih sebelumnya
            var selectedOptions = {};
            $("#memberId option:selected").each(function() {
                selectedOptions[$(this).val()] = $(this).text();
            });

            // Menggabungkan opsi terpilih dengan hasil pencarian baru
            $.each(results, function(index, value) {
                var optionText = value.Name + " - " + value.MemberID;
                selectedOptions[value.MemberID] = optionText;
            });

            // Bersihkan `#memberId` lalu tambahkan hanya opsi yang sudah dipilih dan hasil pencarian
            $("#memberId").empty();
            $.each(selectedOptions, function(value, text) {
                var option = new Option(text, value, false, selectedMembers.includes(value));
                $("#memberId").append(option);
            });

            $("#memberId").trigger('change');
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
                            const results = JSON.parse(response.decrypt);
                            console.log(results);

                            $.each(results, function(index, value) {
                                $("#policyNo").append(new Option(value.BranchId + " - " + value.PolicyNo, JSON.stringify({
                                    policyNo: value.PolicyNo,
                                    groupId: groupId,
                                    branchId:value.BranchId,
                                    policyCombine:value.BranchId+groupId+value.PolicyNo
                                })));
                            });

                            $("#policyNo").trigger('change');
                        }
                    });
                });
            }
        });

        // $("#policyNo").on('change', function() { 
        //     var selectedGroupIds = $('#groupId').val(); 
        //     var selectedPolicyNos = $(this).val(); 

        //     $("#memberId").empty(); 

        //     if (selectedPolicyNos && selectedPolicyNos.length > 0) {
        //         $.each(selectedPolicyNos, function(index, selectedPolicy) {
        //             var policyData = JSON.parse(selectedPolicy);
        //             var selectedPolicyNo = policyData.policyNo;
        //             var policyGroupId = policyData.groupId;

        //             if (selectedGroupIds.includes(policyGroupId)) {
        //                 $.ajax({
        //                     url: "{{ route('admin.indotek.getGroupPolicyUserList') }}", 
        //                     method: "POST",
        //                     data: {
        //                         groupId: policyGroupId, 
        //                         policyNo: selectedPolicyNo 
        //                     },
        //                     success: function(response) {
        //                         const results = JSON.parse(response.decrypt);
        //                         console.log('user list');
        //                         console.log(results);

        //                         $.each(results, function(index, value) {
        //                             console.log('value : ' + value);
        //                             if (!$("#memberId option[value='" + value.PolicyNo + "']").length) {
        //                                 $("#memberId").append(new Option(value.Name + " - " + value.MemberID, value.MemberID));
        //                             }
        //                         });

        //                         $("#memberId").trigger('change');
        //                     }
        //                 });
        //             } else {
        //                 console.log("Selected PolicyNo does not match the selected GroupId.");
        //             }
        //         });
        //     }
        // });
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
            $("#wrap-edit").hide();
            $('#wrap-search-group').show();
            $('#wrap-select-group').show();
            $('#wrap-search-policy').show();
            $('#wrap-select-policy').show();
            $('#wrap-search-member').show();
            $('#wrap-select-member').show();
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
            $('#wrap-search-group').hide();
            $('#wrap-select-group').hide();
            $('#wrap-search-policy').hide();
            $('#wrap-select-policy').hide();
            $('#wrap-search-member').hide();
            $('#wrap-select-member').hide();
            $("#wrap-edit").show();

            var url = "{{ route('admin.promotion.edit',':id') }}".replace(':id',id);
                $.get(url, function (data) {
                    console.log(data)
                $('#modal').modal('show');
                $('#modal-title').html("Edit promotion");
                $('#savedata').html('Save');
                $('#id').val(data.id);
                $('#title').val(data.title);
                $('#author').val(data.author);
                $('#link_url').val(data.link_url);
                $('#start_date').val(data.start_date);
                $('#end_date').val(data.end_date);
                $('#show_group').val(data.group_id);
                $('#show_policy').val(data.polis_id);
                $('#show_member').val(data.member_id);
                $('#show_branch').val(data.branch_id);
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
                    icon: "success",
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
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