<!-- CONTENT WRAPPER -->
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>All Our Team</h1>
                <p class="breadcrumbs">
                    <span><a href="<?= base_url('admin/dashboard') ?>">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>All Our Team
                </p>
            </div>
            <div>
                <a href="javascript:void(0);" class="btn btn-primary" id="Recordteacher" data-toggle="modal">Add Teacher</a>
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
                                        <th>Name</th>
                                        <th>Position</th>
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

<!-- Add Teacher Modal -->
<div class="modal fade" id="addteacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Teacher</h5>
                <button type="button" class="close" id="addteacherclose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="Savedteacher" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Teacher Name *</label>
                                    <input type="text" class="form-control" name="teacher_name" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Position *</label>
                                    <input type="text" class="form-control" name="teacher_position" placeholder="e.g. Online Teacher" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status *</label>
                                    <select class="form-control" name="teacher_status" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Profile Image *</label>
                                    <input type="file" class="form-control" name="teacher_image" accept="image/*" required>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <hr>
                                <h6>Social Media Links</h6>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><i class="fab fa-facebook-f text-primary"></i> Facebook</label>
                                    <input type="text" class="form-control" name="teacher_facebook" placeholder="Facebook URL">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><i class="fab fa-instagram text-danger"></i> Instagram</label>
                                    <input type="text" class="form-control" name="teacher_instagram" placeholder="Instagram URL">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><i class="fab fa-linkedin-in text-info"></i> LinkedIn</label>
                                    <input type="text" class="form-control" name="teacher_linkedin" placeholder="LinkedIn URL">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><i class="fab fa-twitter text-primary"></i> Twitter</label>
                                    <input type="text" class="form-control" name="teacher_twitter" placeholder="Twitter URL">
                                </div>
                            </div>
                            
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary">Save Teacher</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Teacher Modal -->
<div class="modal fade" id="editteacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Teacher</h5>
                <button type="button" class="close" id="editteacherclose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="Editedteacher" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Teacher Name *</label>
                                    <input type="text" class="form-control" name="edit_teacher_name" id="edit_teacherName" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Position *</label>
                                    <input type="text" class="form-control" name="edit_teacher_position" id="edit_teacherPosition" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status *</label>
                                    <select class="form-control" id="edit_teacherStatus" name="edit_teacher_status" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Profile Image</label>
                                    <input type="file" class="form-control" name="edit_teacher_image" accept="image/*">
                                    <input type="hidden" name="edit_teacher_image_old" id="edit_teacherImage">
                                    <small class="text-muted">Leave blank to keep current image</small>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <hr>
                                <h6>Social Media Links</h6>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><i class="fab fa-facebook-f text-primary"></i> Facebook</label>
                                    <input type="text" class="form-control" name="edit_teacher_facebook" id="edit_teacherFacebook" placeholder="Facebook URL">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><i class="fab fa-instagram text-danger"></i> Instagram</label>
                                    <input type="text" class="form-control" name="edit_teacher_instagram" id="edit_teacherInstagram" placeholder="Instagram URL">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><i class="fab fa-linkedin-in text-info"></i> LinkedIn</label>
                                    <input type="text" class="form-control" name="edit_teacher_linkedin" id="edit_teacherLinkedin" placeholder="LinkedIn URL">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><i class="fab fa-twitter text-primary"></i> Twitter</label>
                                    <input type="text" class="form-control" name="edit_teacher_twitter" id="edit_teacherTwitter" placeholder="Twitter URL">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <input type="hidden" name="edit_teacher_id" id="edit_teacherID">
                            </div>
                            
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary">Update Teacher</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this teacher? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var table = $('#ajax_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?= base_url('admin/teacher-list') ?>",
            "type": "POST",
            "data": function(data) {
                data.searchname = '';
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
            "processing": '<div class="custom-spinner"></div>'
        },
        "initComplete": function() {
            $('#ajax_table').addClass('custom-datatable');
        }
    });
    
    // Save Teacher
    $('#Savedteacher').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        $(":submit").attr("disabled", true);
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/teacher_save') ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(data) {
                $('#addteacherclose').click();
                $("#Savedteacher")[0].reset();
                $(":submit").attr("disabled", false);
                table.ajax.reload();
                Swal.fire('Success!', 'Teacher added successfully!', 'success');
            },
            error: function() {
                $(":submit").attr("disabled", false);
                Swal.fire('Error!', 'Something went wrong!', 'error');
            }
        });
        return false;
    });
    
    // Update Teacher
    $('#Editedteacher').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        $(":submit").attr("disabled", true);
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/teacher_update') ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(data) {
                $('#editteacher').modal('hide');
                $("#Editedteacher")[0].reset();
                $(":submit").attr("disabled", false);
                table.ajax.reload();
                Swal.fire('Success!', 'Teacher updated successfully!', 'success');
            },
            error: function() {
                $(":submit").attr("disabled", false);
                Swal.fire('Error!', 'Something went wrong!', 'error');
            }
        });
        return false;
    });
    
    // Edit Record - Populate Modal
    $('#ajax_table').on('click', '.editRecordteacher', function() {
        $('#editteacher').modal('show');
        $("#edit_teacherID").val($(this).data('teacher_id'));
        $("#edit_teacherName").val($(this).data('teacher_name'));
        $("#edit_teacherPosition").val($(this).data('teacher_position'));
        $("#edit_teacherStatus").val($(this).data('teacher_status'));
        $("#edit_teacherImage").val($(this).data('teacher_image'));
        $("#edit_teacherFacebook").val($(this).data('teacher_facebook') || '');
        $("#edit_teacherInstagram").val($(this).data('teacher_instagram') || '');
        $("#edit_teacherLinkedin").val($(this).data('teacher_linkedin') || '');
        $("#edit_teacherTwitter").val($(this).data('teacher_twitter') || '');
    });
    
    // Open Add Modal
    $('#Recordteacher').on('click', function() {
        $('#addteacher').modal('show');
    });
    
    // Delete Record
    var deleteId = null;
    $('#ajax_table').on('click', '.deleteRecord', function() {
        deleteId = $(this).data('id');
        $('#deleteModal').modal('show');
    });
    
    $('#confirmDelete').on('click', function() {
        if (deleteId) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('admin/teacher_delete') ?>",
                dataType: "JSON",
                data: { id: deleteId },
                success: function(data) {
                    $('#deleteModal').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Deleted!', 'Teacher deleted successfully!', 'success');
                },
                error: function() {
                    Swal.fire('Error!', 'Something went wrong!', 'error');
                }
            });
        }
    });
});
</script>

<style>
.custom-spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    animation: spin 1s linear infinite;
    margin: 0 auto;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.cat-thumb {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 50%;
}
</style>