<!-- CONTENT WRAPPER -->
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Enquiry List</h1>
                <p class="breadcrumbs">
                    <span><a href="<?= base_url('admin/dashboard') ?>">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Enquiry List
                </p>
            </div>
            <div>
                <span class="badge bg-primary" id="totalEnquiries">Loading...</span>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="ec-cat-list card card-default">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ajax_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Book Name</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Created At</th>
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

<!-- ============================================ -->
<!-- VIEW ENQUIRY MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="viewEnquiryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-eye"></i> Enquiry Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Book Name:</strong> <span id="viewBookName"></span></p>
                        <p><strong>Name:</strong> <span id="viewName"></span></p>
                        <p><strong>Email:</strong> <span id="viewEmail"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Phone:</strong> <span id="viewPhone"></span></p>
                        <p><strong>Status:</strong> <span id="viewStatus"></span></p>
                        <p><strong>Created At:</strong> <span id="viewCreated"></span></p>
                    </div>
                    <div class="col-md-12">
                        <p><strong>Message:</strong></p>
                        <p id="viewMessage" class="p-3 bg-light rounded"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- UPDATE STATUS MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="updateStatusForm">
                    <input type="hidden" name="enquiry_id" id="statusEnquiryId">
                    <div class="mb-3">
                        <label class="form-label">Select Status</label>
                        <select class="form-control" name="status" id="statusSelect" required>
                            <option value="Pending">Pending</option>
                            <option value="Contacted">Contacted</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- DATATABLE & AJAX SCRIPTS -->
<!-- ============================================ -->
<script>
$(document).ready(function() {
    
    // ============================================
    // DATATABLE
    // ============================================
    var table = $('#ajax_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?= base_url('admin/enquiry-list') ?>",
            "type": "POST"
        },
        "columns": <?= $table_column ?>,
        "pagingType": "simple_numbers_no_ellipses",
        "language": {
            "processing": '<div class="custom-spinner"></div>'
        },
        "initComplete": function() {
            // Get total records
            var info = table.page.info();
            $('#totalEnquiries').text('Total: ' + info.recordsTotal);
        }
    });

    // ============================================
    // VIEW ENQUIRY
    // ============================================
    $(document).on('click', '.viewEnquiry', function() {
        var data = $(this).data();
        
        $('#viewBookName').text(data.book_name || 'N/A');
        $('#viewName').text(data.name || 'N/A');
        $('#viewEmail').text(data.email || 'N/A');
        $('#viewPhone').text(data.phone || 'N/A');
        $('#viewMessage').text(data.message || 'No message');
        $('#viewCreated').text(data.created || 'N/A');
        
        var status = data.status || 'Pending';
        var statusBadge = '';
        if (status == 'Pending') {
            statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
        } else if (status == 'Contacted') {
            statusBadge = '<span class="badge bg-info">Contacted</span>';
        } else if (status == 'Closed') {
            statusBadge = '<span class="badge bg-success">Closed</span>';
        }
        $('#viewStatus').html(statusBadge);
        
        $('#viewEnquiryModal').modal('show');
    });

    // ============================================
    // UPDATE STATUS - Open Modal
    // ============================================
    $(document).on('click', '.updateStatus', function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        
        $('#statusEnquiryId').val(id);
        $('#statusSelect').val(status);
        $('#updateStatusModal').modal('show');
    });

    // ============================================
    // UPDATE STATUS - Submit
    // ============================================
    $('#updateStatusForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/enquiry-update-status') ?>",
            data: formData,
            dataType: "JSON",
            success: function(response) {
                if (response.status) {
                    $('#updateStatusModal').modal('hide');
                    table.ajax.reload();
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Server error!');
            }
        });
    });

    // ============================================
    // DELETE ENQUIRY
    // ============================================
    $(document).on('click', '.deleteEnquiry', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/enquiry-delete') ?>",
                    data: { enquiry_id: id },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Server error!'
                        });
                    }
                });
            }
        });
    });

    // ============================================
    // TOASTR OPTIONS (Add to header)
    // ============================================
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };
});
</script>