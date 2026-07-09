<!-- CONTENT WRAPPER -->
<div class="ec-content-wrapper">
    <div class="content">
        <!-- Breadcrumb -->
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>All Competition Registrations</h1>
                <p class="breadcrumbs">
                    <span><a href="index.html">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    All Registrations
                </p>
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
                                        <th>Student</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Class</th>
                                        <th>School</th>
                                        <th>Competition</th>
                                        <th>Price</th>
                                        <th>Type</th>
                                        <th>Payment</th>
                                        <th>Created</th>
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
<!-- VIEW REGISTRATION MODAL -->
<!-- ============================================================ -->
<div class="modal fade" id="viewRegistration" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff;">
                <h5 class="modal-title" id="viewModalLabel"><i class="fas fa-file-invoice"></i> Registration Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Student Info -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card" style="background: #f8f9fc; border-left: 5px solid #4e73df;">
                            <div class="card-body">
                                <h6><i class="fas fa-user-graduate text-primary"></i> Student Information</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <img id="view_student_photo" src="<?= base_url('assets/images/default-user.png') ?>" 
                                             class="img-fluid rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #4e73df;">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-bordered table-sm">
                                                    <tr><th width="40%">Student Name</th><td id="view_student_name">-</td></tr>
                                                    <tr><th>Email</th><td id="view_student_email">-</td></tr>
                                                    <tr><th>Phone</th><td id="view_student_phone">-</td></tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-bordered table-sm">
                                                    <tr><th width="40%">Class/Grade</th><td id="view_student_class">-</td></tr>
                                                    <tr><th>School</th><td id="view_student_school">-</td></tr>
                                                    <tr><th>Gender</th><td id="view_student_gender">-</td></tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Info -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" style="background: #f8f9fc; border-left: 5px solid #28a745;">
                            <div class="card-body">
                                <h6><i class="fas fa-trophy text-success"></i> Registration Information</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-sm">
                                            <tr><th width="40%">Registration ID</th><td id="view_reg_id">-</td></tr>
                                            <tr><th>Competition Name</th><td id="view_comp_name">-</td></tr>
                                            <tr><th>Competition Price</th><td id="view_comp_price">-</td></tr>
                                            <tr><th>Competition Type</th><td id="view_comp_type">-</td></tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-sm">
                                            <tr><th width="40%">Registration Status</th><td id="view_reg_status">-</td></tr>
                                            <tr><th>Payment Status</th><td id="view_pay_status">-</td></tr>
                                            <tr><th>Razorpay Order ID</th><td id="view_razorpay_order">-</td></tr>
                                            <tr><th>Razorpay Payment ID</th><td id="view_razorpay_payment">-</td></tr>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {

    // =============================================
    // DATATABLE
    // =============================================
    var table = $('#ajax_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?= base_url('admin/competition-registrations-list') ?>",
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "student" },
            { "data": "email" },
            { "data": "phone" },
            { "data": "class" },
            { "data": "school" },
            { "data": "competition" },
            { "data": "price" },
            { "data": "type" },
            { "data": "payment" },
            { "data": "created" },
            { "data": "action" }
        ],
        "order": [[0, 'DESC']],
        "language": {
            "processing": '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
        }
    });

    // =============================================
    // VIEW REGISTRATION
    // =============================================
    $('#ajax_table').on('click', '.viewRecord', function() {
        var data = $(this).data();
        
        // Student Info
        $('#view_student_name').text(data.student_name || '-');
        $('#view_student_email').text(data.student_email || '-');
        $('#view_student_phone').text(data.student_phone || '-');
        $('#view_student_class').text(data.student_class || '-');
        $('#view_student_school').text(data.student_school || '-');
        $('#view_student_gender').text(data.student_gender || '-');
        
        // Student Photo
        if (data.student_photo && data.student_photo != '') {
            $('#view_student_photo').attr('src', '<?= base_url('assets/user/') ?>' + data.student_photo);
        } else {
            $('#view_student_photo').attr('src', '<?= base_url('assets/images/default-user.png') ?>');
        }
        
        // Registration Info
        $('#view_reg_id').text(data.reg_id || '-');
        $('#view_comp_name').text(data.comp_name || '-');
        $('#view_comp_price').text(data.comp_price || '-');
        $('#view_comp_type').text(data.comp_type || '-');
        
        // Registration Status Badge
        var regStatus = '';
        if (data.reg_status == 'confirmed') {
            regStatus = '<span class="badge bg-success">Confirmed</span>';
        } else if (data.reg_status == 'pending') {
            regStatus = '<span class="badge bg-warning text-dark">Pending</span>';
        } else if (data.reg_status == 'cancelled') {
            regStatus = '<span class="badge bg-danger">Cancelled</span>';
        } else {
            regStatus = '<span class="badge bg-secondary">' + (data.reg_status || 'N/A') + '</span>';
        }
        $('#view_reg_status').html(regStatus);
        
        // Payment Status Badge
        var payStatus = '';
        if (data.pay_status == 'completed') {
            payStatus = '<span class="badge bg-success">Completed</span>';
        } else if (data.pay_status == 'pending') {
            payStatus = '<span class="badge bg-warning text-dark">Pending</span>';
        } else if (data.pay_status == 'failed') {
            payStatus = '<span class="badge bg-danger">Failed</span>';
        } else if (data.pay_status == 'refunded') {
            payStatus = '<span class="badge bg-info">Refunded</span>';
        } else {
            payStatus = '<span class="badge bg-secondary">' + (data.pay_status || 'N/A') + '</span>';
        }
        $('#view_pay_status').html(payStatus);
        
        $('#view_razorpay_order').text(data.razorpay_order || '-');
        $('#view_razorpay_payment').text(data.razorpay_payment || '-');
        
        $('#viewRegistration').modal('show');
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
</style>