<!-- CONTENT WRAPPER -->
<div class="ec-content-wrapper">
    <div class="content">
        <!-- Breadcrumb -->
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>All Syllabus & Practice</h1>
                <p class="breadcrumbs">
                    <span><a href="index.html">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>
                    All Syllabus
                </p>
            </div>
            <div>
                <a href="javascript:void(0);" class="btn btn-primary" id="RecordSyllabus" data-toggle="modal">
                    <i class="fas fa-plus"></i> Add Syllabus
                </a>
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
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Image</th>
                                        <th>PDF</th>
                                        <th>Questions</th>
                                        <th>Description</th>
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
<!-- ADD SYLLABUS MODAL -->
<!-- ============================================================ -->
<div class="modal fade" id="addSyllabus" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel"><i class="fas fa-plus-circle text-primary"></i> Create New Syllabus</h5>
                <button type="button" class="close" id="addSyllabusClose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="SaveSyllabus" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Class Name *</label>
                                    <select class="form-control" name="class_name" required>
                                        <option value="">-- Select Class --</option>
                                        <option value="Nursery">Nursery</option>
                                        <option value="LKG">LKG</option>
                                        <option value="UKG">UKG</option>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subject Name *</label>
                                    <input type="text" class="form-control" name="subject_name" placeholder="e.g. English, Mathematics" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description *</label>
                                    <textarea class="form-control" name="description" rows="2" placeholder="Short description..." required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subject Image *</label>
                                    <input type="file" class="form-control" name="subject_image" accept="image/*" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PDF File *</label>
                                    <input type="file" class="form-control" name="pdf_file" accept=".pdf" required>
                                    <small class="text-muted">Only PDF files allowed (Max 5MB)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status *</label>
                                    <select class="form-control" name="status" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Syllabus</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- EDIT SYLLABUS MODAL -->
<!-- ============================================================ -->
<div class="modal fade" id="editSyllabus" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"><i class="fas fa-edit text-warning"></i> Update Syllabus</h5>
                <button type="button" class="close" id="editSyllabusClose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="UpdateSyllabus" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Class Name *</label>
                                    <select class="form-control" id="edit_class_name" name="edit_class_name" required>
                                        <option value="Nursery">Nursery</option>
                                        <option value="LKG">LKG</option>
                                        <option value="UKG">UKG</option>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subject Name *</label>
                                    <input type="text" class="form-control" id="edit_subject_name" name="edit_subject_name" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description *</label>
                                    <textarea class="form-control" id="edit_description" name="edit_description" rows="2" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subject Image</label>
                                    <input type="file" class="form-control" name="edit_subject_image" accept="image/*">
                                    <input type="hidden" name="edit_subject_image_old" id="edit_subject_image_old">
                                    <small class="text-muted">Leave blank to keep current image</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PDF File</label>
                                    <input type="file" class="form-control" name="edit_pdf_file" accept=".pdf">
                                    <input type="hidden" name="edit_pdf_file_old" id="edit_pdf_file_old">
                                    <small class="text-muted">Leave blank to keep current PDF</small>
                                    <div id="current_pdf_display" class="mt-1"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status *</label>
                                    <select class="form-control" id="edit_status" name="edit_status" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <input type="hidden" name="edit_syllabus_id" id="edit_syllabus_id" value="">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Update</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- QUESTIONS MODAL -->
<!-- ============================================================ -->
<div class="modal fade" id="questionsModal" tabindex="-1" role="dialog" aria-labelledby="questionsModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff;">
                <h5 class="modal-title" id="questionsModalLabel"><i class="fas fa-question-circle"></i> Manage Questions</h5>
                <button type="button" class="close text-white" id="questionsModalClose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> <strong>Syllabus:</strong> <span id="q_syllabus_name"></span>
                            <input type="hidden" id="q_syllabus_id" value="">
                        </div>
                    </div>
                </div>

                <!-- Add Question Form -->
                <div class="card card-default mb-4">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-plus-circle text-success"></i> Add New Question</h5>
                    </div>
                    <div class="card-body">
                        <form id="AddQuestionForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Question Text *</label>
                                        <input type="text" class="form-control" name="question_text" placeholder="Enter question..." required>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="border p-3 rounded" style="background: #f8f9fc;">
                            
                                        <div class="form-group question-image" >
                                            <label>Image *</label>
                                            <input type="file" class="form-control" name="question_image" accept="image/*">
                                        </div>
                                    </div>
                                </div>

                                <!-- Option A -->
                                <div class="col-md-6">
                                    <div class="border p-3 rounded" style="background: #f8f9fc;">
                                        <h6><span class="badge bg-primary">Option A</span></h6>
                                        <div class="form-group">
                                            <label>Option Type *</label>
                                            <select class="form-control option-type" name="option_a_type" data-option="A" required>
                                                <option value="text">Text</option>
                                                <option value="image">Image</option>
                                            </select>
                                        </div>
                                        <div class="form-group option-a-text">
                                            <label>Text *</label>
                                            <input type="text" class="form-control" name="option_a_text" placeholder="Enter option text...">
                                        </div>
                                        <div class="form-group option-a-image" style="display:none;">
                                            <label>Image *</label>
                                            <input type="file" class="form-control" name="option_a_image" accept="image/*">
                                        </div>
                                    </div>
                                </div>

                                <!-- Option B -->
                                <div class="col-md-6">
                                    <div class="border p-3 rounded" style="background: #f8f9fc;">
                                        <h6><span class="badge bg-danger">Option B</span></h6>
                                        <div class="form-group">
                                            <label>Option Type *</label>
                                            <select class="form-control option-type" name="option_b_type" data-option="B" required>
                                                <option value="text">Text</option>
                                                <option value="image">Image</option>
                                            </select>
                                        </div>
                                        <div class="form-group option-b-text">
                                            <label>Text *</label>
                                            <input type="text" class="form-control" name="option_b_text" placeholder="Enter option text...">
                                        </div>
                                        <div class="form-group option-b-image" style="display:none;">
                                            <label>Image *</label>
                                            <input type="file" class="form-control" name="option_b_image" accept="image/*">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Correct Answer *</label>
                                        <select class="form-control" name="correct_answer" required>
                                            <option value="A">Option A</option>
                                            <option value="B">Option B</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="question_status">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Add Question</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Questions List -->
                <div class="card card-default">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-list"></i> Questions List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="questions_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Question</th>
                                        <th>Option A</th>
                                        <th>Option B</th>
                                        <th>Correct</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="questions_list_body">
                                    <tr><td colspan="7" class="text-center text-muted">No questions added yet.</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- EDIT QUESTION MODAL -->
<!-- ============================================================ -->
<div class="modal fade" id="editQuestionModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #f0ad4e, #d9534f); color: #fff;">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Question</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="EditQuestionForm" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="edit_question_id" id="edit_question_id">
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Question Text *</label>
                                <input type="text" class="form-control" id="edit_question_text" name="edit_question_text" required>
                            </div>
                        </div>
                        
                            <div class="col-md-12">
                                    <div class="border p-3 rounded" style="background: #f8f9fc;">
                            
                                        <div class="form-group question-image" >
                                            <label>Image *</label>
                                            <input type="file" class="form-control" name="edit_question_image" accept="image/*">
                                             <input type="hidden" name="edit_question_image_old" id="edit_question_image_old">
                                    <small class="text-muted">Leave blank to keep current image</small>
                                    <div id="edit_question_image_preview" class="mt-1"></div>
                                        </div>
                                    </div>
                                </div>

                        <!-- Option A -->
                        <div class="col-md-6">
                            <div class="border p-3 rounded" style="background: #f8f9fc;">
                                <h6><span class="badge bg-primary">Option A</span></h6>
                                <div class="form-group">
                                    <label>Option Type *</label>
                                    <select class="form-control edit-option-type" name="edit_option_a_type" data-option="A" required>
                                        <option value="text">Text</option>
                                        <option value="image">Image</option>
                                    </select>
                                </div>
                                <div class="form-group edit-option-a-text">
                                    <label>Text *</label>
                                    <input type="text" class="form-control" id="edit_option_a_text" name="edit_option_a_text">
                                </div>
                                <div class="form-group edit-option-a-image" style="display:none;">
                                    <label>Image</label>
                                    <input type="file" class="form-control" name="edit_option_a_image" accept="image/*">
                                    <input type="hidden" name="edit_option_a_image_old" id="edit_option_a_image_old">
                                    <small class="text-muted">Leave blank to keep current image</small>
                                    <div id="edit_option_a_preview" class="mt-1"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Option B -->
                        <div class="col-md-6">
                            <div class="border p-3 rounded" style="background: #f8f9fc;">
                                <h6><span class="badge bg-danger">Option B</span></h6>
                                <div class="form-group">
                                    <label>Option Type *</label>
                                    <select class="form-control edit-option-type" name="edit_option_b_type" data-option="B" required>
                                        <option value="text">Text</option>
                                        <option value="image">Image</option>
                                    </select>
                                </div>
                                <div class="form-group edit-option-b-text">
                                    <label>Text *</label>
                                    <input type="text" class="form-control" id="edit_option_b_text" name="edit_option_b_text">
                                </div>
                                <div class="form-group edit-option-b-image" style="display:none;">
                                    <label>Image</label>
                                    <input type="file" class="form-control" name="edit_option_b_image" accept="image/*">
                                    <input type="hidden" name="edit_option_b_image_old" id="edit_option_b_image_old">
                                    <small class="text-muted">Leave blank to keep current image</small>
                                    <div id="edit_option_b_preview" class="mt-1"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Correct Answer *</label>
                                <select class="form-control" id="edit_correct_answer" name="edit_correct_answer" required>
                                    <option value="A">Option A</option>
                                    <option value="B">Option B</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" id="edit_question_status" name="edit_question_status">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Update Question</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

    // =============================================
    // DATATABLE
    // =============================================
    var table = $('#ajax_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?= base_url('admin/syllabus-list') ?>",
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "class_name" },
            { "data": "subject_name" },
            { "data": "image" },
            { "data": "pdf" },
            { "data": "questions" },
            { "data": "description" },
            { "data": "status" },
            { "data": "action" }
        ],
        "order": [[0, 'DESC']]
    });

    // =============================================
    // SYLLABUS CRUD (Same as before)
    // =============================================
    $('#RecordSyllabus').on('click', function() {
        $('#addSyllabus').modal('show');
        $('#SaveSyllabus')[0].reset();
    });

    $('#SaveSyllabus').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        $(":submit", this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/syllabus_save') ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(response) {
                $('#addSyllabusClose').click();
                $('#SaveSyllabus')[0].reset();
                $(":submit", '#SaveSyllabus').prop('disabled', false).html('<i class="fas fa-save"></i> Save Syllabus');
                table.ajax.reload();
                showToast('success', 'Syllabus added successfully!');
            },
            error: function() {
                $(":submit", '#SaveSyllabus').prop('disabled', false).html('<i class="fas fa-save"></i> Save Syllabus');
                showToast('error', 'Something went wrong!');
            }
        });
        return false;
    });

    // =============================================
    // EDIT SYLLABUS
    // =============================================
    $('#ajax_table').on('click', '.editRecord', function() {
        var id = $(this).data('id');
        var class_name = $(this).data('class');
        var subject = $(this).data('subject');
        var description = $(this).data('description');
        var status = $(this).data('status');
        var image = $(this).data('image');
        var pdf = $(this).data('pdf');

        $('#edit_syllabus_id').val(id);
        $('#edit_class_name').val(class_name);
        $('#edit_subject_name').val(subject);
        $('#edit_description').val(description);
        $('#edit_status').val(status);
        $('#edit_subject_image_old').val(image);
        $('#edit_pdf_file_old').val(pdf);

        if (pdf) {
            $('#current_pdf_display').html('<a href="<?= base_url('assets/syllabus/pdf/') ?>/' + pdf + '" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-file-pdf"></i> View Current PDF</a>');
        } else {
            $('#current_pdf_display').html('<span class="text-muted">No PDF uploaded</span>');
        }

        $('#editSyllabus').modal('show');
    });

    $('#UpdateSyllabus').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        $(":submit", this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');

        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/syllabus_update') ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(response) {
                $('#editSyllabusClose').click();
                $('#UpdateSyllabus')[0].reset();
                $(":submit", '#UpdateSyllabus').prop('disabled', false).html('<i class="fas fa-edit"></i> Update');
                table.ajax.reload();
                showToast('success', 'Syllabus updated successfully!');
            },
            error: function() {
                $(":submit", '#UpdateSyllabus').prop('disabled', false).html('<i class="fas fa-edit"></i> Update');
                showToast('error', 'Something went wrong!');
            }
        });
        return false;
    });

    // =============================================
    // DELETE SYLLABUS
    // =============================================
    $('#ajax_table').on('click', '.deleteRecord', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this syllabus?')) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('admin/syllabus_delete') ?>",
                data: { id: id },
                dataType: "JSON",
                success: function(response) {
                    table.ajax.reload();
                    showToast('success', 'Syllabus deleted successfully!');
                },
                error: function() {
                    showToast('error', 'Delete failed!');
                }
            });
        }
    });

    // =============================================
    // OPEN QUESTIONS MODAL
    // =============================================
    $('#ajax_table').on('click', '.manageQuestions', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        $('#q_syllabus_id').val(id);
        $('#q_syllabus_name').text(name);
        $('#questionsModal').modal('show');
        loadQuestions(id);
    });

    // =============================================
    // TOGGLE OPTION TYPE (Add Question)
    // =============================================
    $(document).on('change', '.option-type', function() {
        var option = $(this).data('option');
        var type = $(this).val();
        
        if (option == 'A') {
            if (type == 'text') {
                $('.option-a-text').show();
                $('.option-a-image').hide();
                $('input[name="option_a_text"]').prop('required', true);
                $('input[name="option_a_image"]').prop('required', false);
            } else {
                $('.option-a-text').hide();
                $('.option-a-image').show();
                $('input[name="option_a_text"]').prop('required', false);
                $('input[name="option_a_image"]').prop('required', true);
            }
        } else if (option == 'B') {
            if (type == 'text') {
                $('.option-b-text').show();
                $('.option-b-image').hide();
                $('input[name="option_b_text"]').prop('required', true);
                $('input[name="option_b_image"]').prop('required', false);
            } else {
                $('.option-b-text').hide();
                $('.option-b-image').show();
                $('input[name="option_b_text"]').prop('required', false);
                $('input[name="option_b_image"]').prop('required', true);
            }
        }
    });

    // =============================================
    // TOGGLE OPTION TYPE (Edit Question)
    // =============================================
    $(document).on('change', '.edit-option-type', function() {
        var option = $(this).data('option');
        var type = $(this).val();
        
        if (option == 'A') {
            if (type == 'text') {
                $('.edit-option-a-text').show();
                $('.edit-option-a-image').hide();
                $('input[name="edit_option_a_text"]').prop('required', true);
                $('input[name="edit_option_a_image"]').prop('required', false);
            } else {
                $('.edit-option-a-text').hide();
                $('.edit-option-a-image').show();
                $('input[name="edit_option_a_text"]').prop('required', false);
                $('input[name="edit_option_a_image"]').prop('required', true);
            }
        } else if (option == 'B') {
            if (type == 'text') {
                $('.edit-option-b-text').show();
                $('.edit-option-b-image').hide();
                $('input[name="edit_option_b_text"]').prop('required', true);
                $('input[name="edit_option_b_image"]').prop('required', false);
            } else {
                $('.edit-option-b-text').hide();
                $('.edit-option-b-image').show();
                $('input[name="edit_option_b_text"]').prop('required', false);
                $('input[name="edit_option_b_image"]').prop('required', true);
            }
        }
    });

    // =============================================
    // LOAD QUESTIONS
    // =============================================
    function loadQuestions(syllabusId) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/get_questions') ?>",
            data: { syllabus_id: syllabusId },
            dataType: "JSON",
            success: function(response) {
                var html = '';
                if (response.length > 0) {
                    $.each(response, function(index, q) {
                        var optionA = q.option_a_type == 'image' ? 
                            '<img src="<?= base_url('assets/questions/') ?>/' + q.option_a_image + '" width="50" height="50" style="object-fit:cover; border-radius:8px;">' : 
                            q.option_a_text;
                        var optionB = q.option_b_type == 'image' ? 
                            '<img src="<?= base_url('assets/questions/') ?>/' + q.option_b_image + '" width="50" height="50" style="object-fit:cover; border-radius:8px;">' : 
                            q.option_b_text;
                        var statusBadge = q.status == 'Active' ? 
                            '<span class="badge bg-success">Active</span>' : 
                            '<span class="badge bg-danger">Inactive</span>';
                        var correctBadge = q.correct_answer == 'A' ? 
                            '<span class="badge bg-primary">A</span>' : 
                            '<span class="badge bg-danger">B</span>';

                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${q.question_text}</td>
                                <td>${optionA}</td>
                                <td>${optionB}</td>
                                <td>${correctBadge}</td>
                                <td>${statusBadge}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning editQuestion" 
                                        data-id="${q.id}"
                                        data-question="${q.question_text}"
                                          data-question_image="${q.question_image}"
                                        data-option-a-type="${q.option_a_type}"
                                        data-option-a-text="${q.option_a_text}"
                                        data-option-a-image="${q.option_a_image}"
                                        data-option-b-type="${q.option_b_type}"
                                        data-option-b-text="${q.option_b_text}"
                                        data-option-b-image="${q.option_b_image}"
                                        data-correct="${q.correct_answer}"
                                        data-status="${q.status}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger deleteQuestion" data-id="${q.id}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = '<tr><td colspan="7" class="text-center text-muted">No questions added yet.</td></tr>';
                }
                $('#questions_list_body').html(html);
            }
        });
    }

    // =============================================
    // ADD QUESTION
    // =============================================
    $('#AddQuestionForm').submit(function(event) {
        event.preventDefault();
        var syllabusId = $('#q_syllabus_id').val();
        var formData = new FormData($(this)[0]);
        formData.append('syllabus_id', syllabusId);
        
        $(":submit", this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Adding...');

        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/add_question') ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#AddQuestionForm')[0].reset();
                    $('.option-a-image, .option-b-image').hide();
                    $('.option-a-text, .option-b-text').show();
                    $(":submit", '#AddQuestionForm').prop('disabled', false).html('<i class="fas fa-plus"></i> Add Question');
                    loadQuestions(syllabusId);
                    showToast('success', 'Question added successfully!');
                } else {
                    showToast('error', response.message || 'Error adding question!');
                }
            },
            error: function() {
                $(":submit", '#AddQuestionForm').prop('disabled', false).html('<i class="fas fa-plus"></i> Add Question');
                showToast('error', 'Something went wrong!');
            }
        });
        return false;
    });

    // =============================================
    // EDIT QUESTION - LOAD DATA
    // =============================================
    $(document).on('click', '.editQuestion', function() {
        var id = $(this).data('id');
        var question = $(this).data('question');
        
            var question_image = $(this).data('question_image');
    
             $('#edit_question_image_old').val(question_image);
                $('#edit_question_image_preview').html('<img src="<?= base_url('assets/questions/') ?>/' + question_image + '" width="60" height="60" style="object-fit:cover; border-radius:8px; border:1px solid #ddd;">');
            
        
        
       
        
        
        var optionAType = $(this).data('option-a-type');
        var optionAText = $(this).data('option-a-text');
        var optionAImage = $(this).data('option-a-image');
        var optionBType = $(this).data('option-b-type');
        var optionBText = $(this).data('option-b-text');
        var optionBImage = $(this).data('option-b-image');
        var correct = $(this).data('correct');
        var status = $(this).data('status');

        $('#edit_question_id').val(id);
        $('#edit_question_text').val(question);
        $('#edit_correct_answer').val(correct);
        $('#edit_question_status').val(status);

        // Option A
        $('#edit_option_a_type').val(optionAType);
        if (optionAType == 'text') {
            $('.edit-option-a-text').show();
            $('.edit-option-a-image').hide();
            $('#edit_option_a_text').val(optionAText);
            $('#edit_option_a_text').prop('required', true);
            $('input[name="edit_option_a_image"]').prop('required', false);
        } else {
            $('.edit-option-a-text').hide();
            $('.edit-option-a-image').show();
            $('#edit_option_a_text').prop('required', false);
        //    $('input[name="edit_option_a_image"]').prop('required', true);
            $('#edit_option_a_image_old').val(optionAImage);
            if (optionAImage) {
                $('#edit_option_a_preview').html('<img src="<?= base_url('assets/questions/') ?>/' + optionAImage + '" width="60" height="60" style="object-fit:cover; border-radius:8px; border:1px solid #ddd;">');
            }
        }

        // Option B
        $('#edit_option_b_type').val(optionBType);
        if (optionBType == 'text') {
            $('.edit-option-b-text').show();
            $('.edit-option-b-image').hide();
            $('#edit_option_b_text').val(optionBText);
            $('#edit_option_b_text').prop('required', true);
            $('input[name="edit_option_b_image"]').prop('required', false);
        } else {
            $('.edit-option-b-text').hide();
            $('.edit-option-b-image').show();
            $('#edit_option_b_text').prop('required', false);
          //  $('input[name="edit_option_b_image"]').prop('required', true);
            $('#edit_option_b_image_old').val(optionBImage);
            if (optionBImage) {
                $('#edit_option_b_preview').html('<img src="<?= base_url('assets/questions/') ?>/' + optionBImage + '" width="60" height="60" style="object-fit:cover; border-radius:8px; border:1px solid #ddd;">');
            }
        }

        $('#editQuestionModal').modal('show');
    });

    // =============================================
    // UPDATE QUESTION
    // =============================================
    $('#EditQuestionForm').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        var syllabusId = $('#q_syllabus_id').val();
        
        $(":submit", this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');

        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/update_question') ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#editQuestionModal').modal('hide');
                    $(":submit", '#EditQuestionForm').prop('disabled', false).html('<i class="fas fa-edit"></i> Update Question');
                    loadQuestions(syllabusId);
                    showToast('success', 'Question updated successfully!');
                } else {
                    showToast('error', response.message || 'Error updating question!');
                }
            },
            error: function() {
                $(":submit", '#EditQuestionForm').prop('disabled', false).html('<i class="fas fa-edit"></i> Update Question');
                showToast('error', 'Something went wrong!');
            }
        });
        return false;
    });

    // =============================================
    // DELETE QUESTION
    // =============================================
    $(document).on('click', '.deleteQuestion', function() {
        var id = $(this).data('id');
        var syllabusId = $('#q_syllabus_id').val();
        
        if (confirm('Are you sure you want to delete this question?')) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('admin/delete_question') ?>",
                data: { id: id },
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        loadQuestions(syllabusId);
                        showToast('success', 'Question deleted successfully!');
                    } else {
                        showToast('error', 'Delete failed!');
                    }
                },
                error: function() {
                    showToast('error', 'Something went wrong!');
                }
            });
        }
    });

    // =============================================
    // TOAST FUNCTION
    // =============================================
    function showToast(type, message) {
        var bgColor = type == 'success' ? '#28a745' : '#dc3545';
        var icon = type == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        var toastHtml = `
            <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; background: ${bgColor}; color: #fff; 
                        padding: 15px 25px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                        font-size: 16px; display: flex; align-items: center; gap: 10px; animation: slideIn 0.5s;">
                <i class="fas ${icon}"></i>
                <span>${message}</span>
            </div>
        `;
        $('body').append(toastHtml);
        setTimeout(function() {
            $('body').find('div[style*="position: fixed; top: 20px;"]').fadeOut(500, function() {
                $(this).remove();
            });
        }, 3000);
    }

});
</script>