<?php 
use App\Models\Commanmodel;
$commanmodel = new Commanmodel();
$session = session();
$usersession = $session->get('loggedin');

 $school = $commanmodel->all_multiple_query_order_by_limit('admin',array('status' => 'Active','admin_type' => 'School'),'id','ASC',100); 
   
   
?>
<style>
.single-product-tab ul.nav-tabs > li {
    display: inline-block;
    margin-right: 0px;
    -webkit-transition: all 0.5s ease-out;
    -moz-transition: all 0.5s ease-out;
    -ms-transition: all 0.5s ease-out;
    -o-transition: all 0.5s ease-out;
    transition: all 0.5s ease-out;
    width: 100%;
    margin-bottom: 2px;
}
.single-product-tab ul.nav-tabs > li a {
    font-size: 15px; 
    width: 100%;
}
.single-product-tab .tab-content {
    padding: 0px 30px;
}
.single-product-tab {
    margin-bottom: 0px;
    position: relative;
}
th {
    text-align: center;
}
label {
    display: block;
    margin-bottom: .5rem;
    font-size: 14px;
}
.form-control {
    display: block;
    width: 100%;
    padding: 10px;
    font-size: 14px;
    line-height: 1.25;
    color: #495057;
    background-color: #fff;
    background-image: none;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, .15);
    border-radius: .25rem;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    font-weight: 500;
}
.single-input-item { 
    margin-bottom: 15px;
}
select.form-control:not([size]):not([multiple]) {
    height: inherit;
}
.btns {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    padding: .5rem .75rem;
    font-size: 14px;
    padding: 14px 30px;
    background: #016eb4;
    transition: all .15s ease-in-out;
    color: #fff;
    border-radius: 10px;
    cursor: pointer;
}
.btns:hover {
    background: #015a96;
    color: #fff;
}
.btns-danger {
    background: #dc3545;
}
.btns-danger:hover {
    background: #c82333;
}
body {
    background-color: #eeeeee;
}
.nav-tabs .nav-item.show .nav-link, 
.nav-tabs .nav-link.active {
    color: #fff;
    background-color: #f15f25;
    border-color: var(--bs-nav-tabs-link-active-border-color);
}
.nav-tabs .nav-link {
    background: #000;
    color: #fff;
    border: 0px;
    border-radius: 3px;
}
.nav-tabs .nav-item button {
    width: 100%; 
    text-align: left;
    padding: 12px 20px;
}

/* Competition Registration Card */
.registration-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 15px 20px;
    margin-bottom: 15px;
    border-left: 4px solid #f15f25;
    transition: all 0.3s ease;
}
.registration-card:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transform: translateX(5px);
}
.registration-card .comp-name {
    font-weight: 600;
    font-size: 16px;
    color: #333;
}
.registration-card .comp-price {
    color: #f15f25;
    font-weight: 600;
}
.registration-card .comp-status {
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
    margin-right: 5px;
}
.status-confirmed {
    background: #d4edda;
    color: #155724;
}
.status-pending {
    background: #fff3cd;
    color: #856404;
}
.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}
.status-completed {
    background: #cce5ff;
    color: #004085;
}
.status-failed {
    background: #f8d7da;
    color: #721c24;
}
.badge-success {
    background: #28a745;
    color: #fff;
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 12px;
    display: inline-block;
}
.badge-warning {
    background: #ffc107;
    color: #333;
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 12px;
    display: inline-block;
}
.badge-danger {
    background: #dc3545;
    color: #fff;
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 12px;
    display: inline-block;
}
.comp-meta {
    font-size: 13px;
    color: #888;
    margin-top: 5px;
}
.comp-meta span {
    margin-right: 15px;
}
.no-data {
    text-align: center;
    padding: 40px;
    color: #888;
}
.no-data i {
    font-size: 48px;
    margin-bottom: 15px;
    color: #ddd;
}
.no-data .btns {
    margin-top: 15px;
}

/* Alert Styles */
.alert-custom {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: none;
}
.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
.alert-warning {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
}

/* Card Stats */
.card-stats {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    transition: all 0.3s ease;
}
.card-stats:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.card-stats h2 {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 5px;
}
.card-stats p {
    color: #888;
    margin-bottom: 0;
}
.color-orange { color: #f15f25; }
.color-green { color: #28a745; }
.color-yellow { color: #ffc107; }
</style>

<section class="about-section inner-padding">
    <!-- entry-header-area-start -->
    <div class="entry-header-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="entry-header-title">
                        <h2>My Account</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- entry-header-area-end -->

    <!-- my account wrapper start -->
    <div class="my-account-wrapper" style="padding:20px 0px">
        <div class="container">
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Alert Message -->
                        <div id="alertMessage" class="alert-custom"></div>
                        
                        <div class="single-product-tab">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <button class="nav-link active"
                                                    id="home-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#home"
                                                    type="button"
                                                    role="tab">
                                                <i class="fas fa-home"></i> Dashboard
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link"
                                                    id="registrations-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#registrations"
                                                    type="button"
                                                    role="tab">
                                                <i class="fas fa-trophy"></i> My Competitions
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link"
                                                    id="profile-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#profile"
                                                    type="button"
                                                    role="tab">
                                                <i class="fas fa-user"></i> Account Details
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link"
                                                    id="password-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#password"
                                                    type="button"
                                                    role="tab">
                                                <i class="fas fa-key"></i> Change Password
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo base_url('logout'); ?>" style="background: #dc3545; color: #fff; padding: 12px 20px; border-radius: 3px; display: block; text-align: left; text-decoration: none;">
                                                <i class="fas fa-sign-out-alt"></i> Logout
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    <div class="tab-content border border-top-0 p-4" id="myTabContent" style="background: #fff; min-height: 500px;">
                                        
                                        <!-- ========================================== -->
                                        <!-- DASHBOARD TAB -->
                                        <!-- ========================================== -->
                                        <div class="tab-pane fade show active" id="home" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3>Dashboard</h3>
                                                <p>Hello, <strong><?php echo $userdata->student_name ?? $userdata->user_name ?? ''; ?></strong></p>
                                                <p>From your account dashboard, you can view your <strong>competition registrations</strong> and update your <strong>account details</strong>.</p>
                                                
                                                <?php 
                                                    $total = count($registrations ?? []);
                                                    $confirmed = 0;
                                                    $pending = 0;
                                                    foreach($registrations ?? [] as $r) {
                                                        if($r->payment_status == 'completed') {
                                                            $confirmed++;
                                                        } elseif($r->payment_status == 'pending') {
                                                            $pending++;
                                                        }
                                                    }
                                                ?>
                                                
                                                <div class="row mt-4">
                                                    <div class="col-md-4">
                                                        <div class="card-stats">
                                                            <h2 class="color-orange"><?php echo $total; ?></h2>
                                                            <p>Total Registrations</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="card-stats">
                                                            <h2 class="color-green"><?php echo $confirmed; ?></h2>
                                                            <p>Confirmed Registrations</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="card-stats">
                                                            <h2 class="color-yellow"><?php echo $pending; ?></h2>
                                                            <p>Pending Registrations</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- ========================================== -->
                                        <!-- COMPETITION REGISTRATIONS TAB -->
                                        <!-- ========================================== -->
                                        <div class="tab-pane fade" id="registrations" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3>My Competition Registrations</h3>
                                                <p>View all your competition registrations and their status.</p>
                                                
                                                <?php if(!empty($registrations)): ?>
                                                    <?php foreach($registrations as $reg): ?>
                                                    <div class="registration-card">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-4">
                                                                <div class="comp-name"><?php echo $reg->competition_name ?? 'N/A'; ?></div>
                                                                <div class="comp-meta">
                                                                    <span><i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($reg->created_at ?? date('Y-m-d'))); ?></span>
                                                                    <span><i class="fas fa-tag"></i> <?php echo ucfirst($reg->competition_type ?? 'India'); ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="comp-price"><?php echo ($reg->competition_type == 'india' ? '₹' : '$') . number_format($reg->competition_price ?? 0, 2); ?></div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <span class="comp-status status-<?php echo strtolower($reg->payment_status ?? 'pending'); ?>">
                                                                    <?php echo ucfirst($reg->payment_status ?? 'Pending'); ?>
                                                                </span>
                                                                <span class="comp-status status-<?php echo strtolower($reg->registration_status ?? 'pending'); ?>">
                                                                    <?php echo ucfirst($reg->registration_status ?? 'Pending'); ?>
                                                                </span>
                                                            </div>
                                                            <div class="col-md-2 text-end">
                                                                <?php if($reg->payment_status == 'pending'): ?>
                                                                    <a href="<?php echo base_url('payment/'.$reg->id); ?>" class="btn btn-sm btn-primary">Pay Now</a>
                                                                <?php elseif($reg->payment_status == 'completed'): ?>
                                                                    <span class="badge-success"><i class="fas fa-check"></i> Paid</span>
                                                                <?php else: ?>
                                                                    <span class="badge-danger"><i class="fas fa-times"></i> Failed</span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <?php if($reg->razorpay_payment_id): ?>
                                                        <div class="comp-meta mt-2">
                                                            <span><i class="fas fa-credit-card"></i> Payment ID: <?php echo $reg->razorpay_payment_id; ?></span>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <div class="no-data">
                                                        <i class="fas fa-trophy"></i>
                                                        <p>You haven't registered for any competition yet.</p>
                                                        <a href="<?php echo base_url('register'); ?>" class="btns">Register Now</a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <!-- ========================================== -->
                                        <!-- ACCOUNT DETAILS TAB - Registration Form Fields -->
                                        <!-- ========================================== -->
                                        <div class="tab-pane fade" id="profile" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3>Account Details</h3>
                                                <p>Update your profile information</p>
                                                <div class="account-details-form">
                                                    <form id="updateUser" method="post">
                                                        <div class="row">
                                                            <!-- Student Name -->
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label>Student Name *</label>
                                                                    <input type="text" name="student_name" class="form-control" value="<?php echo $userdata->student_name ?? $userdata->user_name ?? ''; ?>" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Class/Grade -->
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label>Class / Grade *</label>
                                                                    <input type="text" name="class_grade" class="form-control" value="<?php echo $userdata->class_grade ?? ''; ?>" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Parent Name -->
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label>Mother/Father Name *</label>
                                                                    <input type="text" name="parent_name" class="form-control" value="<?php echo $userdata->parent_name ?? ''; ?>" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Mobile Number -->
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label>Mobile Number *</label>
                                                                    <input type="text" name="user_phone" class="form-control" value="<?php echo $userdata->user_phone ?? ''; ?>" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Email ID -->
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label>Email ID *</label>
                                                                    <input type="email" name="user_email" class="form-control" value="<?php echo $userdata->user_email ?? ''; ?>" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Date of Birth -->
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label>Date of Birth *</label>
                                                                    <input type="date" name="date_of_birth" class="form-control" value="<?php echo $userdata->date_of_birth ?? ''; ?>" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Gender -->
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label>Gender</label>
                                                                    <select name="gender" class="form-control">
                                                                        <option value="">Select</option>
                                                                        <option value="Male" <?php if(($userdata->gender ?? '') == 'Male') echo 'selected'; ?>>Male</option>
                                                                        <option value="Female" <?php if(($userdata->gender ?? '') == 'Female') echo 'selected'; ?>>Female</option>
                                                                        <option value="Other" <?php if(($userdata->gender ?? '') == 'Other') echo 'selected'; ?>>Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                            
                                                            
                                                            <!-- Address -->
                                                            <div class="col-lg-12">
                                                                <div class="single-input-item">
                                                                    <label>Address Line 1 *</label>
                                                                    <input type="text" name="user_address" class="form-control" value="<?php echo $userdata->user_address ?? ''; ?>" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- City -->
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label>City *</label>
                                                                    <input type="text" name="city" class="form-control" value="<?php echo $userdata->city ?? ''; ?>" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- State -->
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label>State *</label>
                                                                    <input type="text" name="state" class="form-control" value="<?php echo $userdata->state ?? ''; ?>" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Zip Code -->
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label>Zip Code</label>
                                                                    <input type="text" name="zip_code" class="form-control" value="<?php echo $userdata->zip_code ?? ''; ?>">
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Country (For International) -->
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label>Country</label>
                                                                    <select name="country" class="form-control">
                                                                        <option value="">Select Country</option>
                                                                          <option value="India" <?php if(($userdata->country ?? '') == 'India') echo 'selected'; ?>>India</option>
                                                                        <option value="USA" <?php if(($userdata->country ?? '') == 'USA') echo 'selected'; ?>>USA</option>
                                                                        <option value="UK" <?php if(($userdata->country ?? '') == 'UK') echo 'selected'; ?>>UK</option>
                                                                        <option value="Canada" <?php if(($userdata->country ?? '') == 'Canada') echo 'selected'; ?>>Canada</option>
                                                                        <option value="Australia" <?php if(($userdata->country ?? '') == 'Australia') echo 'selected'; ?>>Australia</option>
                                                                        <option value="Dubai" <?php if(($userdata->country ?? '') == 'Dubai') echo 'selected'; ?>>Dubai</option>
                                                                        <option value="Singapore" <?php if(($userdata->country ?? '') == 'Singapore') echo 'selected'; ?>>Singapore</option>
                                                                        <option value="Malaysia" <?php if(($userdata->country ?? '') == 'Malaysia') echo 'selected'; ?>>Malaysia</option>
                                                                        <option value="Other" <?php if(($userdata->country ?? '') == 'Other') echo 'selected'; ?>>Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- School Name -->
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label>School Name *</label>
                                                                    <input type="text" name="school_name" class="form-control" value="<?php echo $userdata->school_name ?? ''; ?>" required>
                                                                            <select class="form-control" name="school_name" required>
                                        <option value="">-- Select school --</option>
                                        <?php foreach($school as $schoolrow) { ?>
                                        <option value="<?php echo $schoolrow->id; ?>" <?php if($userdata->school_name  == $schoolrow->id) echo 'selected'; ?>><?php echo $schoolrow->name; ?></option>
                                       
                                        <?php } ?>
                                        <option value="1">Other</option>
                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- School Branch -->
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label>School Branch *</label>
                                                                    <input type="text" name="school_branch" class="form-control" value="<?php echo $userdata->school_branch ?? ''; ?>" required>
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Competition Type (Hidden or Display) -->
                                                            <div class="col-lg-12">
                                                                <div class="single-input-item">
                                                                    <label>Competition Type</label>
                                                                    <select name="competition_type" class="form-control">
                                                                        <option value="india" <?php if(($userdata->competition_type ?? '') == 'india') echo 'selected'; ?>>India</option>
                                                                        <option value="international" <?php if(($userdata->competition_type ?? '') == 'international') echo 'selected'; ?>>International</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="single-input-item mt-3">
                                                            <button class="btns" type="submit"><i class="fas fa-save"></i> Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- ========================================== -->
                                        <!-- CHANGE PASSWORD TAB -->
                                        <!-- ========================================== -->
                                        <div class="tab-pane fade" id="password" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3>Change Password</h3>
                                                <div class="account-details-form">
                                                    <form id="updatePassword" method="post">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="single-input-item">
                                                                    <label>Current Password *</label>
                                                                    <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="single-input-item">
                                                                    <label>New Password *</label>
                                                                    <input type="password" name="new_password" class="form-control" placeholder="Enter new password (min 6 characters)" required minlength="6">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="single-input-item">
                                                                    <label>Confirm New Password *</label>
                                                                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="single-input-item mt-3">
                                                            <button class="btns" type="submit" id="updatePasswordBtn"><i class="fas fa-key"></i> Update Password</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- my account wrapper end -->
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    
    // ============================================
    // Update User Profile
    // ============================================
    $('#updateUser').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData($(this)[0]);
        var btn = $(this).find('button[type="submit"]');
        var alertDiv = $('#alertMessage');
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        alertDiv.hide();
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('update-user'); ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(data) {
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Save Changes');
                
                alertDiv.removeClass('alert-success alert-error alert-warning')
                        .addClass('alert-' + data.class)
                        .html('<i class="fas fa-' + (data.class == 'success' ? 'check-circle' : 'exclamation-circle') + '"></i> ' + data.message)
                        .show();
                
                setTimeout(function() {
                    alertDiv.fadeOut();
                }, 5000);
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Save Changes');
                alertDiv.removeClass('alert-success alert-error alert-warning')
                        .addClass('alert-error')
                        .html('<i class="fas fa-exclamation-circle"></i> Something went wrong. Please try again.')
                        .show();
            }
        });
    });
    
    // ============================================
    // Update Password
    // ============================================
    $('#updatePassword').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData($(this)[0]);
        var btn = $(this).find('button[type="submit"]');
        var alertDiv = $('#alertMessage');
        
        // Validate password match
        var newPassword = $('input[name="new_password"]').val();
        var confirmPassword = $('input[name="confirm_password"]').val();
        
        if(newPassword !== confirmPassword) {
            alertDiv.removeClass('alert-success alert-error alert-warning')
                    .addClass('alert-error')
                    .html('<i class="fas fa-exclamation-circle"></i> New passwords do not match!')
                    .show();
            return false;
        }
        
        if(newPassword.length < 6) {
            alertDiv.removeClass('alert-success alert-error alert-warning')
                    .addClass('alert-error')
                    .html('<i class="fas fa-exclamation-circle"></i> Password must be at least 6 characters!')
                    .show();
            return false;
        }
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
        alertDiv.hide();
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('update-password'); ?>",
            processData: false,
            contentType: false,
            dataType: "JSON",
            data: formData,
            success: function(data) {
                btn.prop('disabled', false).html('<i class="fas fa-key"></i> Update Password');
                
                alertDiv.removeClass('alert-success alert-error alert-warning')
                        .addClass('alert-' + data.class)
                        .html('<i class="fas fa-' + (data.class == 'success' ? 'check-circle' : 'exclamation-circle') + '"></i> ' + data.message)
                        .show();
                
                if(data.class == 'success') {
                    $('#updatePassword')[0].reset();
                }
                
                setTimeout(function() {
                    alertDiv.fadeOut();
                }, 5000);
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fas fa-key"></i> Update Password');
                alertDiv.removeClass('alert-success alert-error alert-warning')
                        .addClass('alert-error')
                        .html('<i class="fas fa-exclamation-circle"></i> Something went wrong. Please try again.')
                        .show();
            }
        });
    });
    
});
</script>