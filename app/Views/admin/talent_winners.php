<!-- CONTENT WRAPPER -->
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Kids Talent Show Winners</h1>
                <p class="breadcrumbs">
                    <span><a href="<?= base_url('admin/dashboard') ?>">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Talent Winners
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
                                        <th>Rank</th>
                                        <th>Score</th>
                                        <th>School</th>
                                        <th>City/State</th>
                                        <th>Category</th>
                                        <th>Position</th>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-plus"></i> Add New Talent Winner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addWinnerForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter winner name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rank *</label>
                                <select class="form-control" name="rank" required>
                                    <option value="">Select Rank</option>
                                    <option value="1st">🥇 1st</option>
                                    <option value="2nd">🥈 2nd</option>
                                    <option value="3rd">🥉 3rd</option>
                                    <option value="4th">4th</option>
                                    <option value="5th">5th</option>
                                    <option value="6th">6th</option>
                                    <option value="7th">7th</option>
                                    <option value="8th">8th</option>
                                    <option value="9th">9th</option>
                                    <option value="10th">10th</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Score</label>
                                <input type="number" class="form-control" name="score" placeholder="Enter score (e.g., 95.5)" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">School *</label>
                                <input type="text" class="form-control" name="school" placeholder="Enter school name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">City *</label>
                                <input type="text" class="form-control" name="city" placeholder="Enter city" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">State *</label>
                                <input type="text" class="form-control" name="state" placeholder="Enter state" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category *</label>
                                <select class="form-control" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="Dancing">💃 Dancing</option>
                                    <option value="Singing">🎤 Singing</option>
                                    <option value="Fancy Dress">🎭 Fancy Dress</option>
                                    <option value="Musical Instrument">🎵 Musical Instrument</option>
                                    <option value="Photography">📸 Photography</option>
                                    <option value="Public Speaking">🎙️ Public Speaking</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Position *</label>
                                <select class="form-control" name="position" required>
                                    <option value="Winner">🏆 Winner</option>
                                    <option value="Runner Up">🥈 Runner Up</option>
                                    <option value="Second Runner Up">🥉 Second Runner Up</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Year *</label>
                                <select class="form-control" name="year" required>
                                    <option value="2025-26">2025-26</option>
                                    <option value="2024-25">2024-25</option>
                                    <option value="2023-24">2023-24</option>
                                    <option value="2022-23">2022-23</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small class="text-muted">Supported: JPG, PNG, WEBP (Max: 2MB)</small>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Talent Winner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editWinnerForm" enctype="multipart/form-data">
                    <input type="hidden" name="edit_id" id="editId">
                    <input type="hidden" name="edit_existing_image" id="editExistingImage">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" class="form-control" name="edit_name" id="editName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rank *</label>
                                <select class="form-control" name="edit_rank" id="editRank" required>
                                    <option value="1st">🥇 1st</option>
                                    <option value="2nd">🥈 2nd</option>
                                    <option value="3rd">🥉 3rd</option>
                                    <option value="4th">4th</option>
                                    <option value="5th">5th</option>
                                    <option value="6th">6th</option>
                                    <option value="7th">7th</option>
                                    <option value="8th">8th</option>
                                    <option value="9th">9th</option>
                                    <option value="10th">10th</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Score</label>
                                <input type="number" class="form-control" name="edit_score" id="editScore" placeholder="Enter score" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">School *</label>
                                <input type="text" class="form-control" name="edit_school" id="editSchool" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">City *</label>
                                <input type="text" class="form-control" name="edit_city" id="editCity" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">State *</label>
                                <input type="text" class="form-control" name="edit_state" id="editState" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category *</label>
                                <select class="form-control" name="edit_category" id="editCategory" required>
                                    <option value="Dancing">💃 Dancing</option>
                                    <option value="Singing">🎤 Singing</option>
                                    <option value="Fancy Dress">🎭 Fancy Dress</option>
                                    <option value="Musical Instrument">🎵 Musical Instrument</option>
                                    <option value="Photography">📸 Photography</option>
                                    <option value="Public Speaking">🎙️ Public Speaking</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Position *</label>
                                <select class="form-control" name="edit_position" id="editPosition" required>
                                    <option value="Winner">🏆 Winner</option>
                                    <option value="Runner Up">🥈 Runner Up</option>
                                    <option value="Second Runner Up">🥉 Second Runner Up</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Year *</label>
                                <select class="form-control" name="edit_year" id="editYear" required>
                                    <option value="2025-26">2025-26</option>
                                    <option value="2024-25">2024-25</option>
                                    <option value="2023-24">2023-24</option>
                                    <option value="2022-23">2022-23</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="edit_status" id="editStatus">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
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
<!-- VIEW WINNER MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="viewWinnerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #003b8e 0%, #0055b8 100%); color: white;">
                <h5 class="modal-title"><i class="fas fa-trophy"></i> Winner Details</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="winnerDetails">
                <!-- Winner details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
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
            "url": "<?= base_url('admin/talent-winners-list') ?>",
            "type": "POST"
        },
        "columns": <?= $table_column ?>,
        "pagingType": "simple_numbers_no_ellipses",
        "language": {
            "processing": '<div class="custom-spinner"></div>'
        },
        "order": [[0, 'desc']]
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
            url: "<?= base_url('admin/talent-winner-save') ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(response) {
                if (response.status) {
                    $('#addWinnerModal').modal('hide');
                    $('#addWinnerForm')[0].reset();
                    table.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Something went wrong!'
                    });
                    if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            toastr.error(value);
                        });
                    }
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
    });

    // ============================================
    // EDIT WINNER - Load Data
    // ============================================
    $(document).on('click', '.editWinner', function() {
        var data = $(this).data();
        
        $('#editId').val(data.id);
        $('#editName').val(data.name);
        $('#editRank').val(data.rank);
        $('#editScore').val(data.score);
        $('#editSchool').val(data.school);
        $('#editCity').val(data.city);
        $('#editState').val(data.state);
        $('#editCategory').val(data.category);
        $('#editPosition').val(data.position);
        $('#editYear').val(data.year);
        $('#editStatus').val(data.status);
        $('#editExistingImage').val(data.image);
        
        if (data.image) {
            var imgHtml = '<img src="<?= base_url('assets/talent/') ?>' + data.image + '" style="width:80px;height:80px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">';
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
            url: "<?= base_url('admin/talent-winner-update') ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(response) {
                if (response.status) {
                    $('#editWinnerModal').modal('hide');
                    $('#editWinnerForm')[0].reset();
                    table.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Something went wrong!'
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
    });

    // ============================================
    // VIEW WINNER - Details
    // ============================================
    $(document).on('click', '.view-winner', function() {
        var id = $(this).data('id');
        
        $('#winnerDetails').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-3">Loading winner details...</p>
            </div>
        `);
        
        $.ajax({
            type: "GET",
            url: "<?= base_url('admin/get-winner-details/') ?>/" + id,
            dataType: "JSON",
            success: function(response) {
                if (response.status) {
                    var data = response.data;
                    
                    var rankEmoji = '';
                    if (data.rank == '1st') rankEmoji = '🥇';
                    else if (data.rank == '2nd') rankEmoji = '🥈';
                    else if (data.rank == '3rd') rankEmoji = '🥉';
                    
                    var html = `
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="<?= base_url('assets/talent/') ?>${data.image || 'default-user.png'}" 
                                     style="width:150px;height:150px;object-fit:cover;border-radius:50%;border:4px solid #003b8e;">
                                <h4 class="mt-3">${data.name}</h4>
                                <span class="badge bg-primary">${data.category}</span>
                                <span class="badge bg-warning text-dark">${data.position}</span>
                            </div>
                            <div class="col-md-8">
                                <div class="info-card">
                                    <h6><i class="fas fa-info-circle"></i> Details</h6>
                                    <div class="info-row">
                                        <span class="info-label">Rank</span>
                                        <span class="info-value">${rankEmoji} ${data.rank}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Score</span>
                                        <span class="info-value">${data.score || '-'}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">School</span>
                                        <span class="info-value">${data.school}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">City</span>
                                        <span class="info-value">${data.city}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">State</span>
                                        <span class="info-value">${data.state}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Year</span>
                                        <span class="info-value">${data.year}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Status</span>
                                        <span class="info-value">
                                            <span class="badge ${data.status == 'Active' ? 'bg-success' : 'bg-danger'}">
                                                ${data.status}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $('#winnerDetails').html(html);
                    $('#viewWinnerModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Winner not found!'
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
    });

    // ============================================
    // TOGGLE STATUS
    // ============================================
    $(document).on('click', '.toggle-status', function() {
        var id = $(this).data('id');
        var currentStatus = $(this).data('status');
        
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to change status to ${currentStatus == 'Active' ? 'Inactive' : 'Active'}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/toggle-status') ?>",
                    data: {
                        id: id,
                        status: currentStatus
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
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
                    url: "<?= base_url('admin/talent-winner-delete') ?>",
                    data: { id: id },
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

<style>
.info-card {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border-left: 4px solid #003b8e;
}

.info-card h6 {
    color: #003b8e;
    font-weight: 700;
    margin-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 10px;
}

.info-row {
    display: flex;
    padding: 8px 0;
    border-bottom: 1px solid #f5f5f5;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    width: 120px;
    color: #555;
    flex-shrink: 0;
}

.info-value {
    color: #333;
    flex: 1;
}

.custom-spinner {
    display: inline-block;
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #003b8e;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>