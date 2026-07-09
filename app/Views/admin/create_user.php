<!-- create_user.php - School Registration Form -->
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Register New School</h1>
                <p class="breadcrumbs">
                    <span><a href="#">Schools</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Register School
                </p>
            </div>
            <div>
                <a href="<?php echo base_url('admin/user'); ?>" class="btn btn-primary">
                    <i class="mdi mdi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="ec-cat-list card card-default">
                    <?php if(session()->getFlashdata('failed')): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <?= session()->getFlashdata('failed') ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo base_url('admin/create_user_process'); ?>" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="school_name">School Name *</label>
                                        <input type="text" required class="form-control" name="school_name" placeholder="Enter school name" value="<?= old('school_name') ?>">
                                        <?php if(isset($validation['school_name'])): ?>
                                            <small class="text-danger"><?= $validation['school_name'] ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" required class="form-control" name="email" placeholder="Enter email address" value="<?= old('email') ?>">
                                        <?php if(isset($validation['email'])): ?>
                                            <small class="text-danger"><?= $validation['email'] ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone Number *</label>
                                        <input type="text" required class="form-control" name="phone" placeholder="Enter phone number" value="<?= old('phone') ?>">
                                        <?php if(isset($validation['phone'])): ?>
                                            <small class="text-danger"><?= $validation['phone'] ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="principal_name">Principal Name *</label>
                                        <input type="text" required class="form-control" name="principal_name" placeholder="Enter principal name" value="<?= old('principal_name') ?>">
                                        <?php if(isset($validation['principal_name'])): ?>
                                            <small class="text-danger"><?= $validation['principal_name'] ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="principal_phone">Principal Phone</label>
                                        <input type="text" class="form-control" name="principal_phone" placeholder="Enter principal phone" value="<?= old('principal_phone') ?>">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="affiliation">Affiliation</label>
                                        <input type="text" class="form-control" name="affiliation" placeholder="e.g. CBSE, ICSE, State Board" value="<?= old('affiliation') ?>">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="established_year">Established Year</label>
                                        <select class="form-control" name="established_year">
                                            <option value="">Select Year</option>
                                            <?php for($year = date('Y'); $year >= 1950; $year--): ?>
                                                <option value="<?= $year ?>" <?= old('established_year') == $year ? 'selected' : '' ?>><?= $year ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">School Address</label>
                                        <textarea class="form-control" name="address" rows="3" placeholder="Enter school address"><?= old('address') ?></textarea>
                                    </div>
                                </div>
                                
                  
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pincode">City</label>
                                        <input type="text" class="form-control" name="city" placeholder="Enter city" value="<?= old('city') ?>">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pincode">State</label>
                                        <input type="text" class="form-control" name="state" placeholder="Enter state" value="<?= old('state') ?>">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pincode">Pincode</label>
                                        <input type="text" class="form-control" name="pincode" placeholder="Enter pincode" value="<?= old('pincode') ?>">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo">School Logo</label>
                                        <input type="file" class="form-control" name="logo" accept="image/*">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status *</label>
                                        <select class="form-control" required name="status">
                                            <option value="Active" <?= old('status') == 'Active' ? 'selected' : '' ?>>Active</option>
                                            <option value="Inactive" <?= old('status') == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password *</label>
                                        <input type="password" required class="form-control" name="password" placeholder="Enter password">
                                        <?php if(isset($validation['password'])): ?>
                                            <small class="text-danger"><?= $validation['password'] ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password *</label>
                                        <input type="password" required class="form-control" name="confirm_password" placeholder="Confirm password">
                                        <?php if(isset($validation['confirm_password'])): ?>
                                            <small class="text-danger"><?= $validation['confirm_password'] ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="white_card-footer" style="text-align: center;">
                            <input type="submit" name="CreateNewProduct" value="Register School" class="btn btn-primary">
                            <a href="<?php echo base_url('admin/user'); ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>