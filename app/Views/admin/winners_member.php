<!-- CONTENT WRAPPER -->
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Winners Member List</h1>
                <p class="breadcrumbs">
                    <span><a href="<?= base_url('admin/dashboard') ?>">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Winners Member
                </p>
            </div>
            <div>
                <a href="javascript:void(0);" class="btn btn-primary" id="addWinnerBtn">
                    <i class="fas fa-plus"></i> Add Winner
                </a>
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
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Year</th>
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

<!-- ============================================ -->
<!-- ADD WINNER MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="addWinnerModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-plus"></i> Add New Winner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addWinnerForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter winner name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter title (e.g., Singing Champion)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category *</label>
                        <select class="form-control" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Singing">Singing</option>
                            <option value="Dancing">Dancing</option>
                            <option value="Fancy Dress">Fancy Dress</option>
                            <option value="Musical Instrument">Musical Instrument</option>
                            <option value="Photography">Photography</option>
                            <option value="Public Speaking">Public Speaking</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year *</label>
                        <select class="form-control" name="year" required>
                            <option value="2025-26">2025-26</option>
                            <option value="2024-25">2024-25</option>
                            <option value="2023-24">2023-24</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small class="text-muted">Supported: JPG, PNG, WEBP</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Winner</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- EDIT WINNER MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="editWinnerModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Winner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editWinnerForm" enctype="multipart/form-data">
                    <input type="hidden" name="edit_winner_id" id="editWinnerId">
                    <input type="hidden" name="edit_existing_image" id="editExistingImage">
                    
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="edit_name" id="editName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" class="form-control" name="edit_title" id="editTitle" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category *</label>
                        <select class="form-control" name="edit_category" id="editCategory" required>
                            <option value="Singing">Singing</option>
                            <option value="Dancing">Dancing</option>
                            <option value="Fancy Dress">Fancy Dress</option>
                            <option value="Musical Instrument">Musical Instrument</option>
                            <option value="Photography">Photography</option>
                            <option value="Public Speaking">Public Speaking</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year *</label>
                        <select class="form-control" name="edit_year" id="editYear" required>
                            <option value="2025-26">2025-26</option>
                            <option value="2024-25">2024-25</option>
                            <option value="2023-24">2023-24</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="edit_status" id="editStatus">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div id="editCurrentImage"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Change Image (Optional)</label>
                        <input type="file" class="form-control" name="edit_image" accept="image/*">
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Winner</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- SCRIPTS -->
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
            "url": "<?= base_url('admin/winners-member-list') ?>",
            "type": "POST"
        },
        "columns": <?= $table_column ?>,
        "pagingType": "simple_numbers_no_ellipses",
        "language": {
            "processing": '<div class="custom-spinner"></div>'
        }
    });

    // ============================================
    // ADD WINNER - Open Modal
    // ============================================
    $('#addWinnerBtn').on('click', function() {
        $('#addWinnerForm')[0].reset();
        $('#addWinnerModal').modal('show');
    });

    // ============================================
    // ADD WINNER - Submit
    // ============================================
    $('#addWinnerForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/winner-member-save') ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(response) {
                if (response.status) {
                    $('#addWinnerModal').modal('hide');
                    $('#addWinnerForm')[0].reset();
                    table.ajax.reload();
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message || 'Something went wrong!');
                    if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            toastr.error(value);
                        });
                    }
                }
            },
            error: function() {
                toastr.error('Server error!');
            }
        });
    });

    // ============================================
    // EDIT WINNER - Load Data
    // ============================================
    $(document).on('click', '.editWinner', function() {
        var data = $(this).data();
        
        $('#editWinnerId').val(data.id);
        $('#editName').val(data.name);
        $('#editTitle').val(data.title);
        $('#editCategory').val(data.category);
        $('#editYear').val(data.year);
        $('#editStatus').val(data.status);
        $('#editExistingImage').val(data.image);
        
        if (data.image) {
            var imgHtml = '<img src="<?= base_url('assets/winners/') ?>' + data.image + '" style="width:80px;height:80px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">';
            $('#editCurrentImage').html(imgHtml);
        } else {
            $('#editCurrentImage').html('<p class="text-muted">No image</p>');
        }
        
        $('#editWinnerModal').modal('show');
    });

    // ============================================
    // EDIT WINNER - Submit
    // ============================================
    $('#editWinnerForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/winner-member-update') ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(response) {
                if (response.status) {
                    $('#editWinnerModal').modal('hide');
                    $('#editWinnerForm')[0].reset();
                    table.ajax.reload();
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message || 'Something went wrong!');
                }
            },
            error: function() {
                toastr.error('Server error!');
            }
        });
    });

    // ============================================
    // DELETE WINNER
    // ============================================
    $(document).on('click', '.deleteWinner', function() {
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
                    url: "<?= base_url('admin/winner-member-delete') ?>",
                    data: { winner_id: id },
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

});
</script>