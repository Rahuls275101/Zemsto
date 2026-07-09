<!-- olympiads.php -->
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Olympiad Management</h1>
                <p class="breadcrumbs">
                    <span><a href="#">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Olympiads
                </p>
            </div>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOlympiadModal">
                    <i class="mdi mdi-plus"></i> Add New Olympiad
                </button>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="ec-cat-list card card-default">
                    <?php if(session()->getFlashdata('failed')): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <?php 
                                $errors = session()->getFlashdata('failed');
                                if(is_array($errors)) {
                                    foreach($errors as $error) {
                                        echo $error . '<br>';
                                    }
                                } else {
                                    echo $errors;
                                }
                            ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if(session()->getFlashdata('created')): ?>
                        <div class="alert alert-success alert-dismissable">
                            <?= session()->getFlashdata('created') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="olympiad_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#S.No</th>
                                        <th>Image</th>
                                        <th>Icon</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Indian Price</th>
                                        <th>International Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- ADD OLYMPIAD MODAL -->
<!-- ============================================================ -->
<div class="modal fade" id="addOlympiadModal" tabindex="-1" aria-labelledby="addOlympiadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="<?php echo base_url('admin/add_olympiad'); ?>" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOlympiadModalLabel"><i class="mdi mdi-plus-circle"></i> Add New Olympiad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="add_title">Title *</label>
                                <input type="text" class="form-control" id="add_title" name="title" required placeholder="Enter olympiad title">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="add_description">Description *</label>
                                <textarea class="form-control" id="add_description" name="description" rows="4" required placeholder="Enter description"></textarea>
                            </div>
                        </div>
                        
                        <!-- Price Section -->
                        <div class="col-md-12">
                            <h6 class="mt-2"><i class="mdi mdi-currency-inr"></i> Pricing Information</h6>
                            <hr>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_price_indian">Indian Price (₹) *</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" step="0.01" class="form-control" id="add_price_indian" name="price_indian" required placeholder="e.g. 499.00">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_price_international">International Price ($) *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control" id="add_price_international" name="price_international" required placeholder="e.g. 19.99">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_currency_indian">Indian Currency Symbol</label>
                                <input type="text" class="form-control" id="add_currency_indian" name="currency_indian" value="₹" placeholder="₹">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_currency_international">International Currency Symbol</label>
                                <input type="text" class="form-control" id="add_currency_international" name="currency_international" value="$" placeholder="$">
                            </div>
                        </div>
                        
                        <!-- Images Section -->
                        <div class="col-md-12">
                            <h6 class="mt-3"><i class="mdi mdi-image"></i> Images</h6>
                            <hr>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="add_image">Image *</label>
                                <input type="file" class="form-control" id="add_image" name="image" accept="image/*" required>
                                <small class="text-muted">Max size: 2MB (JPG, PNG, GIF)</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="add_icon">Icon *</label>
                                <input type="file" class="form-control" id="add_icon" name="icon" accept="image/*" required>
                                <small class="text-muted">Max size: 1MB (SVG, PNG)</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="add_icon_bg">Icon Background *</label>
                                <input type="file" class="form-control" id="add_icon_bg" name="icon_bg" accept="image/*" required>
                                <small class="text-muted">Max size: 1MB (PNG, JPG)</small>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="add_status">Status</label>
                                <select class="form-control" id="add_status" name="status">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-check"></i> Add Olympiad</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- EDIT OLYMPIAD MODAL -->
<!-- ============================================================ -->
<div class="modal fade" id="editOlympiadModal" tabindex="-1" aria-labelledby="editOlympiadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="<?php echo base_url('admin/update_olympiad'); ?>" enctype="multipart/form-data">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOlympiadModalLabel"><i class="mdi mdi-pencil"></i> Edit Olympiad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_title">Title *</label>
                                <input type="text" class="form-control" id="edit_title" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_description">Description *</label>
                                <textarea class="form-control" id="edit_description" name="description" rows="4" required></textarea>
                            </div>
                        </div>
                        
                        <!-- Price Section -->
                        <div class="col-md-12">
                            <h6 class="mt-2"><i class="mdi mdi-currency-inr"></i> Pricing Information</h6>
                            <hr>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_price_indian">Indian Price (₹) *</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" step="0.01" class="form-control" id="edit_price_indian" name="price_indian" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_price_international">International Price ($) *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control" id="edit_price_international" name="price_international" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_currency_indian">Indian Currency Symbol</label>
                                <input type="text" class="form-control" id="edit_currency_indian" name="currency_indian" value="₹">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_currency_international">International Currency Symbol</label>
                                <input type="text" class="form-control" id="edit_currency_international" name="currency_international" value="$">
                            </div>
                        </div>
                        
                        <!-- Images Section -->
                        <div class="col-md-12">
                            <h6 class="mt-3"><i class="mdi mdi-image"></i> Images</h6>
                            <hr>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_image">Image</label>
                                <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                                <small class="text-muted">Leave empty to keep current</small>
                                <div id="current_image_preview" class="mt-2"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_icon">Icon</label>
                                <input type="file" class="form-control" id="edit_icon" name="icon" accept="image/*">
                                <small class="text-muted">Leave empty to keep current</small>
                                <div id="current_icon_preview" class="mt-2"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_icon_bg">Icon Background</label>
                                <input type="file" class="form-control" id="edit_icon_bg" name="icon_bg" accept="image/*">
                                <small class="text-muted">Leave empty to keep current</small>
                                <div id="current_icon_bg_preview" class="mt-2"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_status">Status</label>
                                <select class="form-control" id="edit_status" name="status">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-check"></i> Update Olympiad</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- JAVASCRIPT -->
<!-- ============================================================ -->
<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#olympiad_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url('admin/olympiad_list'); ?>",
            "type": "POST"
        },
        "columns": <?= $table_column ?>,
        "pagingType": "simple_numbers_no_ellipses",
        "oLanguage": {
            "oPaginate": {
                "sFirst": "First",
                "sPrevious": "Previous",
                "sNext": "Next"
            }
        },
        "language": {
            "processing": '<div class="custom-spinner"></div>'
        },
        "bJQueryUI": false,
        "dom": '<"top"lB>frtip',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-primary',
                title: 'olympiads_' + new Date().toLocaleDateString(),
            }
        ]
    });

    // Edit button click
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        var title = $(this).data('title');
        var description = $(this).data('description');
        var status = $(this).data('status');
        var image = $(this).data('image');
        var icon = $(this).data('icon');
        var icon_bg = $(this).data('icon_bg');
        var price_indian = $(this).data('price_indian');
        var price_international = $(this).data('price_international');
        var currency_indian = $(this).data('currency_indian');
        var currency_international = $(this).data('currency_international');
        
        $('#edit_id').val(id);
        $('#edit_title').val(title);
        $('#edit_description').val(description);
        $('#edit_status').val(status);
        $('#edit_price_indian').val(price_indian);
        $('#edit_price_international').val(price_international);
        $('#edit_currency_indian').val(currency_indian || '₹');
        $('#edit_currency_international').val(currency_international || '$');
        
        // Show current images
        if(image) {
            $('#current_image_preview').html('<img src="<?php echo base_url('uploads/olympiads/images/'); ?>/' + image + '" style="max-height:80px; margin-top:10px; border:1px solid #ddd; padding:5px; border-radius:5px;">');
        } else {
            $('#current_image_preview').html('<span class="text-muted">No image</span>');
        }
        
        if(icon) {
            $('#current_icon_preview').html('<img src="<?php echo base_url('uploads/olympiads/icons/'); ?>/' + icon + '" style="max-height:80px; margin-top:10px; border:1px solid #ddd; padding:5px; border-radius:5px;">');
        } else {
            $('#current_icon_preview').html('<span class="text-muted">No icon</span>');
        }
        
        if(icon_bg) {
            $('#current_icon_bg_preview').html('<img src="<?php echo base_url('uploads/olympiads/icon_bg/'); ?>/' + icon_bg + '" style="max-height:80px; margin-top:10px; border:1px solid #ddd; padding:5px; border-radius:5px;">');
        } else {
            $('#current_icon_bg_preview').html('<span class="text-muted">No background</span>');
        }
        
        $('#editOlympiadModal').modal('show');
    });

    // Delete button click
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        
        if(confirm('Are you sure you want to delete this olympiad?')) {
            $.ajax({
                url: '<?php echo base_url('admin/delete_olympiad'); ?>',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        table.ajax.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('Failed to delete olympiad.');
                }
            });
        }
    });

    // Auto-close alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>

<style>
.custom-spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 0 auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.table td {
    vertical-align: middle;
}

.modal-lg {
    max-width: 800px;
}

.input-group-text {
    background: #f8f9fc;
    font-weight: 600;
}

.alert {
    margin: 15px 15px 0 15px;
}
</style>