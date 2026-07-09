<!-- ============================================ -->
<!-- CONTENT WRAPPER -->
<!-- ============================================ -->
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>All Books</h1>
                <p class="breadcrumbs">
                    <span><a href="index.html">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>All Books
                </p>
            </div>
            <div>
                <a href="javascript:void(0);" class="btn btn-primary" id="Recordbook" data-toggle="modal">Add Book</a>
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
                                        <th>Book Name</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Price</th>
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
<!-- ADD BOOK MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="addbook" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Book</h5>
                <button type="button" class="close" id="addbookclose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="Savedbook" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <!-- Book Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Book Name *</label>
                                    <input type="text" class="form-control" name="book_name" placeholder="Enter book name" required>
                                </div>
                            </div>

                            <!-- Class -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Class *</label>
                                    <select class="form-control" name="book_class" required>
                                        <option value="">Select Class</option>
                                        <option value="Class 1">Class 1</option>
                                        <option value="Class 2">Class 2</option>
                                        <option value="Class 3">Class 3</option>
                                        <option value="Class 4">Class 4</option>
                                        <option value="Class 5">Class 5</option>
                                        <option value="Class 6">Class 6</option>
                                        <option value="Class 7">Class 7</option>
                                        <option value="Class 8">Class 8</option>
                                        <option value="Class 9">Class 9</option>
                                        <option value="Class 10">Class 10</option>
                                        <option value="Class 11">Class 11</option>
                                        <option value="Class 12">Class 12</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Subject -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Subject *</label>
                                    <select class="form-control" name="book_subject" required>
                                        <option value="">Select Subject</option>
                                        <option value="Math">Math</option>
                                        <option value="Science">Science</option>
                                        <option value="English">English</option>
                                        <option value="Computer">Computer</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Price (INR) *</label>
                                    <input type="number" class="form-control" name="book_price" placeholder="0.00" required>
                                </div>
                            </div>

                            <!-- Discount Price -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Discount Price (INR)</label>
                                    <input type="number" class="form-control" name="book_discount_price" placeholder="0.00">
                                </div>
                            </div>

                            <!-- Book Type -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Book Type *</label>
                                    <select class="form-control" name="book_type" required>
                                        <option value="Physical Book">Physical Book</option>
                                        <option value="E-Book">E-Book</option>
                                        <option value="Audio Book">Audio Book</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status *</label>
                                    <select class="form-control" name="book_status" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description *</label>
                                    <textarea class="form-control" name="book_description" rows="4" placeholder="Enter book description..." required></textarea>
                                </div>
                            </div>

                            <!-- ============================================ -->
                            <!-- SINGLE IMAGE INPUT -->
                            <!-- ============================================ -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Book Image</label>
                                    <input type="file" class="form-control" name="book_image" accept="image/*">
                                    <small class="text-muted">Supported: JPG, PNG, WEBP, GIF (Max: 2MB)</small>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- EDIT BOOK MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="editbook" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Book</h5>
                <button type="button" class="close" id="editbookclose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="Editedbook" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <!-- Book Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Book Name *</label>
                                    <input type="text" class="form-control" name="edit_book_name" id="edit_bookName" required>
                                </div>
                            </div>

                            <!-- Class -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Class *</label>
                                    <select class="form-control" name="edit_book_class" id="edit_bookClass" required>
                                        <option value="Class 1">Class 1</option>
                                        <option value="Class 2">Class 2</option>
                                        <option value="Class 3">Class 3</option>
                                        <option value="Class 4">Class 4</option>
                                        <option value="Class 5">Class 5</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Subject -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Subject *</label>
                                    <select class="form-control" name="edit_book_subject" id="edit_bookSubject" required>
                                        <option value="Math">Math</option>
                                        <option value="Science">Science</option>
                                        <option value="English">English</option>
                                        <option value="Computer">Computer</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Price (INR) *</label>
                                    <input type="number" class="form-control" name="edit_book_price" id="edit_bookPrice" required>
                                </div>
                            </div>

                            <!-- Discount Price -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Discount Price (INR)</label>
                                    <input type="number" class="form-control" name="edit_book_discount_price" id="edit_bookDiscountPrice">
                                </div>
                            </div>

                            <!-- Book Type -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Book Type *</label>
                                    <select class="form-control" name="edit_book_type" id="edit_bookType" required>
                                        <option value="Physical Book">Physical Book</option>
                                        <option value="E-Book">E-Book</option>
                                        <option value="Audio Book">Audio Book</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status *</label>
                                    <select class="form-control" name="edit_book_status" id="edit_bookStatus" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description *</label>
                                    <textarea class="form-control" name="edit_book_description" id="edit_bookDescription" rows="4" required></textarea>
                                </div>
                            </div>

                            <!-- Current Image -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Current Image</label>
                                    <div id="edit_current_image"></div>
                                </div>
                            </div>

                            <!-- New Image -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Change Image (Optional)</label>
                                    <input type="file" class="form-control" name="edit_book_image" accept="image/*">
                                    <small class="text-muted">Leave empty to keep current image</small>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <input type="hidden" name="edit_book_id" id="edit_bookID">
                                <input type="hidden" name="edit_existing_image" id="edit_existingImage">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
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
            "url": "<?php echo base_url('admin/book-list'); ?>",
            "type": "POST"
        },
        "columns": <?= $table_column ?>,
        "pagingType": "simple_numbers_no_ellipses",
        "language": {
            "processing": '<div class="custom-spinner"></div>'
        }
    });

    // ============================================
    // SAVE BOOK
    // ============================================
    $('#Savedbook').submit(function(event) {
        event.preventDefault();
        
        var formData = new FormData($(this)[0]);
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/book_save'); ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(response) {
                if (response.status) {
                    $('#addbook').modal('hide');
                    $('#Savedbook')[0].reset();
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
        return false;
    });

    // ============================================
    // UPDATE BOOK
    // ============================================
    $('#Editedbook').submit(function(event) {
        event.preventDefault();
        
        var formData = new FormData($(this)[0]);
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/book_update'); ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(response) {
                if (response.status) {
                    $('#editbook').modal('hide');
                    $('#Editedbook')[0].reset();
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
        return false;
    });

    // ============================================
    // EDIT BUTTON - Load Data
    // ============================================
    $('#ajax_table').on('click', '.editRecordbook', function() {
        $('#editbook').modal('show');
        
        $("#edit_bookID").val($(this).data('book_id'));
        $("#edit_bookName").val($(this).data('book_name'));
        $("#edit_bookClass").val($(this).data('book_class'));
        $("#edit_bookSubject").val($(this).data('book_subject'));
        $("#edit_bookPrice").val($(this).data('book_price'));
        $("#edit_bookDiscountPrice").val($(this).data('book_discount_price'));
        $("#edit_bookType").val($(this).data('book_type'));
        $("#edit_bookStatus").val($(this).data('book_status'));
        $("#edit_bookDescription").val($(this).data('book_description'));
        
        var image = $(this).data('book_image');
        $("#edit_existingImage").val(image);
        
        if (image) {
            var imgHtml = '<img src="<?php echo base_url('assets/books/'); ?>' + image + '" style="width:100px;height:100px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">';
            $('#edit_current_image').html(imgHtml);
        } else {
            $('#edit_current_image').html('<p class="text-muted">No image uploaded</p>');
        }
    });

    // ============================================
    // DELETE BOOK
    // ============================================
    $(document).on('click', '.deleteRecordbook', function() {
        var bookId = $(this).data('book_id');
        
        if (confirm('Are you sure you want to delete this book?')) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('admin/book_delete'); ?>",
                data: { book_id: bookId },
                dataType: "JSON",
                success: function(response) {
                    if (response.status) {
                        table.ajax.reload();
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        }
    });

    // ============================================
    // OPEN ADD MODAL
    // ============================================
    $('#Recordbook').on('click', function() {
        $('#addbook').modal('show');
    });
});
</script>