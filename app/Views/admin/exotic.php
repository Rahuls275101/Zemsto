<!-- CONTENT WRAPPER -->
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>All Exotic Collections</h1>
                <p class="breadcrumbs">
                    <span><a href="<?= base_url('admin/dashboard') ?>">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    <span>All Exotic Collections</span>
                </p>
            </div>
            <div>
                <a href="javascript:void(0);" class="btn btn-primary" id="Recordexotic" data-toggle="modal">Add Exotic Collection</a>
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
                                        <th>Photo</th>
                                        <th>Title</th>
                                        <th>Category</th>
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

<!-- Add Modal -->
<div class="modal fade" id="addexotic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Exotic Collection</h5>
                <button type="button" class="close" id="addexoticclose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="Savedexotic" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category Name*</label>
                                    <input type="text" class="form-control" name="category_name" placeholder="Enter category name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title*</label>
                                    <input type="text" class="form-control" name="title" placeholder="Enter title" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description*</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="Enter description" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Main Image*</label>
                                    <input type="file" class="form-control" name="exotic_image" id="main_image_input" accept="image/*" required>
                                    <div id="main_image_preview" class="image-preview-container" style="display:none; margin-top:10px;">
                                        <img id="main_image_preview_img" src="#" alt="Main Image Preview" style="max-width:150px; max-height:150px; border-radius:8px; border:2px solid #ddd; padding:5px;">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeMainImage()" style="margin-top:5px;">
                                            <i class="mdi mdi-close"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gallery Images</label>
                                    <input type="file" class="form-control" name="gallery_images[]" id="gallery_images_input" multiple accept="image/*">
                                    <small class="text-muted">Select multiple images</small>
                                    <div id="gallery_images_preview" class="gallery-preview-container" style="margin-top:10px; display:flex; flex-wrap:wrap; gap:10px;"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status*</label>
                                    <select class="form-control" name="exotic_status" required>
                                        <option>Active</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Hero Card</label>
                                    <select class="form-control" name="is_hero_card">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Wide Card</label>
                                    <select class="form-control" name="is_wide_card">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Layout Type</label>
                                    <select class="form-control" name="layout_type">
                                        <option value="single">Single</option>
                                        <option value="hero">Hero</option>
                                        <option value="two_layout">Two Layout</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Display Order</label>
                                    <input type="number" class="form-control" name="display_order" value="0">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editexotic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Exotic Collection</h5>
                <button type="button" class="close" id="editexoticclose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="Editedexotic" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category Name*</label>
                                    <input type="text" class="form-control" id="edit_category_name" name="edit_category_name" placeholder="Enter category name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title*</label>
                                    <input type="text" class="form-control" id="edit_title" name="edit_title" placeholder="Enter title" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description*</label>
                                    <textarea class="form-control" id="edit_description" name="edit_description" rows="3" placeholder="Enter description" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Main Image</label>
                                    <input type="file" class="form-control" name="edit_exotic_image" id="edit_main_image_input" accept="image/*">
                                    <input type="hidden" class="form-control" id="edit_exotic_image_old" name="edit_exotic_image_old">
                                    <small class="text-muted">Leave blank to keep existing image</small>
                                    <div id="edit_main_image_preview" class="image-preview-container" style="margin-top:10px;">
                                        <img id="edit_main_image_preview_img" src="#" alt="Main Image Preview" style="max-width:150px; max-height:150px; border-radius:8px; border:2px solid #ddd; padding:5px; display:none;">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeEditMainImage()" style="margin-top:5px; display:none;">
                                            <i class="mdi mdi-close"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Gallery Images</label>
                                    <input type="file" class="form-control" name="edit_gallery_images[]" id="edit_gallery_images_input" multiple accept="image/*">
                                    <small class="text-muted">Select multiple images</small>
                                    <div id="edit_gallery_images_preview" class="gallery-preview-container" style="margin-top:10px; display:flex; flex-wrap:wrap; gap:10px;"></div>
                                    <div id="existing_gallery_container" style="margin-top:15px;">
                                        <label>Existing Gallery Images</label>
                                        <div id="existing_gallery_images" style="display:flex; flex-wrap:wrap; gap:10px; margin-top:10px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status*</label>
                                    <select class="form-control" id="edit_exotic_status" name="edit_exotic_status" required>
                                        <option>Active</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Hero Card</label>
                                    <select class="form-control" id="edit_is_hero_card" name="edit_is_hero_card">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Wide Card</label>
                                    <select class="form-control" id="edit_is_wide_card" name="edit_is_wide_card">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Layout Type</label>
                                    <select class="form-control" id="edit_layout_type" name="edit_layout_type">
                                        <option value="single">Single</option>
                                        <option value="hero">Hero</option>
                                        <option value="two_layout">Two Layout</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Display Order</label>
                                    <input type="number" class="form-control" id="edit_display_order" name="edit_display_order" value="0">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" name="edit_exotic_id" id="edit_exotic_id" value="">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .image-preview-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    
    .gallery-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    
    .gallery-preview-item {
        position: relative;
        display: inline-block;
        border: 2px solid #ddd;
        border-radius: 8px;
        padding: 5px;
        background: #fff;
    }
    
    .gallery-preview-item img {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .gallery-preview-item .remove-gallery-image {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 12px;
        line-height: 20px;
        text-align: center;
        cursor: pointer;
        padding: 0;
    }
    
    .gallery-preview-item .remove-gallery-image:hover {
        background: #c82333;
    }
    
    .existing-gallery-item {
        position: relative;
        display: inline-block;
        border: 2px solid #28a745;
        border-radius: 8px;
        padding: 5px;
        background: #f8f9fa;
    }
    
    .existing-gallery-item img {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .existing-gallery-item .delete-existing-image {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 12px;
        line-height: 20px;
        text-align: center;
        cursor: pointer;
        padding: 0;
    }
    
    .existing-gallery-item .delete-existing-image:hover {
        background: #c82333;
    }
    
    .btn-remove-main {
        margin-top: 5px;
    }
</style>

<script>
$(document).ready(function () {
    var table = $('#ajax_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url('admin/exotic-list'); ?>",
            "type": "POST",
            "data": function(data) {
                var fromDate = '';
                data.searchname = fromDate;
                data.id = '';
            }
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
            "processing": '<div class="custom-spinner"></div> '
        },
        "initComplete": function () {
            $('#ajax_table').addClass('custom-datatable');
        },
        "bJQueryUI": false
    });

    // Main Image Preview - Add
    $('#main_image_input').on('change', function() {
        previewMainImage(this, '#main_image_preview', '#main_image_preview_img');
    });

    // Main Image Preview - Edit
    $('#edit_main_image_input').on('change', function() {
        previewMainImage(this, '#edit_main_image_preview', '#edit_main_image_preview_img');
    });

    // Gallery Images Preview - Add
    $('#gallery_images_input').on('change', function() {
        previewGalleryImages(this, '#gallery_images_preview');
    });

    // Gallery Images Preview - Edit
    $('#edit_gallery_images_input').on('change', function() {
        previewGalleryImages(this, '#edit_gallery_images_preview');
    });

    // Preview Main Image Function
    function previewMainImage(input, previewContainer, previewImg) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(previewImg).attr('src', e.target.result).show();
                $(previewContainer).show();
                $(previewImg).siblings('button').show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Preview Gallery Images Function
    function previewGalleryImages(input, previewContainer) {
        $(previewContainer).empty();
        if (input.files) {
            Array.from(input.files).forEach(function(file, index) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var html = `
                        <div class="gallery-preview-item" data-index="${index}">
                            <img src="${e.target.result}" alt="Gallery Image ${index + 1}">
                            <button type="button" class="remove-gallery-image" onclick="removeGalleryImage(this, '${previewContainer}')">×</button>
                        </div>
                    `;
                    $(previewContainer).append(html);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    // Remove Gallery Image Function
    window.removeGalleryImage = function(button, previewContainer) {
        $(button).closest('.gallery-preview-item').remove();
        // Update the input files
        var input = $(previewContainer).closest('.form-group').find('input[type="file"]')[0];
        if (input.files.length > 0) {
            var dt = new DataTransfer();
            var files = Array.from(input.files);
            var index = $(button).closest('.gallery-preview-item').data('index');
            files.splice(index, 1);
            files.forEach(function(file) {
                dt.items.add(file);
            });
            input.files = dt.files;
            // Re-index remaining items
            $(previewContainer).find('.gallery-preview-item').each(function(i) {
                $(this).data('index', i);
            });
        }
    };

    // Remove Main Image Function
    window.removeMainImage = function() {
        $('#main_image_input').val('');
        $('#main_image_preview').hide();
        $('#main_image_preview_img').attr('src', '#').hide();
        $('#main_image_preview_img').siblings('button').hide();
    };

    window.removeEditMainImage = function() {
        $('#edit_main_image_input').val('');
        $('#edit_main_image_preview_img').attr('src', '#').hide();
        $('#edit_main_image_preview_img').siblings('button').hide();
    };

    // Delete Existing Gallery Image
    window.deleteExistingGalleryImage = function(button, imagePath) {
        if (confirm('Are you sure you want to delete this gallery image?')) {
            var exotic_id = $('#edit_exotic_id').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('admin/exotic_delete_gallery_image'); ?>",
                data: { 
                    exotic_id: exotic_id, 
                    image_path: imagePath 
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        $(button).closest('.existing-gallery-item').remove();
                        toastr.success('Image deleted successfully');
                    } else {
                        toastr.error('Failed to delete image');
                    }
                },
                error: function() {
                    toastr.error('Error deleting image');
                }
            });
        }
    };

    // Save Record
    $('#Savedexotic').submit(function(event){
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        $(":submit").attr("disabled", true);
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/exotic_save'); ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(data){
                $('#addexoticclose').click();
                $("#Savedexotic")[0].reset();
                $('#main_image_preview').hide();
                $('#gallery_images_preview').empty();
                $(":submit").attr("disabled", false);
                table.ajax.reload();
                toastr.success('Collection added successfully');
            },
            error: function() {
                $(":submit").attr("disabled", false);
                toastr.error('Error adding collection');
            }
        });
        return false;
    });

    // Update Record
    $('#Editedexotic').submit(function(){
        var formData = new FormData($(this)[0]);
        $(":submit").attr("disabled", true);
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/exotic_update'); ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(data){
                $('#editexoticclose').click();
                $("#Editedexotic")[0].reset();
                $('#edit_gallery_images_preview').empty();
                $(":submit").attr("disabled", false);
                table.ajax.reload();
                toastr.success('Collection updated successfully');
            },
            error: function() {
                $(":submit").attr("disabled", false);
                toastr.error('Error updating collection');
            }
        });
        return false;
    });

    // Edit Record
    $('#ajax_table').on('click','.editRecordexotic',function(){
        $('#editexotic').modal('show');
        $("#edit_exotic_id").val($(this).data('exotic_id'));
        $("#edit_category_name").val($(this).data('category_name'));
        $("#edit_title").val($(this).data('title'));
        $("#edit_description").val($(this).data('description'));
        $("#edit_exotic_status").val($(this).data('exotic_status'));
        $("#edit_exotic_image_old").val($(this).data('exotic_image'));
        $("#edit_is_hero_card").val($(this).data('is_hero_card'));
        $("#edit_is_wide_card").val($(this).data('is_wide_card'));
        $("#edit_layout_type").val($(this).data('layout_type'));
        $("#edit_display_order").val($(this).data('display_order'));
        
        // Show existing main image
        var mainImage = $(this).data('exotic_image');
        if (mainImage) {
            $('#edit_main_image_preview_img').attr('src', '<?= base_url() ?>/assets/exotic/' + mainImage).show();
            $('#edit_main_image_preview_img').siblings('button').show();
        }
        
        // Load existing gallery images
        var exotic_id = $(this).data('exotic_id');
        loadExistingGalleryImages(exotic_id);
    });

    // Load Existing Gallery Images
    function loadExistingGalleryImages(exotic_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/exotic_get_gallery_images'); ?>",
            data: { exotic_id: exotic_id },
            dataType: "JSON",
            success: function(response) {
                if (response.success) {
                    var container = $('#existing_gallery_images');
                    container.empty();
                    if (response.images && response.images.length > 0) {
                        response.images.forEach(function(image) {
                            var html = `
                                <div class="existing-gallery-item">
                                    <img src="<?= base_url() ?>/${image.image_path}" alt="Gallery Image">
                                    <button type="button" class="delete-existing-image" onclick="deleteExistingGalleryImage(this, '${image.image_path}')">×</button>
                                </div>
                            `;
                            container.append(html);
                        });
                    } else {
                        container.html('<p class="text-muted">No gallery images found</p>');
                    }
                }
            }
        });
    }

    // Delete Record
    $('#ajax_table').on('click','.deleteRecordexotic',function(){
        if (confirm('Are you sure you want to delete this record?')) {
            var exotic_id = $(this).data('exotic_id');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('admin/exotic_delete'); ?>",
                data: { exotic_id: exotic_id },
                dataType: "JSON",
                success: function(data){
                    table.ajax.reload();
                    toastr.success('Collection deleted successfully');
                },
                error: function() {
                    toastr.error('Error deleting collection');
                }
            });
        }
    });

    // Add Record Button
    $('#Recordexotic').on('click',function(){
        $('#addexotic').modal('show');
    });
});
</script>