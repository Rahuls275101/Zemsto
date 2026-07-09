<!-- CONTENT WRAPPER -->
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Olympiad Results</h1>
                <p class="breadcrumbs">
                    <span><a href="<?= base_url('admin/dashboard') ?>">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Olympiad Results
                </p>
            </div>
            <div>
                <a href="javascript:void(0);" class="btn btn-primary" id="addResultBtn">
                    <i class="fas fa-plus"></i> Add Result
                </a>
                <a href="javascript:void(0);" class="btn btn-success" id="importCsvBtn">
                    <i class="fas fa-file-import"></i> Import CSV
                </a>
                <a href="<?= base_url('admin/csv-export') ?>" class="btn btn-info" target="_blank">
                    <i class="fas fa-file-export"></i> Export CSV
                </a>
                <a href="<?= base_url('admin/download-sample-csv') ?>" class="btn btn-secondary">
                    <i class="fas fa-download"></i> Sample CSV
                </a>
                <a href="javascript:void(0);" class="btn btn-success" id="manageSubjectsBtn">
                    <i class="fas fa-book"></i> Subjects
                </a>
                <a href="javascript:void(0);" class="btn btn-info" id="manageClassesBtn">
                    <i class="fas fa-users"></i> Classes
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
                                        <th>Subject</th>
                                        <th>Class</th>
                                        <th>Enrollment</th>
                                        <th>Student</th>
                                        <th>Parent</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Marks</th>
                                        <th>Rank</th>
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
<!-- ADD RESULT MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="addResultModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add Olympiad Result</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addResultForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Subject *</label>
                                <select class="form-control" name="subject_id" id="addSubject" required>
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Class *</label>
                                <select class="form-control" name="class_id" id="addClass" required>
                                    <option value="">Select Class</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Enrollment *</label>
                                <input type="text" class="form-control" name="enrollment" placeholder="Enter enrollment number" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Access Code *</label>
                                <input type="text" class="form-control" name="access_code" placeholder="Enter access code" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Student Name *</label>
                                <input type="text" class="form-control" name="student_name" placeholder="Enter student name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Parent Name *</label>
                                <input type="text" class="form-control" name="parent_name" placeholder="Enter parent name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Phone *</label>
                                <input type="text" class="form-control" name="phone" placeholder="Enter phone" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">School Name</label>
                                <input type="text" class="form-control" name="school_name" placeholder="Enter school name">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Marks *</label>
                                <input type="text" class="form-control" name="marks" placeholder="e.g., 95" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Rank</label>
                                <input type="text" class="form-control" name="rank" placeholder="e.g., 1">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Position</label>
                                <select class="form-control" name="position">
                                    <option value="">Select Position</option>
                                    <option value="1st">🥇 1st</option>
                                    <option value="2nd">🥈 2nd</option>
                                    <option value="3rd">🥉 3rd</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Year</label>
                                <select class="form-control" name="year">
                                    <option value="2025-26">2025-26</option>
                                    <option value="2024-25">2024-25</option>
                                    <option value="2023-24">2023-24</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Result</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- EDIT RESULT MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="editResultModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Olympiad Result</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editResultForm">
                    <input type="hidden" name="edit_id" id="editId">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Subject *</label>
                                <select class="form-control" name="edit_subject_id" id="editSubject" required>
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Class *</label>
                                <select class="form-control" name="edit_class_id" id="editClass" required>
                                    <option value="">Select Class</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Enrollment *</label>
                                <input type="text" class="form-control" name="edit_enrollment" id="editEnrollment" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Access Code *</label>
                                <input type="text" class="form-control" name="edit_access_code" id="editAccessCode" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Student Name *</label>
                                <input type="text" class="form-control" name="edit_student_name" id="editStudentName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Parent Name *</label>
                                <input type="text" class="form-control" name="edit_parent_name" id="editParentName" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Phone *</label>
                                <input type="text" class="form-control" name="edit_phone" id="editPhone" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="edit_email" id="editEmail" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">School Name</label>
                                <input type="text" class="form-control" name="edit_school_name" id="editSchoolName">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Marks *</label>
                                <input type="text" class="form-control" name="edit_marks" id="editMarks" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Rank</label>
                                <input type="text" class="form-control" name="edit_rank" id="editRank">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Position</label>
                                <select class="form-control" name="edit_position" id="editPosition">
                                    <option value="">Select Position</option>
                                    <option value="1st">🥇 1st</option>
                                    <option value="2nd">🥈 2nd</option>
                                    <option value="3rd">🥉 3rd</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Year</label>
                                <select class="form-control" name="edit_year" id="editYear">
                                    <option value="2025-26">2025-26</option>
                                    <option value="2024-25">2024-25</option>
                                    <option value="2023-24">2023-24</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="edit_status" id="editStatus">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Result</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- CSV IMPORT MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="importCsvModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-file-import"></i> Import CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Instructions:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Download the sample CSV file to see the required format</li>
                        <li>Make sure <strong>subject_name</strong> and <strong>class_name</strong> match existing subjects/classes</li>
                        <li><strong>Enrollment</strong> must be unique</li>
                        <li>Required fields: enrollment, student_name, parent_name, phone, email</li>
                    </ul>
                </div>
                
                <form id="importCsvForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Select CSV File *</label>
                        <input type="file" class="form-control" name="csv_file" id="csvFile" accept=".csv" required>
                        <small class="text-muted">Only .csv files are allowed</small>
                    </div>
                    
                    <div class="mb-3" id="importProgress" style="display:none;">
                        <label class="form-label">Import Progress</label>
                        <div class="progress">
                            <div id="importProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" 
                                 style="width: 0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                0%
                            </div>
                        </div>
                        <div id="importStatus" class="mt-2"></div>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100" id="importSubmitBtn">
                        <i class="fas fa-upload"></i> Import CSV
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MANAGE SUBJECTS MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="manageSubjectsModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-book"></i> Manage Subjects</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <button class="btn btn-sm btn-success mb-3" id="addSubjectBtn">
                    <i class="fas fa-plus"></i> Add Subject
                </button>
                <div class="table-responsive">
                    <table class="table table-bordered" id="subjectsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject Name</th>
                                <th>Subject Code</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="subjectsBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- ADD/EDIT SUBJECT MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="subjectFormModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subjectFormTitle">Add Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="subjectForm">
                    <input type="hidden" name="edit_subject_id" id="editSubjectId">
                    <div class="mb-3">
                        <label class="form-label">Subject Name *</label>
                        <input type="text" class="form-control" name="subject_name" id="subjectName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject Code *</label>
                        <input type="text" class="form-control" name="subject_code" id="subjectCode" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status" id="subjectStatus">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="subjectSubmitBtn">Save Subject</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MANAGE CLASSES MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="manageClassesModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-users"></i> Manage Classes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <button class="btn btn-sm btn-success mb-3" id="addClassBtn">
                    <i class="fas fa-plus"></i> Add Class
                </button>
                <div class="table-responsive">
                    <table class="table table-bordered" id="classesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Class Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="classesBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- ADD/EDIT CLASS MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="classFormModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="classFormTitle">Add Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="classForm">
                    <input type="hidden" name="edit_class_id" id="editClassId">
                    <div class="mb-3">
                        <label class="form-label">Class Name *</label>
                        <input type="text" class="form-control" name="class_name" id="className" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status" id="classStatus">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="classSubmitBtn">Save Class</button>
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
            "url": "<?= base_url('admin/olympiad-results-list') ?>",
            "type": "POST"
        },
        "columns": <?= $table_column ?>,
        "pagingType": "simple_numbers_no_ellipses",
        "language": {
            "processing": '<div class="custom-spinner"></div>'
        }
    });

    // ============================================
    // LOAD SUBJECTS & CLASSES FOR DROPDOWN
    // ============================================
    function loadSubjects() {
        $.ajax({
            url: "<?= base_url('admin/get-subjects') ?>",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                var options = '<option value="">Select Subject</option>';
                $.each(data, function(key, val) {
                    options += '<option value="' + val.id + '">' + val.subject_name + ' (' + val.subject_code + ')</option>';
                });
                $('#addSubject').html(options);
                $('#editSubject').html(options);
            },
            error: function() {
                console.log('Error loading subjects');
            }
        });
    }

    function loadClasses() {
        $.ajax({
            url: "<?= base_url('admin/get-classes') ?>",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                var options = '<option value="">Select Class</option>';
                $.each(data, function(key, val) {
                    options += '<option value="' + val.id + '">' + val.class_name + '</option>';
                });
                $('#addClass').html(options);
                $('#editClass').html(options);
            },
            error: function() {
                console.log('Error loading classes');
            }
        });
    }

    loadSubjects();
    loadClasses();

    // ============================================
    // ADD RESULT - Submit
    // ============================================
    $('#addResultForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/olympiad-result-save') ?>",
            data: formData,
            dataType: "JSON",
            success: function(response) {
                if (response.status) {
                    $('#addResultModal').modal('hide');
                    $('#addResultForm')[0].reset();
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
    // EDIT RESULT - Load Data
    // ============================================
    $(document).on('click', '.editResult', function() {
        var data = $(this).data();
        
        $('#editId').val(data.id);
        $('#editSubject').val(data.subject_id);
        $('#editClass').val(data.class_id);
        $('#editEnrollment').val(data.enrollment);
        $('#editAccessCode').val(data.access_code);
        $('#editStudentName').val(data.student_name);
        $('#editParentName').val(data.parent_name);
        $('#editPhone').val(data.phone);
        $('#editEmail').val(data.email);
        $('#editSchoolName').val(data.school_name);
        $('#editMarks').val(data.marks);
        $('#editRank').val(data.rank);
        $('#editPosition').val(data.position);
        $('#editYear').val(data.year);
        $('#editStatus').val(data.status);
        
        $('#editResultModal').modal('show');
    });

    // ============================================
    // EDIT RESULT - Submit
    // ============================================
    $('#editResultForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/olympiad-result-update') ?>",
            data: formData,
            dataType: "JSON",
            success: function(response) {
                if (response.status) {
                    $('#editResultModal').modal('hide');
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
    // DELETE RESULT
    // ============================================
    $(document).on('click', '.deleteResult', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/olympiad-result-delete') ?>",
                    data: { id: id },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            table.ajax.reload();
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000, showConfirmButton: false });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error!', text: response.message });
                        }
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Error!', text: 'Server error!' });
                    }
                });
            }
        });
    });

    // ============================================
    // CSV IMPORT - Open Modal
    // ============================================
    $('#importCsvBtn').on('click', function() {
        $('#importCsvForm')[0].reset();
        $('#importProgress').hide();
        $('#importProgressBar').css('width', '0%').text('0%');
        $('#importStatus').html('');
        $('#importSubmitBtn').prop('disabled', false).html('<i class="fas fa-upload"></i> Import CSV');
        $('#importCsvModal').modal('show');
    });

    // ============================================
    // CSV IMPORT - Submit
    // ============================================
    $('#importCsvForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var btn = $('#importSubmitBtn');
        
        // Validate file
        var file = $('#csvFile')[0].files[0];
        if (!file) {
            toastr.error('Please select a CSV file.');
            return;
        }
        
        // Show progress
        $('#importProgress').show();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Importing...');
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/csv-import') ?>",
            data: formData,
            dataType: "JSON",
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        $('#importProgressBar').css('width', percentComplete + '%').text(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                btn.prop('disabled', false).html('<i class="fas fa-upload"></i> Import CSV');
                
                if (response.status) {
                    var statusHtml = '<div class="alert alert-success">';
                    statusHtml += '<strong>' + response.message + '</strong><br>';
                    if (response.imported > 0) {
                        statusHtml += '✅ Imported: <strong>' + response.imported + '</strong> records<br>';
                    }
                    if (response.skipped > 0) {
                        statusHtml += '⚠️ Skipped: <strong>' + response.skipped + '</strong> records<br>';
                    }
                    if (response.errors && response.errors.length > 0) {
                        statusHtml += '<hr><strong>Errors:</strong><br>';
                        $.each(response.errors, function(key, val) {
                            statusHtml += '• ' + val + '<br>';
                        });
                    }
                    statusHtml += '</div>';
                    $('#importStatus').html(statusHtml);
                    
                    $('#importProgressBar').css('width', '100%').text('100%');
                    
                    // Reload table after 2 seconds
                    setTimeout(function() {
                        table.ajax.reload();
                        if (response.imported > 0) {
                            $('#importCsvModal').modal('hide');
                            toastr.success('Import completed! ' + response.imported + ' records added.');
                        }
                    }, 2000);
                } else {
                    $('#importStatus').html('<div class="alert alert-danger">' + response.message + '</div>');
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                btn.prop('disabled', false).html('<i class="fas fa-upload"></i> Import CSV');
                $('#importStatus').html('<div class="alert alert-danger">Server error: ' + error + '</div>');
                toastr.error('Server error occurred!');
            }
        });
    });

    // ============================================
    // MANAGE SUBJECTS
    // ============================================
    $('#manageSubjectsBtn').on('click', function() {
        loadSubjectsTable();
        $('#manageSubjectsModal').modal('show');
    });

    function loadSubjectsTable() {
        $.ajax({
            url: "<?= base_url('admin/subject-list') ?>",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                var html = '';
                $.each(data, function(key, val) {
                    var statusBadge = val.status == 'Active' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                    html += '<tr>';
                    html += '<td>' + val.id + '</td>';
                    html += '<td>' + val.subject_name + '</td>';
                    html += '<td><strong>' + val.subject_code + '</strong></td>';
                    html += '<td>' + statusBadge + '</td>';
                    html += '<td>';
                    html += '<button class="btn btn-sm btn-primary editSubject" data-id="' + val.id + '" data-name="' + val.subject_name + '" data-code="' + val.subject_code + '" data-status="' + val.status + '"><i class="fas fa-edit"></i></button> ';
                    html += '<button class="btn btn-sm btn-danger deleteSubject" data-id="' + val.id + '"><i class="fas fa-trash"></i></button>';
                    html += '</td>';
                    html += '</tr>';
                });
                $('#subjectsBody').html(html);
            }
        });
    }

    // ============================================
    // ADD SUBJECT
    // ============================================
    $('#addSubjectBtn').on('click', function() {
        $('#subjectFormTitle').text('Add Subject');
        $('#subjectForm')[0].reset();
        $('#editSubjectId').val('');
        $('#subjectSubmitBtn').text('Save Subject');
        $('#subjectFormModal').modal('show');
    });

    $('#subjectForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var url = $('#editSubjectId').val() ? "<?= base_url('admin/subject-update') ?>" : "<?= base_url('admin/subject-save') ?>";
        
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: "JSON",
            success: function(response) {
                if (response.status) {
                    $('#subjectFormModal').modal('hide');
                    loadSubjectsTable();
                    loadSubjects();
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });

    // ============================================
    // EDIT SUBJECT
    // ============================================
    $(document).on('click', '.editSubject', function() {
        var data = $(this).data();
        $('#subjectFormTitle').text('Edit Subject');
        $('#editSubjectId').val(data.id);
        $('#subjectName').val(data.name);
        $('#subjectCode').val(data.code);
        $('#subjectStatus').val(data.status);
        $('#subjectSubmitBtn').text('Update Subject');
        $('#subjectFormModal').modal('show');
    });

    // ============================================
    // DELETE SUBJECT
    // ============================================
    $(document).on('click', '.deleteSubject', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/subject-delete') ?>",
                    data: { id: id },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            loadSubjectsTable();
                            loadSubjects();
                            toastr.success(response.message);
                        }
                    }
                });
            }
        });
    });

    // ============================================
    // MANAGE CLASSES
    // ============================================
    $('#manageClassesBtn').on('click', function() {
        loadClassesTable();
        $('#manageClassesModal').modal('show');
    });

    function loadClassesTable() {
        $.ajax({
            url: "<?= base_url('admin/class-list') ?>",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                var html = '';
                $.each(data, function(key, val) {
                    var statusBadge = val.status == 'Active' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                    html += '<tr>';
                    html += '<td>' + val.id + '</td>';
                    html += '<td>' + val.class_name + '</td>';
                    html += '<td>' + statusBadge + '</td>';
                    html += '<td>';
                    html += '<button class="btn btn-sm btn-primary editClass" data-id="' + val.id + '" data-name="' + val.class_name + '" data-status="' + val.status + '"><i class="fas fa-edit"></i></button> ';
                    html += '<button class="btn btn-sm btn-danger deleteClass" data-id="' + val.id + '"><i class="fas fa-trash"></i></button>';
                    html += '</td>';
                    html += '</tr>';
                });
                $('#classesBody').html(html);
            }
        });
    }

    // ============================================
    // ADD CLASS
    // ============================================
    $('#addClassBtn').on('click', function() {
        $('#classFormTitle').text('Add Class');
        $('#classForm')[0].reset();
        $('#editClassId').val('');
        $('#classSubmitBtn').text('Save Class');
        $('#classFormModal').modal('show');
    });

    $('#classForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var url = $('#editClassId').val() ? "<?= base_url('admin/class-update') ?>" : "<?= base_url('admin/class-save') ?>";
        
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: "JSON",
            success: function(response) {
                if (response.status) {
                    $('#classFormModal').modal('hide');
                    loadClassesTable();
                    loadClasses();
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });

    // ============================================
    // EDIT CLASS
    // ============================================
    $(document).on('click', '.editClass', function() {
        var data = $(this).data();
        $('#classFormTitle').text('Edit Class');
        $('#editClassId').val(data.id);
        $('#className').val(data.name);
        $('#classStatus').val(data.status);
        $('#classSubmitBtn').text('Update Class');
        $('#classFormModal').modal('show');
    });

    // ============================================
    // DELETE CLASS
    // ============================================
    $(document).on('click', '.deleteClass', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/class-delete') ?>",
                    data: { id: id },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            loadClassesTable();
                            loadClasses();
                            toastr.success(response.message);
                        }
                    }
                });
            }
        });
    });

    // ============================================
    // ADD RESULT - Open Modal
    // ============================================
    $('#addResultBtn').on('click', function() {
        $('#addResultForm')[0].reset();
        $('#addResultModal').modal('show');
    });

});
</script>