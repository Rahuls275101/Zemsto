<!-- CONTENT WRAPPER -->
<div class="ec-content-wrapper">
    <div class="content">
        <!-- Breadcrumb -->
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>All Students</h1>
                <p class="breadcrumbs">
                    <span><a href="<?= base_url('admin/dashboard') ?>">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    All Students
                </p>
            </div>
            <div>
                <a href="javascript:void(0);" class="btn btn-success" id="exportCsvBtn">
                    <i class="fas fa-file-export"></i> Export All
                </a>
                <a href="javascript:void(0);" class="btn btn-info" id="exportFilteredBtn">
                    <i class="fas fa-filter"></i> Export Filtered
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>User Type</label>
                                    <select class="form-control filter-select" id="filter_user_type">
                                        <option value="">All Types</option>
                                        <option value="student">Student</option>
                                        <option value="teacher">Teacher</option>
                                        <option value="parent">Parent</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control filter-select" id="filter_status">
                                        <option value="">All Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Approval</label>
                                    <select class="form-control filter-select" id="filter_approval">
                                        <option value="">All</option>
                                        <option value="approved">Approved</option>
                                        <option value="pending">Pending</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="form-control filter-select" id="filter_gender">
                                        <option value="">All</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="ec-cat-list card card-default">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ajax_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Class/Grade</th>
                                        <th>School</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- VIEW STUDENT MODAL -->
<!-- ============================================================ -->
<div class="modal fade" id="viewStudent" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff;">
                <h5 class="modal-title" id="viewModalLabel"><i class="fas fa-user-graduate"></i> Student Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Student Photo -->
                    <div class="col-md-3 text-center">
                        <div class="student-photo">
                            <img id="view_user_photo" src="<?= base_url('assets/images/default-user.png') ?>" 
                                 class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #4e73df;">
                            <h5 class="mt-2" id="view_user_name">-</h5>
                            <p class="text-muted" id="view_user_type">-</p>
                        </div>
                    </div>
                    
                    <!-- Personal Information -->
                    <div class="col-md-9">
                        <ul class="nav nav-tabs" id="studentTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal" role="tab">Personal Info</a>
                            </li>
                        </ul>
                        
                        <div class="tab-content mt-3" id="studentTabContent">
                            <!-- Personal Info Tab -->
                            <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-sm">
                                            <tr><th width="40%">Account ID</th><td id="view_account_id">-</td></tr>
                                            <tr><th>Email</th><td id="view_user_email">-</td></tr>
                                            <tr><th>Phone</th><td id="view_user_phone">-</td></tr>
                                            <tr><th>Date of Birth</th><td id="view_date_of_birth">-</td></tr>
                                            <tr><th>Age</th><td id="view_user_age">-</td></tr>
                                            <tr><th>Gender</th><td id="view_gender">-</td></tr>
                                            <tr><th>Class/Grade</th><td id="view_class_grade">-</td></tr>
                                            <tr><th>Parent Name</th><td id="view_parent_name">-</td></tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-sm">
                                            <tr><th>School Name</th><td id="view_school_name">-</td></tr>
                                            <tr><th>School Branch</th><td id="view_school_branch">-</td></tr>
                                            <tr><th>Country</th><td id="view_user_country">-</td></tr>
                                            <tr><th>State</th><td id="view_user_state">-</td></tr>
                                            <tr><th>City</th><td id="view_user_city">-</td></tr>
                                            <tr><th>Address</th><td id="view_user_address">-</td></tr>
                                            <tr><th>Pincode</th><td id="view_user_pincode">-</td></tr>
                                            <tr><th>Status</th><td id="view_status">-</td></tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- JAVASCRIPT -->
<!-- ============================================================ -->
<script>
$(document).ready(function() {

    // =============================================
    // DATATABLE
    // =============================================
    var table = $('#ajax_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?= base_url('admin/students-list') ?>",
            "type": "POST",
            "data": function(d) {
                d.user_type = $('#filter_user_type').val();
                d.status = $('#filter_status').val();
                d.approval = $('#filter_approval').val();
                d.gender = $('#filter_gender').val();
            }
        },
        "columns": <?= $table_column ?? '[]' ?>,
        "order": [[0, 'DESC']],
        "language": {
            "processing": '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
        }
    });

    // =============================================
    // FILTERS
    // =============================================
    $('.filter-select').on('change', function() {
        table.ajax.reload();
    });

    // =============================================
    // VIEW STUDENT
    // =============================================
    $('#ajax_table').on('click', '.viewStudent', function() {
        var data = $(this).data();
        
        // Personal Info
        $('#view_account_id').text(data.account_id || '-');
        $('#view_user_name').text(data.user_name || '-');
        $('#view_user_email').text(data.user_email || '-');
        $('#view_user_phone').text(data.user_phone || '-');
        $('#view_user_type').text(data.user_type || '-');
        $('#view_date_of_birth').text(data.date_of_birth || '-');
        $('#view_user_age').text(data.user_age || '-');
        $('#view_gender').text(data.gender || '-');
        $('#view_class_grade').text(data.class_grade || '-');
        $('#view_parent_name').text(data.parent_name || '-');
        $('#view_user_country').text(data.user_country || '-');
        $('#view_user_state').text(data.user_state || '-');
        $('#view_user_city').text(data.user_city || '-');
        $('#view_user_address').text(data.user_address || '-');
        $('#view_user_pincode').text(data.user_pincode || '-');
        $('#view_school_name').text(data.school_name || '-');
        $('#view_school_branch').text(data.school_branch || '-');
        
        // Status Badge
        var status = data.user_status || 'N/A';
        var statusBadge = '';
        if (status == 'Active') {
            statusBadge = '<span class="badge bg-success">Active</span>';
        } else if (status == 'Inactive') {
            statusBadge = '<span class="badge bg-danger">Inactive</span>';
        } else if (status == 'Pending') {
            statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
        } else {
            statusBadge = '<span class="badge bg-secondary">' + status + '</span>';
        }
        $('#view_status').html(statusBadge);
        
        // Student Photo
        if (data.user_photo && data.user_photo != '') {
            $('#view_user_photo').attr('src', '<?= base_url('assets/user/') ?>' + data.user_photo);
        } else {
            $('#view_user_photo').attr('src', '<?= base_url('assets/images/default-user.png') ?>');
        }
        
        $('#viewStudent').modal('show');
    });

    // =============================================
    // EXPORT ALL CSV
    // =============================================
    $('#exportCsvBtn').on('click', function() {
        window.location.href = '<?= base_url("admin/csv-export") ?>';
    });

    // =============================================
    // EXPORT FILTERED CSV
    // =============================================
    $('#exportFilteredBtn').on('click', function() {
        // Get filter values
        var filters = {
            user_type: $('#filter_user_type').val(),
            status: $('#filter_status').val(),
            approval: $('#filter_approval').val(),
            gender: $('#filter_gender').val()
        };
        
        // Create form and submit
        var form = $('<form>', {
            method: 'POST',
            action: '<?= base_url("admin/csv-export-filtered") ?>'
        });
        
        $.each(filters, function(key, value) {
            if (value) {
                form.append($('<input>', {
                    type: 'hidden',
                    name: key,
                    value: value
                }));
            }
        });
        
        $('body').append(form);
        form.submit();
        form.remove();
    });

});
</script>

<!-- ============================================================ -->
<!-- STYLES -->
<!-- ============================================================ -->
<style>
.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 6px 12px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 5px 12px;
    border-radius: 4px;
}
.table th {
    background: #f8f9fc;
    font-weight: 600;
}
.view-btn {
    background: #4e73df;
    color: #fff;
    border: none;
    padding: 5px 12px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s;
}
.view-btn:hover {
    background: #224abe;
    color: #fff;
}
.modal-body .table th {
    background: #f8f9fc;
    width: 40%;
}
.student-photo {
    padding: 20px 0;
}
.nav-tabs .nav-link {
    color: #4e73df;
    font-weight: 600;
}
.nav-tabs .nav-link.active {
    color: #224abe;
    font-weight: 700;
    border-bottom: 3px solid #4e73df;
}
.filter-section .form-group {
    margin-bottom: 0;
}
.btn-success, .btn-info {
    color: #fff;
    padding: 8px 20px;
    border-radius: 4px;
    transition: all 0.3s;
}
.btn-success:hover, .btn-info:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>