<?php 
use App\Models\Commanmodel;
$commanmodel = new Commanmodel();

$school = $commanmodel->all_multiple_query_order_by_limit('admin',array('status' => 'Active','admin_type' => 'School'),'id','ASC',100); 
   
// Get competitions from existing competitions table
$competitionsData = $commanmodel->getDataFromTable('competitions', ['status' => 'Active']);
$activeCompetitions = $competitionsData['filteredRecords'] ?? [];

$olympiadssData = $commanmodel->getDataFromTable('olympiads', ['status' => 'Active']);
$activeolympiads = $olympiadssData['filteredRecords'] ?? [];
?>

<section class="section-registration">
    <div class="container">
        <div class="section-title">
            <h2>Register & <span>Complete</span> on the World Stage</h2>
            <p>Pick your competition, fill in your details, and step into the spotlight.</p>
        </div>
        
        <!-- Registration Type Selector -->
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="registration-type-tabs d-flex">
                    <div class="reg-type-btn active flex-fill" data-type="with_competition">
                        <i class="fas fa-trophy"></i> Register with Competition
                    </div>
                    <div class="reg-type-btn flex-fill" data-type="without_competition">
                        <i class="fas fa-user-plus"></i> Register without Competition
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabs -->
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="country-tabs d-flex">
                    <div class="tab-btn active flex-fill" data-tab="india"> 🇮🇳 India </div>
                    <div class="tab-btn flex-fill" data-tab="international"> 🌍 International </div>
                </div>
                <div class="offer-box" id="offerBox"> Register for 2+ competitions and get 10% OFF — use code <span>EDU10</span> </div>
                
                <!-- ============================================ -->
                <!-- INDIA FORM -->
                <!-- ============================================ -->
                <div id="india" class="tab-content-custom active">
                    <div class="form-card">
                        <div class="form-header">
                            <h4>India Student Registration</h4>
                            <small>For students from India • Prices in INR ₹</small> 
                        </div>
                        <div class="form-body">
                            <form id="registrationForm" method="POST" action="<?= base_url('register_process') ?>">
                                <input type="hidden" name="competition_type" value="india">
                                <input type="hidden" name="registration_type" id="india_registration_type" value="with_competition">
                                <input type="hidden" name="total_amount" id="india_total_amount" value="0">
                                
                                <!-- Competitions Selection -->
                                <div class="mb-4 competition-section" id="india_competition_section">
                                    <label class="form-label d-block mb-2 fw-bold"> Choose Competition / Olympiad </label>
                                    <?php if(!empty($activeCompetitions) || !empty($activeolympiads)): ?>
                                        <?php foreach($activeCompetitions as $comp): ?>
                                            <?php 
                                                $price = $comp->price_india ?? 0;
                                                $currency = '₹';
                                            ?>
                                            <div class="form-check">
                                                <input type="checkbox" name="competitions[]" 
                                                       value="<?= $comp->title ?> - <?= $currency ?><?= $price ?>" 
                                                       data-price="<?= $price ?>" 
                                                       class="competition-checkbox india-checkbox form-check-input" 
                                                       id="india_comp_<?= $comp->id ?>">
                                                <label class="form-check-label" for="india_comp_<?= $comp->id ?>">
                                                    <?= $comp->title ?> - <?= $currency ?><?= $price ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                        
                                        <?php foreach($activeolympiads as $comp): ?>
                                            <?php 
                                                $price = $comp->price_indian ?? 0;
                                                $currency = '₹';
                                            ?>
                                            <div class="form-check">
                                                <input type="checkbox" name="competitions[]" 
                                                       value="<?= $comp->title ?> - <?= $currency ?><?= $price ?>" 
                                                       data-price="<?= $price ?>" 
                                                       class="competition-checkbox india-checkbox form-check-input" 
                                                       id="india_comp_<?= $comp->id ?>">
                                                <label class="form-check-label" for="india_comp_<?= $comp->id ?>">
                                                    <?= $comp->title ?> - <?= $currency ?><?= $price ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-muted">No competitions available.</p>
                                    <?php endif; ?>
                                    <div id="india_total_display" class="mt-2 fw-bold text-primary">Total: ₹0</div>
                                </div>
                                
                                <!-- No Competition Message -->
                                <div class="mb-4 no-competition-message" id="india_no_comp_message" style="display: none;">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> You are registering without selecting any competition. You can always register for competitions later from your dashboard.
                                    </div>
                                </div>
                                
                                <!-- Personal Details -->
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Student Name *</label>
                                        <input type="text" name="student_name" class="form-control" placeholder="Enter student name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Class / Grade *</label>
                                        <input type="text" name="class_grade" class="form-control" placeholder="e.g. Class 5" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Mother/Father Name *</label>
                                        <input type="text" name="parent_name" class="form-control" placeholder="Enter parent name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Mobile Number *</label>
                                        <input type="tel" name="phone_register" class="form-control" placeholder="Enter mobile number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email ID *</label>
                                        <input type="email" name="email_register" class="form-control" placeholder="Enter email address" required>
                                    </div>
                                    
                                    <!-- Password Fields -->
                                    <div class="col-md-6">
                                        <label class="form-label">Password *</label>
                                        <div class="password-wrapper">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Create password (min 6 characters)" required minlength="6">
                                            <span class="password-toggle" onclick="togglePassword('password')">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                        <small class="text-muted">Password must be at least 6 characters</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Confirm Password *</label>
                                        <div class="password-wrapper">
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password" required>
                                            <span class="password-toggle" onclick="togglePassword('confirm_password')">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                        <small id="password_match_msg" class="text-muted"></small>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Address Line 1 *</label>
                                        <input type="text" name="address" class="form-control" placeholder="Enter address" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">City *</label>
                                        <input type="text" name="city" class="form-control" placeholder="Enter city" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Zip Code</label>
                                        <input type="text" name="zip_code" class="form-control" placeholder="Enter zip code">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">State *</label>
                                        <input type="text" name="state" class="form-control" placeholder="Enter state" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Date of Birth *</label>
                                        <input type="date" name="date_of_birth" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">School Name *</label>
                                        <select class="form-control" name="school_name" required>
                                            <option value="">-- Select school --</option>
                                            <?php foreach($school as $schoolrow) { ?>
                                            <option value="<?php echo $schoolrow->id; ?>"><?php echo $schoolrow->name; ?></option>
                                            <?php } ?>
                                            <option value="1">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">School Branch *</label>
                                        <input type="text" name="school_branch" class="form-control" placeholder="Enter school branch" required>
                                    </div>
                                    
                                    <!-- Terms and Conditions -->
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                            <label class="form-check-label" for="terms">
                                                I agree to the <a href="#" target="_blank">Terms and Conditions</a> and <a href="#" target="_blank">Privacy Policy</a> *
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <button type="submit" class="btn-register" id="register_btn"> 
                                            <i class="fas fa-lock"></i> PAY & REGISTER 
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- ============================================ -->
                <!-- INTERNATIONAL FORM -->
                <!-- ============================================ -->
                <div id="international" class="tab-content-custom">
                    <div class="form-card">
                        <div class="form-header">
                            <h4>International Student Registration</h4>
                            <small>For students outside India · Prices in USD $</small> 
                        </div>
                        <div class="form-body">
                            <form id="registrationFormInt" method="POST" action="<?= base_url('register_process') ?>">
                                <input type="hidden" name="competition_type" value="international">
                                <input type="hidden" name="registration_type" id="int_registration_type" value="with_competition">
                                <input type="hidden" name="total_amount" id="int_total_amount" value="0">
                                
                                <!-- Competitions Selection -->
                                <div class="mb-4 competition-section" id="int_competition_section">
                                    <label class="form-label d-block mb-2 fw-bold"> Choose the Competition / Olympiad You Wish to Register </label>
                                    <?php if(!empty($activeCompetitions) || !empty($activeolympiads)): ?>
                                        <?php foreach($activeCompetitions as $comp): ?>
                                            <?php 
                                                $price = $comp->price_international ?? 0;
                                                $currency = '$';
                                            ?>
                                            <div class="form-check">
                                                <input type="checkbox" name="competitions[]" 
                                                       value="<?= $comp->title ?> - <?= $currency ?><?= $price ?>" 
                                                       data-price="<?= $price ?>" 
                                                       class="competition-checkbox int-checkbox form-check-input" 
                                                       id="int_comp_<?= $comp->id ?>">
                                                <label class="form-check-label" for="int_comp_<?= $comp->id ?>">
                                                    <?= $comp->title ?> - <?= $currency ?><?= $price ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                        
                                        <?php foreach($activeolympiads as $comp): ?>
                                            <?php 
                                                $price = $comp->price_indian ?? 0;
                                                $currency = '₹';
                                            ?>
                                            <div class="form-check">
                                                <input type="checkbox" name="competitions[]" 
                                                       value="<?= $comp->title ?> - <?= $currency ?><?= $price ?>" 
                                                       data-price="<?= $price ?>" 
                                                       class="competition-checkbox int-checkbox form-check-input" 
                                                       id="int_comp_<?= $comp->id ?>">
                                                <label class="form-check-label" for="int_comp_<?= $comp->id ?>">
                                                    <?= $comp->title ?> - <?= $currency ?><?= $price ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-muted">No competitions available.</p>
                                    <?php endif; ?>
                                    <div id="int_total_display" class="mt-2 fw-bold text-primary">Total: $0</div>
                                </div>
                                
                                <!-- No Competition Message -->
                                <div class="mb-4 no-competition-message" id="int_no_comp_message" style="display: none;">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> You are registering without selecting any competition. You can always register for competitions later from your dashboard.
                                    </div>
                                </div>
                                
                                <!-- Personal Details -->
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Student Name *</label>
                                        <input type="text" name="student_name" class="form-control" placeholder="Enter student name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Class / Grade *</label>
                                        <input type="text" name="class_grade" class="form-control" placeholder="e.g. Class 5" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Mother/Father Name *</label>
                                        <input type="text" name="parent_name" class="form-control" placeholder="Enter parent name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Mobile Number *</label>
                                        <input type="tel" name="phone_register" class="form-control" placeholder="Enter mobile number with country code" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email ID *</label>
                                        <input type="email" name="email_register" class="form-control" placeholder="Enter email address" required>
                                    </div>
                                    
                                    <!-- Password Fields -->
                                    <div class="col-md-6">
                                        <label class="form-label">Password *</label>
                                        <div class="password-wrapper">
                                            <input type="password" name="password" id="password_int" class="form-control" placeholder="Create password (min 6 characters)" required minlength="6">
                                            <span class="password-toggle" onclick="togglePassword('password_int')">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                        <small class="text-muted">Password must be at least 6 characters</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Confirm Password *</label>
                                        <div class="password-wrapper">
                                            <input type="password" name="confirm_password" id="confirm_password_int" class="form-control" placeholder="Confirm password" required>
                                            <span class="password-toggle" onclick="togglePassword('confirm_password_int')">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                        <small id="password_match_msg_int" class="text-muted"></small>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Address Line 1 *</label>
                                        <input type="text" name="address" class="form-control" placeholder="Enter address" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">City *</label>
                                        <input type="text" name="city" class="form-control" placeholder="Enter city" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Zip Code</label>
                                        <input type="text" name="zip_code" class="form-control" placeholder="Enter zip code">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Country *</label>
                                        <select name="country" class="form-control" required>
                                            <option value="">Select Country</option>
                                            <option value="USA">USA</option>
                                            <option value="UK">UK</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Dubai">Dubai</option>
                                            <option value="Singapore">Singapore</option>
                                            <option value="Malaysia">Malaysia</option>
                                            <option value="New Zealand">New Zealand</option>
                                            <option value="South Africa">South Africa</option>
                                            <option value="Germany">Germany</option>
                                            <option value="France">France</option>
                                            <option value="Italy">Italy</option>
                                            <option value="Spain">Spain</option>
                                            <option value="Japan">Japan</option>
                                            <option value="China">China</option>
                                            <option value="South Korea">South Korea</option>
                                            <option value="Brazil">Brazil</option>
                                            <option value="Mexico">Mexico</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Date of Birth *</label>
                                        <input type="date" name="date_of_birth" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">School Name *</label>
                                        <select class="form-control" name="school_name" required>
                                            <option value="">-- Select school --</option>
                                            <?php foreach($school as $schoolrow) { ?>
                                            <option value="<?php echo $schoolrow->id; ?>"><?php echo $schoolrow->name; ?></option>
                                            <?php } ?>
                                            <option value="1">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">School Branch *</label>
                                        <input type="text" name="school_branch" class="form-control" placeholder="Enter school branch" required>
                                    </div>
                                    
                                    <!-- Terms and Conditions -->
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="terms_int" name="terms" required>
                                            <label class="form-check-label" for="terms_int">
                                                I agree to the <a href="#" target="_blank">Terms and Conditions</a> and <a href="#" target="_blank">Privacy Policy</a> *
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <button type="submit" class="btn-register" id="register_btn_int"> 
                                            <i class="fas fa-lock"></i> PAY & REGISTER 
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
</section>

<!-- ============================================ -->
<!-- CSS STYLES -->
<!-- ============================================ -->
<style>
.section-registration {
    padding: 60px 0;
    background: #f8f9fa;
}

.section-title h2 {
    font-size: 36px;
    font-weight: 700;
    color: #333;
    margin-bottom: 15px;
}

.section-title h2 span {
    color: #f15f25;
}

.section-title p {
    color: #666;
    font-size: 18px;
    margin-bottom: 30px;
}

.registration-type-tabs {
    background: #fff;
    border-radius: 50px;
    padding: 5px;
    margin-bottom: 20px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
}

.reg-type-btn {
    padding: 12px 20px;
    text-align: center;
    border-radius: 50px;
    cursor: pointer;
    font-weight: 600;
    color: #888;
    transition: all 0.3s ease;
    font-size: 16px;
}

.reg-type-btn.active {
    background: #f15f25;
    color: #fff;
    box-shadow: 0 4px 15px rgba(241, 95, 37, 0.3);
}

.reg-type-btn:hover:not(.active) {
    color: #f15f25;
}

.reg-type-btn i {
    margin-right: 8px;
}

.country-tabs {
    background: #fff;
    border-radius: 50px;
    padding: 5px;
    margin-bottom: 20px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
}

.tab-btn {
    padding: 12px 20px;
    text-align: center;
    border-radius: 50px;
    cursor: pointer;
    font-weight: 600;
    color: #888;
    transition: all 0.3s ease;
    font-size: 16px;
}

.tab-btn.active {
    background: #f15f25;
    color: #fff;
    box-shadow: 0 4px 15px rgba(241, 95, 37, 0.3);
}

.tab-btn:hover:not(.active) {
    color: #f15f25;
}

.offer-box {
    background: linear-gradient(135deg, #f15f25, #ff8a5c);
    color: #fff;
    padding: 12px 20px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 30px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.offer-box.hidden {
    display: none;
}

.offer-box span {
    background: #fff;
    color: #f15f25;
    padding: 2px 12px;
    border-radius: 5px;
    font-weight: 700;
}

.tab-content-custom {
    display: none;
    animation: fadeIn 0.5s ease;
}

.tab-content-custom.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.08);
    overflow: hidden;
}

.form-header {
    background: linear-gradient(135deg, #f15f25, #d44d1a);
    color: #fff;
    padding: 20px 30px;
}

.form-header h4 {
    font-size: 22px;
    margin-bottom: 5px;
}

.form-header small {
    opacity: 0.8;
    font-size: 14px;
}

.form-body {
    padding: 30px;
}

.form-label {
    font-weight: 600;
    color: #333;
    font-size: 14px;
    margin-bottom: 5px;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #f15f25;
    box-shadow: 0 0 0 3px rgba(241, 95, 37, 0.1);
}

.password-wrapper {
    position: relative;
}

.password-wrapper .form-control {
    padding-right: 45px;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #888;
    z-index: 10;
}

.password-toggle:hover {
    color: #f15f25;
}

.form-check {
    padding: 8px 0;
    border-bottom: 1px solid #f8f9fa;
}

.form-check:last-child {
    border-bottom: none;
}

.form-check-input {
    width: 18px;
    height: 18px;
    margin-top: 3px;
}

.form-check-input:checked {
    background-color: #f15f25;
    border-color: #f15f25;
}

.form-check-label {
    padding-left: 8px;
    font-size: 15px;
    color: #555;
}

.btn-register {
    background: linear-gradient(135deg, #f15f25, #d44d1a);
    color: #fff;
    border: none;
    padding: 14px 40px;
    border-radius: 50px;
    font-size: 18px;
    font-weight: 700;
    width: 100%;
    transition: all 0.3s ease;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(241, 95, 37, 0.4);
    color: #fff;
}

.btn-register:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.btn-register i {
    font-size: 16px;
}

.text-primary {
    color: #f15f25 !important;
}

.text-success {
    color: #28a745 !important;
}

.text-danger {
    color: #dc3545 !important;
}

.alert-info {
    background: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
    padding: 15px 20px;
    border-radius: 10px;
}

.alert-info i {
    margin-right: 10px;
}

.competition-section {
    transition: all 0.3s ease;
}

.competition-section.disabled {
    opacity: 0.5;
    pointer-events: none;
}

.no-competition-message {
    animation: fadeIn 0.5s ease;
}

/* Responsive */
@media (max-width: 768px) {
    .section-registration {
        padding: 40px 0;
    }
    
    .section-title h2 {
        font-size: 28px;
    }
    
    .form-body {
        padding: 20px;
    }
    
    .country-tabs, .registration-type-tabs {
        border-radius: 30px;
        flex-wrap: wrap;
    }
    
    .tab-btn, .reg-type-btn {
        font-size: 14px;
        padding: 10px 15px;
        flex: 1 1 50%;
    }
    
    .form-header {
        padding: 15px 20px;
    }
    
    .form-header h4 {
        font-size: 18px;
    }
}

@media (max-width: 576px) {
    .tab-btn, .reg-type-btn {
        font-size: 12px;
        padding: 8px 10px;
        flex: 1 1 100%;
    }
    
    .btn-register {
        font-size: 16px;
        padding: 12px 20px;
    }
}
</style>

<!-- ============================================ -->
<!-- JAVASCRIPT -->
<!-- ============================================ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
var BaseUrl = '<?php echo base_url(''); ?>/';

$(document).ready(function(){
    
    // ============================================
    // Registration Type Tabs
    // ============================================
    $('.reg-type-btn').on('click', function() {
        $('.reg-type-btn').removeClass('active');
        $(this).addClass('active');
        var regType = $(this).data('type');
        
        // Update hidden fields
        $('#india_registration_type').val(regType);
        $('#int_registration_type').val(regType);
        
        if (regType === 'without_competition') {
            // Hide competition sections and show info message
            $('.competition-section').addClass('disabled');
            $('.no-competition-message').show();
            $('#offerBox').addClass('hidden');
            
            // Uncheck all checkboxes and reset total
            $('.competition-checkbox').prop('checked', false);
            calculateTotal('india');
            calculateTotal('int');
        } else {
            // Show competition sections and hide info message
            $('.competition-section').removeClass('disabled');
            $('.no-competition-message').hide();
            $('#offerBox').removeClass('hidden');
        }
    });
    
    // ============================================
    // Password Toggle Function
    // ============================================
    window.togglePassword = function(inputId) {
        var input = document.getElementById(inputId);
        var icon = input.parentElement.querySelector('.password-toggle i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }
    
    // ============================================
    // Password Match Validation - India Form
    // ============================================
    $('#password, #confirm_password').on('keyup', function() {
        var password = $('#password').val();
        var confirm = $('#confirm_password').val();
        var msg = $('#password_match_msg');
        
        if (password.length > 0 && confirm.length > 0) {
            if (password === confirm) {
                msg.html('<i class="fas fa-check-circle text-success"></i> Passwords match');
                msg.removeClass('text-danger').addClass('text-success');
            } else {
                msg.html('<i class="fas fa-times-circle text-danger"></i> Passwords do not match');
                msg.removeClass('text-success').addClass('text-danger');
            }
        } else {
            msg.html('');
        }
    });
    
    // ============================================
    // Password Match Validation - International Form
    // ============================================
    $('#password_int, #confirm_password_int').on('keyup', function() {
        var password = $('#password_int').val();
        var confirm = $('#confirm_password_int').val();
        var msg = $('#password_match_msg_int');
        
        if (password.length > 0 && confirm.length > 0) {
            if (password === confirm) {
                msg.html('<i class="fas fa-check-circle text-success"></i> Passwords match');
                msg.removeClass('text-danger').addClass('text-success');
            } else {
                msg.html('<i class="fas fa-times-circle text-danger"></i> Passwords do not match');
                msg.removeClass('text-success').addClass('text-danger');
            }
        } else {
            msg.html('');
        }
    });
    
    // ============================================
    // Calculate total for India competitions
    // ============================================
    $('.india-checkbox').on('change', function() {
        calculateTotal('india');
    });
    
    // ============================================
    // Calculate total for International competitions
    // ============================================
    $('.int-checkbox').on('change', function() {
        calculateTotal('int');
    });
    
    function calculateTotal(type) {
        var total = 0;
        var prefix = type === 'india' ? 'india' : 'int';
        $('.' + prefix + '-checkbox:checked').each(function() {
            total += parseFloat($(this).data('price'));
        });
        $('#' + prefix + '_total_amount').val(total);
        var currency = type === 'india' ? '₹' : '$';
        $('#' + prefix + '_total_display').text('Total: ' + currency + total);
    }
    
    // ============================================
    // Tab functionality
    // ============================================
    $('.tab-btn').on('click', function() {
        $('.tab-btn').removeClass('active');
        $(this).addClass('active');
        var tabId = $(this).data('tab');
        $('.tab-content-custom').removeClass('active');
        $('#' + tabId).addClass('active');
    });
    
    // ============================================
    // Handle form submission - India Form
    // ============================================
    $('#registrationForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate password match
        var password = $('#password').val();
        var confirm = $('#confirm_password').val();
        
        if (password !== confirm) {
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'Passwords do not match! Please re-enter.',
                confirmButtonColor: '#f15f25'
            });
            return false;
        }
        
        if (password.length < 6) {
            Swal.fire({
                icon: 'error',
                title: 'Password Too Short',
                text: 'Password must be at least 6 characters long!',
                confirmButtonColor: '#f15f25'
            });
            return false;
        }
        
        submitForm($(this));
    });
    
    // ============================================
    // Handle form submission - International Form
    // ============================================
    $('#registrationFormInt').on('submit', function(e) {
        e.preventDefault();
        
        // Validate password match
        var password = $('#password_int').val();
        var confirm = $('#confirm_password_int').val();
        
        if (password !== confirm) {
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'Passwords do not match! Please re-enter.',
                confirmButtonColor: '#f15f25'
            });
            return false;
        }
        
        if (password.length < 6) {
            Swal.fire({
                icon: 'error',
                title: 'Password Too Short',
                text: 'Password must be at least 6 characters long!',
                confirmButtonColor: '#f15f25'
            });
            return false;
        }
        
        submitForm($(this));
    });
    
    // ============================================
    // Submit Form Function
    // ============================================
    function submitForm(form) {
        var btn = form.find('button[type="submit"]');
        var formData = form.serialize();
        
        // Check registration type
        var regType = form.find('input[name="registration_type"]').val();
        
        // If registering with competition, check if at least one competition is selected
        if (regType === 'with_competition') {
            var selectedCompetitions = form.find('.competition-checkbox:checked');
            if(selectedCompetitions.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Competition Selected',
                    text: 'Please select at least one competition to register.',
                    confirmButtonColor: '#f15f25'
                });
                return false;
            }
        }
        
        // Check if terms is checked
        if(!form.find('input[name="terms"]').is(':checked')) {
            Swal.fire({
                icon: 'warning',
                title: 'Terms & Conditions',
                text: 'Please accept the Terms and Conditions to proceed.',
                confirmButtonColor: '#f15f25'
            });
            return false;
        }
        
        // Disable button and show loading
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        $.ajax({
            url: BaseUrl + 'register_process',
            method: "POST",
            data: formData,
            dataType: "json",
            success: function(data) {
                btn.prop('disabled', false).html('<i class="fas fa-lock"></i> PAY & REGISTER');
                
                if(data.success) {
                    if(data.razorpay_order_id) {
                        // Open Razorpay payment gateway
                        openRazorpay(data);
                    } else {
                        // Free registration or no payment needed
                        Swal.fire({
                            icon: 'success',
                            title: 'Registration Successful!',
                            text: data.message || 'Your registration has been completed successfully.',
                            confirmButtonColor: '#f15f25'
                        }).then(function() {
                            window.location.href = BaseUrl + 'registration-success';
                        });
                    }
                } else {
                    if(data.errors) {
                        var errorMsg = '';
                        $.each(data.errors, function(key, value) {
                            errorMsg += value + '\n';
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: errorMsg,
                            confirmButtonColor: '#f15f25'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Registration Failed',
                            text: data.message || 'Something went wrong. Please try again.',
                            confirmButtonColor: '#f15f25'
                        });
                    }
                }
            },
            error: function(xhr, status, error) {
                btn.prop('disabled', false).html('<i class="fas fa-lock"></i> PAY & REGISTER');
                console.error('AJAX Error:', error);
                console.error('Response:', xhr.responseText);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Something went wrong. Please try again later.',
                    confirmButtonColor: '#f15f25'
                });
            }
        });
    }
    
    // ============================================
    // Open Razorpay Payment Gateway
    // ============================================
    function openRazorpay(data) {
        var options = {
            "key": data.razorpay_key_id,
            "amount": data.amount,
            "currency": data.currency,
            "name": "Competition Registration",
            "description": "Registration for competitions",
            "order_id": data.razorpay_order_id,
            "handler": function(response) {
                // Payment successful - verify payment
                verifyPayment(response, data.user_id);
            },
            "prefill": {
                "name": data.student_name,
                "email": data.email_register,
                "contact": data.phone_register
            },
            "theme": {
                "color": "#F37254"
            },
            "modal": {
                "ondismiss": function() {
                    Swal.fire({
                        icon: 'info',
                        title: 'Payment Cancelled',
                        text: 'You have cancelled the payment. You can complete it later from your dashboard.',
                        confirmButtonColor: '#f15f25'
                    });
                }
            }
        };
        
        var rzp = new Razorpay(options);
        rzp.open();
    }
    
    // ============================================
    // Verify Payment
    // ============================================
    function verifyPayment(response, userId) {
        // Show loading
        Swal.fire({
            title: 'Verifying Payment...',
            text: 'Please wait while we verify your payment.',
            allowOutsideClick: false,
            didOpen: function() {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: BaseUrl + 'verify_payment',
            method: "POST",
            data: {
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_order_id: response.razorpay_order_id,
                razorpay_signature: response.razorpay_signature,
                user_id: userId
            },
            dataType: "json",
            success: function(data) {
                if(data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Successful!',
                        text: 'Your payment has been verified and registration is complete.',
                        confirmButtonColor: '#f15f25'
                    }).then(function() {
                        window.location.href = BaseUrl + 'registration-success';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Verification Failed',
                        text: data.message || 'Please contact support for assistance.',
                        confirmButtonColor: '#f15f25'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Verification Error',
                    text: 'Error verifying payment. Please contact support.',
                    confirmButtonColor: '#f15f25'
                });
            }
        });
    }
});
</script>