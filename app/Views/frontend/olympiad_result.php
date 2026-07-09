
<section class="section-registration">
  <div class="container">
    <div class="section-title">
      <h2>Result For <span>Zemsto</span> Olympiad 2025-26</h2>
      <p>Congratulations to all participants of the Zemsto Olympiad 2025–26 for their outstanding efforts and achievements.</p>
    </div>
    
    <div class="row justify-content-center">
      <div class="col-lg-6"> 
        
        <!-- SEARCH FORM -->
        <div id="india" class="tab-content-custom active">
          <div class="form-card">
            <div class="form-body">
              <div class="smart-forms bmargin"> 
                <form id="resultSearchForm">
                  <div class="row g-4">
                    <!-- Subject -->
                    <div class="form-group col-md-12">
                      <label class="form-label">Select Subject</label>
                      <select name="subject_id" class="form-control">
                        <option value="">Select Subject</option>
                        <?php if (!empty($subjects)): ?>
                          <?php foreach ($subjects as $row): ?>
                            <option value="<?= esc($row->id) ?>">
                              <?= esc($row->subject_name) ?> (<?= esc($row->subject_code) ?>)
                            </option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                    </div>

                    <!-- Enrollment -->
                    <div class="form-group col-md-12">
                      <label class="form-label">Enter Enrollment</label>
                      <input type="text" name="enrollment" class="form-control" placeholder="Enter Enrollment">
                    </div>

                    <!-- Access Code -->
                    <div class="form-group col-md-12">
                      <label class="form-label">Enter Access Code</label>
                      <input type="text" name="accesscode" class="form-control" placeholder="Enter Access Code">
                    </div>

                    <!-- Student Name -->
                    <div class="form-group col-md-12">
                      <label class="form-label">Student Name</label>
                      <input type="text" name="studentname" class="form-control" placeholder="Student Name">
                    </div>

                    <!-- Parent Name -->
                    <div class="form-group col-md-12">
                      <label class="form-label">Father/Mother Name</label>
                      <input type="text" name="parentname" class="form-control" placeholder="Father/Mother Name">
                    </div>

                    <!-- Phone -->
                    <div class="form-group col-md-12">
                      <label class="form-label">Mobile No.</label>
                      <input type="text" name="phone" class="form-control" placeholder="Mobile No." maxlength="10">
                    </div>

                    <!-- Email -->
                    <div class="form-group col-md-12">
                      <label class="form-label">Email address</label>
                      <input type="email" name="email" class="form-control" placeholder="Email address">
                    </div>

                    <!-- Search Button -->
                    <div class="form-group col-md-12">
                      <button type="submit" class="btn-register" id="searchBtn">
                        <i class="fas fa-search"></i> Search
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>

    <!-- ============================================ -->
    <!-- RESULTS DISPLAY -->
    <!-- ============================================ -->
    <div class="row justify-content-center mt-4">
      <div class="col-lg-8">
        <div id="resultContainer">
          <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> Please fill the details and click Search to view results.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.btn-register {
    background: #f7941d;
    color: #fff;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    transition: all 0.3s ease;
}

.btn-register:hover {
    background: #e07c0a;
    color: #fff;
}

.result-card {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border-left: 4px solid #f7941d;
}

.result-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.result-header h4 {
    color: #1a1a1a;
    font-weight: 600;
    margin: 0;
}

.enrollment-badge {
    background: #e9ecef;
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 12px;
    color: #495057;
}

.result-body p {
    margin-bottom: 5px;
    font-size: 14px;
}

.marks {
    color: #28a745;
    font-weight: 700;
    font-size: 18px;
}

.rank {
    color: #f7941d;
    font-weight: 700;
    font-size: 16px;
}

.spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #f7941d;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.alert-info {
    background: #d1ecf1;
    color: #0c5460;
    padding: 15px;
    border-radius: 8px;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    padding: 15px;
    border-radius: 8px;
}
</style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous">
</script>
<script>
$(document).ready(function() {

    // ============================================
    // SEARCH RESULT - AJAX
    // ============================================
    $('#resultSearchForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        // Show loading
        $('#searchBtn').html('<span class="spinner"></span> Searching...');
        $('#searchBtn').attr('disabled', true);
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('olympiad-result/search') ?>",
            data: formData,
            dataType: "JSON",
            success: function(response) {
                $('#searchBtn').html('<i class="fas fa-search"></i> Search');
                $('#searchBtn').attr('disabled', false);
                
                if (response.status) {
                    $('#resultContainer').html(response.html);
                } else {
                    $('#resultContainer').html('<div class="alert alert-danger">Something went wrong!</div>');
                }
            },
            error: function(xhr, status, error) {
                $('#searchBtn').html('<i class="fas fa-search"></i> Search');
                $('#searchBtn').attr('disabled', false);
                console.log('Error:', xhr.responseText);
                $('#resultContainer').html('<div class="alert alert-danger">Server error! Please try again.</div>');
            }
        });
    });

});
</script>