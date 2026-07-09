<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Competitions</h1>
                <p class="breadcrumbs">
                    <span><a href="#">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Competitions
                </p>
            </div>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCompetitionModal">
                    <i class="mdi mdi-plus"></i> Add New Competition
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
                            <table id="competition_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Title</th>
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

<!-- ============ ADD COMPETITION MODAL ============ -->
<div class="modal fade" id="addCompetitionModal" tabindex="-1" aria-labelledby="addCompetitionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="<?php echo base_url('admin/add_competition'); ?>" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Competition</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Basic Information -->
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Basic Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="title" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Main Image <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" name="image" accept="image/*" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hero Section -->
                    <div class="card mb-3">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">Hero Section</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Hero Title</label>
                                        <input type="text" class="form-control" name="hero_title" placeholder="Poster Making Competition">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status Badge</label>
                                        <input type="text" class="form-control" name="hero_status_badge" placeholder="Registrations Open">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Hero Description</label>
                                        <textarea class="form-control" name="hero_description" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Registration Deadline</label>
                                        <input type="date" class="form-control" name="registration_deadline">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Submission Deadline</label>
                                        <input type="date" class="form-control" name="submission_deadline">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Price (India)</label>
                                        <input type="text" class="form-control" name="price_india" placeholder="₹500">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Price (International)</label>
                                        <input type="text" class="form-control" name="price_international" placeholder="$10">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Poster Card -->
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">Poster Card</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Poster Card Title</label>
                                        <input type="text" class="form-control" name="poster_card_title" placeholder="Poster Making Competition 2026">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Poster Card Image</label>
                                        <input type="file" class="form-control" name="poster_card_image" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Poster Card Description</label>
                                        <textarea class="form-control" name="poster_card_description" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Counter Section -->
                    <div class="card mb-3">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0">Counter Items</h6>
                        </div>
                        <div class="card-body">
                            <div id="add_counter_items">
                                <div class="row counter-item">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Icon</label>
                                            <input type="text" class="form-control" name="counter_icon[]" placeholder="🎨">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Text</label>
                                            <input type="text" class="form-control" name="counter_text[]" placeholder="5">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Subtext</label>
                                            <input type="text" class="form-control" name="counter_subtext[]" placeholder="Grade Categories">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger mt-4 remove-counter">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" onclick="addCounterItem()">+ Add Counter Item</button>
                        </div>
                    </div>

                    <!-- Features Section - Only Icon Image -->
                    <div class="card mb-3">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0">Features</h6>
                        </div>
                        <div class="card-body">
                            <div id="add_features">
                                <div class="row feature-item">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Icon Image</label>
                                            <input type="file" class="form-control" name="feature_icon_image[]" accept="image/*">
                                            <small class="text-muted">Upload icon</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="feature_title[]" placeholder="Hand-Made Posters">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" name="feature_description[]" placeholder="Only original, hand-made posters">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger mt-4 remove-feature">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" onclick="addFeature()">+ Add Feature</button>
                        </div>
                    </div>

                    <!-- Categories & Themes -->
                    <div class="card mb-3">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">Categories & Themes</h6>
                        </div>
                        <div class="card-body">
                            <div id="add_categories">
                                <div class="category-item border p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Category Badge</label>
                                                <input type="text" class="form-control" name="category_badge[]" placeholder="CATEGORY 1">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Category Title</label>
                                                <input type="text" class="form-control" name="category_title[]" placeholder="Kindergarten — Below Grade 1">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Color</label>
                                                <select class="form-control" name="category_color[]">
                                                    <option value="category-pink">Pink</option>
                                                    <option value="category-yellow">Yellow</option>
                                                    <option value="category-green">Green</option>
                                                    <option value="category-blue">Blue</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger mt-4 remove-category">Remove</button>
                                        </div>
                                    </div>
                                    <div class="themes-container">
                                        <div class="theme-item row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Theme Icon</label>
                                                    <input type="text" class="form-control" name="theme_icon[]" placeholder="🌻">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Theme Title</label>
                                                    <input type="text" class="form-control" name="theme_title[]" placeholder="My Happy Garden">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Theme Description</label>
                                                    <input type="text" class="form-control" name="theme_description[]" placeholder="Draw a colourful garden...">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger mt-4 remove-theme">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addTheme(this)">+ Add Theme</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" onclick="addCategory()">+ Add Category</button>
                        </div>
                    </div>

                    <!-- Submission Requirements -->
                    <div class="card mb-3">
                        <div class="card-header bg-dark text-white">
                            <h6 class="mb-0">Submission Requirements</h6>
                        </div>
                        <div class="card-body">
                            <div id="add_requirements">
                                <div class="row requirement-item">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Icon</label>
                                            <input type="text" class="form-control" name="requirement_icon[]" placeholder="1f5bc.svg">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="requirement_title[]" placeholder="Poster Photo">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" name="requirement_description[]" placeholder="A clear JPG or PNG image...">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger mt-4 remove-requirement">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" onclick="addRequirement()">+ Add Requirement</button>
                        </div>
                    </div>

                    <!-- Prizes -->
                    <div class="card mb-3">
                        <div class="card-header" style="background: linear-gradient(45deg, #f7971e, #ffd200);">
                            <h6 class="mb-0">Prizes</h6>
                        </div>
                        <div class="card-body">
                            <div id="add_prizes">
                                <div class="row prize-item">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select class="form-control" name="prize_type[]">
                                                <option value="winner">Winner</option>
                                                <option value="runner">Runner Up</option>
                                                <option value="outstanding">Outstanding</option>
                                                <option value="participant">Participant</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Icon</label>
                                            <input type="text" class="form-control" name="prize_icon[]" placeholder="🥇">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="prize_title[]" placeholder="One Winner">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Items (comma separated)</label>
                                            <input type="text" class="form-control" name="prize_items[]" placeholder="🏆 Trophy, 🥇 Gold Medal">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger mt-4 remove-prize">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" onclick="addPrize()">+ Add Prize</button>
                        </div>
                    </div>

                    <!-- FAQs -->
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">FAQs</h6>
                        </div>
                        <div class="card-body">
                            <div id="add_faqs">
                                <div class="row faq-item">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Question</label>
                                            <input type="text" class="form-control" name="faq_question[]" placeholder="What age group do you accept?">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Answer</label>
                                            <input type="text" class="form-control" name="faq_answer[]" placeholder="We accept students from KG to Grade 12">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger mt-4 remove-faq">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" onclick="addFaq()">+ Add FAQ</button>
                        </div>
                    </div>

                    <!-- How to Participate -->
                    <div class="card mb-3">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">How to Participate</h6>
                        </div>
                        <div class="card-body">
                            <div id="add_steps">
                                <div class="row step-item">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Icon</label>
                                            <input type="text" class="form-control" name="step_icon[]" placeholder="icon1.svg">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="step_title[]" placeholder="Register">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" name="step_description[]" placeholder="Click the Register button...">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger mt-4 remove-step">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" onclick="addStep()">+ Add Step</button>
                        </div>
                    </div>

                    <!-- SEO -->
                    <div class="card mb-3">
                        <div class="card-header bg-dark text-white">
                            <h6 class="mb-0">SEO Settings</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <input type="text" class="form-control" name="meta_keywords" placeholder="competition, poster, contest">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <input type="text" class="form-control" name="meta_description" placeholder="Brief description for SEO">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Competition</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============ EDIT COMPETITION MODAL ============ -->
<div class="modal fade" id="editCompetitionModal" tabindex="-1" aria-labelledby="editCompetitionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="<?php echo base_url('admin/update_competition'); ?>" enctype="multipart/form-data">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Competition</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Basic Information -->
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Basic Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edit_title" name="title" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" id="edit_status" name="status">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Main Image</label>
                                        <input type="file" class="form-control" name="image" accept="image/*">
                                        <small class="text-muted">Leave empty to keep current image</small>
                                        <div id="current_image_preview" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hero Section -->
                    <div class="card mb-3">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">Hero Section</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Hero Title</label>
                                        <input type="text" class="form-control" id="edit_hero_title" name="hero_title" placeholder="Poster Making Competition">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status Badge</label>
                                        <input type="text" class="form-control" id="edit_hero_status_badge" name="hero_status_badge" placeholder="Registrations Open">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Hero Description</label>
                                        <textarea class="form-control" id="edit_hero_description" name="hero_description" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Registration Deadline</label>
                                        <input type="date" class="form-control" id="edit_registration_deadline" name="registration_deadline">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Submission Deadline</label>
                                        <input type="date" class="form-control" id="edit_submission_deadline" name="submission_deadline">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Price (India)</label>
                                        <input type="text" class="form-control" id="edit_price_india" name="price_india" placeholder="₹500">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Price (International)</label>
                                        <input type="text" class="form-control" id="edit_price_international" name="price_international" placeholder="$10">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Poster Card -->
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">Poster Card</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Poster Card Title</label>
                                        <input type="text" class="form-control" id="edit_poster_card_title" name="poster_card_title" placeholder="Poster Making Competition 2026">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Poster Card Image</label>
                                        <input type="file" class="form-control" name="poster_card_image" accept="image/*">
                                        <small class="text-muted">Leave empty to keep current image</small>
                                        <div id="current_poster_preview" class="mt-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Poster Card Description</label>
                                        <textarea class="form-control" id="edit_poster_card_description" name="poster_card_description" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Counter Section -->
                    <div class="card mb-3">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0">Counter Items</h6>
                        </div>
                        <div class="card-body">
                            <div id="edit_counter_items"></div>
                            <button type="button" class="btn btn-success" onclick="addEditCounterItem()">+ Add Counter Item</button>
                        </div>
                    </div>

                    <!-- Features Section - Only Icon Image -->
                    <div class="card mb-3">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0">Features</h6>
                        </div>
                        <div class="card-body">
                            <div id="edit_features"></div>
                            <button type="button" class="btn btn-success" onclick="addEditFeature()">+ Add Feature</button>
                        </div>
                    </div>

                    <!-- Categories & Themes -->
                    <div class="card mb-3">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">Categories & Themes</h6>
                        </div>
                        <div class="card-body">
                            <div id="edit_categories"></div>
                            <button type="button" class="btn btn-success" onclick="addEditCategory()">+ Add Category</button>
                        </div>
                    </div>

                    <!-- Submission Requirements -->
                    <div class="card mb-3">
                        <div class="card-header bg-dark text-white">
                            <h6 class="mb-0">Submission Requirements</h6>
                        </div>
                        <div class="card-body">
                            <div id="edit_requirements"></div>
                            <button type="button" class="btn btn-success" onclick="addEditRequirement()">+ Add Requirement</button>
                        </div>
                    </div>

                    <!-- Prizes -->
                    <div class="card mb-3">
                        <div class="card-header" style="background: linear-gradient(45deg, #f7971e, #ffd200);">
                            <h6 class="mb-0">Prizes</h6>
                        </div>
                        <div class="card-body">
                            <div id="edit_prizes"></div>
                            <button type="button" class="btn btn-success" onclick="addEditPrize()">+ Add Prize</button>
                        </div>
                    </div>

                    <!-- FAQs -->
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">FAQs</h6>
                        </div>
                        <div class="card-body">
                            <div id="edit_faqs"></div>
                            <button type="button" class="btn btn-success" onclick="addEditFaq()">+ Add FAQ</button>
                        </div>
                    </div>

                    <!-- How to Participate -->
                    <div class="card mb-3">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">How to Participate</h6>
                        </div>
                        <div class="card-body">
                            <div id="edit_steps"></div>
                            <button type="button" class="btn btn-success" onclick="addEditStep()">+ Add Step</button>
                        </div>
                    </div>

                    <!-- SEO -->
                    <div class="card mb-3">
                        <div class="card-header bg-dark text-white">
                            <h6 class="mb-0">SEO Settings</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <input type="text" class="form-control" id="edit_meta_keywords" name="meta_keywords" placeholder="competition, poster, contest">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <input type="text" class="form-control" id="edit_meta_description" name="meta_description" placeholder="Brief description for SEO">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Competition</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============ JAVASCRIPT ============ -->
<script>
// ============ ADD FUNCTIONS ============
function addCounterItem() {
    var html = `
        <div class="row counter-item">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Icon</label>
                    <input type="text" class="form-control" name="counter_icon[]" placeholder="🎨">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Text</label>
                    <input type="text" class="form-control" name="counter_text[]" placeholder="5">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Subtext</label>
                    <input type="text" class="form-control" name="counter_subtext[]" placeholder="Grade Categories">
                </div>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-danger mt-4 remove-counter">Remove</button>
            </div>
        </div>
    `;
    $('#add_counter_items').append(html);
}

function addFeature() {
    var html = `
        <div class="row feature-item">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Icon Image</label>
                    <input type="file" class="form-control" name="feature_icon_image[]" accept="image/*">
                    <small class="text-muted">Upload icon</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="feature_title[]" placeholder="Hand-Made Posters">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" name="feature_description[]" placeholder="Only original, hand-made posters">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger mt-4 remove-feature">Remove</button>
            </div>
        </div>
    `;
    $('#add_features').append(html);
}

function addCategory() {
    var html = `
        <div class="category-item border p-3 mb-3">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Category Badge</label>
                        <input type="text" class="form-control" name="category_badge[]" placeholder="CATEGORY 1">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Category Title</label>
                        <input type="text" class="form-control" name="category_title[]" placeholder="Kindergarten — Below Grade 1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Color</label>
                        <select class="form-control" name="category_color[]">
                            <option value="category-pink">Pink</option>
                            <option value="category-yellow">Yellow</option>
                            <option value="category-green">Green</option>
                            <option value="category-blue">Blue</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger mt-4 remove-category">Remove</button>
                </div>
            </div>
            <div class="themes-container">
                <div class="theme-item row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Theme Icon</label>
                            <input type="text" class="form-control" name="theme_icon[]" placeholder="🌻">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Theme Title</label>
                            <input type="text" class="form-control" name="theme_title[]" placeholder="My Happy Garden">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Theme Description</label>
                            <input type="text" class="form-control" name="theme_description[]" placeholder="Draw a colourful garden...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger mt-4 remove-theme">Remove</button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-sm" onclick="addTheme(this)">+ Add Theme</button>
        </div>
    `;
    $('#add_categories').append(html);
}

function addTheme(btn) {
    var container = $(btn).prev('.themes-container');
    var html = `
        <div class="theme-item row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Theme Icon</label>
                    <input type="text" class="form-control" name="theme_icon[]" placeholder="🌻">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Theme Title</label>
                    <input type="text" class="form-control" name="theme_title[]" placeholder="My Happy Garden">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Theme Description</label>
                    <input type="text" class="form-control" name="theme_description[]" placeholder="Draw a colourful garden...">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger mt-4 remove-theme">Remove</button>
            </div>
        </div>
    `;
    container.append(html);
}

function addRequirement() {
    var html = `
        <div class="row requirement-item">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Icon</label>
                    <input type="text" class="form-control" name="requirement_icon[]" placeholder="1f5bc.svg">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="requirement_title[]" placeholder="Poster Photo">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" name="requirement_description[]" placeholder="A clear JPG or PNG image...">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger mt-4 remove-requirement">Remove</button>
            </div>
        </div>
    `;
    $('#add_requirements').append(html);
}

function addPrize() {
    var html = `
        <div class="row prize-item">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" name="prize_type[]">
                        <option value="winner">Winner</option>
                        <option value="runner">Runner Up</option>
                        <option value="outstanding">Outstanding</option>
                        <option value="participant">Participant</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Icon</label>
                    <input type="text" class="form-control" name="prize_icon[]" placeholder="🥇">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="prize_title[]" placeholder="One Winner">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Items (comma separated)</label>
                    <input type="text" class="form-control" name="prize_items[]" placeholder="🏆 Trophy, 🥇 Gold Medal">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger mt-4 remove-prize">Remove</button>
            </div>
        </div>
    `;
    $('#add_prizes').append(html);
}

function addFaq() {
    var html = `
        <div class="row faq-item">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" class="form-control" name="faq_question[]" placeholder="What age group do you accept?">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Answer</label>
                    <input type="text" class="form-control" name="faq_answer[]" placeholder="We accept students from KG to Grade 12">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger mt-4 remove-faq">Remove</button>
            </div>
        </div>
    `;
    $('#add_faqs').append(html);
}

function addStep() {
    var html = `
        <div class="row step-item">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Icon</label>
                    <input type="text" class="form-control" name="step_icon[]" placeholder="icon1.svg">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="step_title[]" placeholder="Register">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" name="step_description[]" placeholder="Click the Register button...">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger mt-4 remove-step">Remove</button>
            </div>
        </div>
    `;
    $('#add_steps').append(html);
}

// ============ EDIT FUNCTIONS ============
function addEditCounterItem(icon, text, subtext) {
    var html = `
        <div class="row counter-item">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Icon</label>
                    <input type="text" class="form-control" name="edit_counter_icon[]" value="${icon || ''}" placeholder="🎨">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Text</label>
                    <input type="text" class="form-control" name="edit_counter_text[]" value="${text || ''}" placeholder="5">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Subtext</label>
                    <input type="text" class="form-control" name="edit_counter_subtext[]" value="${subtext || ''}" placeholder="Grade Categories">
                </div>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-danger mt-4 remove-counter">Remove</button>
            </div>
        </div>
    `;
    $('#edit_counter_items').append(html);
}

function addEditFeature(iconImage, title, description) {
    var iconHtml = '';
    if(iconImage) {
        iconHtml = `<div class="mt-1"><img src="<?php echo base_url('uploads/features/'); ?>/${iconImage}" style="max-height:40px; border:1px solid #ddd; padding:3px; border-radius:4px;"><small class="text-muted d-block">Current icon</small></div>`;
    }
    
    var html = `
        <div class="row feature-item">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Icon Image</label>
                    <input type="file" class="form-control" name="edit_feature_icon_image[]" accept="image/*">
                    <small class="text-muted">Upload new icon</small>
                    ${iconHtml}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="edit_feature_title[]" value="${title || ''}" placeholder="Hand-Made Posters">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" name="edit_feature_description[]" value="${description || ''}" placeholder="Only original, hand-made posters">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger mt-4 remove-feature">Remove</button>
            </div>
        </div>
    `;
    $('#edit_features').append(html);
}

function addEditCategory(badge, title, color, themes) {
    var themesHtml = '';
    if(themes && themes.length > 0) {
        themes.forEach(function(theme) {
            themesHtml += `
                <div class="theme-item row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Theme Icon</label>
                            <input type="text" class="form-control" name="edit_theme_icon[]" value="${theme.icon || ''}" placeholder="🌻">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Theme Title</label>
                            <input type="text" class="form-control" name="edit_theme_title[]" value="${theme.title || ''}" placeholder="My Happy Garden">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Theme Description</label>
                            <input type="text" class="form-control" name="edit_theme_description[]" value="${theme.description || ''}" placeholder="Draw a colourful garden...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger mt-4 remove-theme">Remove</button>
                    </div>
                </div>
            `;
        });
    }
    
    var html = `
        <div class="category-item border p-3 mb-3">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Category Badge</label>
                        <input type="text" class="form-control" name="edit_category_badge[]" value="${badge || ''}" placeholder="CATEGORY 1">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Category Title</label>
                        <input type="text" class="form-control" name="edit_category_title[]" value="${title || ''}" placeholder="Kindergarten — Below Grade 1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Color</label>
                        <select class="form-control" name="edit_category_color[]">
                            <option value="category-pink" ${color == 'category-pink' ? 'selected' : ''}>Pink</option>
                            <option value="category-yellow" ${color == 'category-yellow' ? 'selected' : ''}>Yellow</option>
                            <option value="category-green" ${color == 'category-green' ? 'selected' : ''}>Green</option>
                            <option value="category-blue" ${color == 'category-blue' ? 'selected' : ''}>Blue</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger mt-4 remove-category">Remove</button>
                </div>
            </div>
            <div class="themes-container">
                ${themesHtml}
            </div>
            <button type="button" class="btn btn-primary btn-sm" onclick="addEditTheme(this)">+ Add Theme</button>
        </div>
    `;
    $('#edit_categories').append(html);
}

function addEditTheme(btn) {
    var container = $(btn).prev('.themes-container');
    var html = `
        <div class="theme-item row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Theme Icon</label>
                    <input type="text" class="form-control" name="edit_theme_icon[]" placeholder="🌻">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Theme Title</label>
                    <input type="text" class="form-control" name="edit_theme_title[]" placeholder="My Happy Garden">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Theme Description</label>
                    <input type="text" class="form-control" name="edit_theme_description[]" placeholder="Draw a colourful garden...">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger mt-4 remove-theme">Remove</button>
            </div>
        </div>
    `;
    container.append(html);
}

function addEditRequirement(icon, title, description) {
    var html = `
        <div class="row requirement-item">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Icon</label>
                    <input type="text" class="form-control" name="edit_requirement_icon[]" value="${icon || ''}" placeholder="1f5bc.svg">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="edit_requirement_title[]" value="${title || ''}" placeholder="Poster Photo">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" name="edit_requirement_description[]" value="${description || ''}" placeholder="A clear JPG or PNG image...">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger mt-4 remove-requirement">Remove</button>
            </div>
        </div>
    `;
    $('#edit_requirements').append(html);
}

function addEditPrize(type, icon, title, items) {
    var html = `
        <div class="row prize-item">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" name="edit_prize_type[]">
                        <option value="winner" ${type == 'winner' ? 'selected' : ''}>Winner</option>
                        <option value="runner" ${type == 'runner' ? 'selected' : ''}>Runner Up</option>
                        <option value="outstanding" ${type == 'outstanding' ? 'selected' : ''}>Outstanding</option>
                        <option value="participant" ${type == 'participant' ? 'selected' : ''}>Participant</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Icon</label>
                    <input type="text" class="form-control" name="edit_prize_icon[]" value="${icon || ''}" placeholder="🥇">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="edit_prize_title[]" value="${title || ''}" placeholder="One Winner">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Items (comma separated)</label>
                    <input type="text" class="form-control" name="edit_prize_items[]" value="${items || ''}" placeholder="🏆 Trophy, 🥇 Gold Medal">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger mt-4 remove-prize">Remove</button>
            </div>
        </div>
    `;
    $('#edit_prizes').append(html);
}

function addEditFaq(question, answer) {
    var html = `
        <div class="row faq-item">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" class="form-control" name="edit_faq_question[]" value="${question || ''}" placeholder="What age group do you accept?">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Answer</label>
                    <input type="text" class="form-control" name="edit_faq_answer[]" value="${answer || ''}" placeholder="We accept students from KG to Grade 12">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger mt-4 remove-faq">Remove</button>
            </div>
        </div>
    `;
    $('#edit_faqs').append(html);
}

function addEditStep(icon, title, description) {
    var html = `
        <div class="row step-item">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Icon</label>
                    <input type="text" class="form-control" name="edit_step_icon[]" value="${icon || ''}" placeholder="icon1.svg">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="edit_step_title[]" value="${title || ''}" placeholder="Register">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" name="edit_step_description[]" value="${description || ''}" placeholder="Click the Register button...">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger mt-4 remove-step">Remove</button>
            </div>
        </div>
    `;
    $('#edit_steps').append(html);
}

// ============ REMOVE HANDLERS ============
$(document).on('click', '.remove-counter, .remove-feature, .remove-requirement, .remove-prize, .remove-faq, .remove-step', function() {
    $(this).closest('.row').remove();
});

$(document).on('click', '.remove-category', function() {
    $(this).closest('.category-item').remove();
});

$(document).on('click', '.remove-theme', function() {
    $(this).closest('.theme-item').remove();
});

// ============ DATATABLE ============
$(document).ready(function() {
    var table = $('#competition_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url('admin/competition_list'); ?>",
            "type": "POST"
        },
        "columns": <?= $table_column ?>,
        "pagingType": "simple_numbers_no_ellipses",
        "language": {
            "processing": '<div class="custom-spinner"></div>'
        },
        "dom": '<"top"lB>frtip',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-primary',
                title: 'competitions_' + new Date().toLocaleDateString(),
            }
        ]
    });

    // ============ EDIT BUTTON ============
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        
        $('#edit_counter_items, #edit_features, #edit_categories, #edit_requirements, #edit_prizes, #edit_faqs, #edit_steps').empty();
        $('#current_image_preview, #current_poster_preview').empty();
        
        $('#editCompetitionModal').modal('show');
        $('#edit_title').val('Loading...');
        
        $.ajax({
            url: '<?php echo base_url('admin/get_competition_data'); ?>',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if(response.success && response.data) {
                    var data = response.data;
                    
                    $('#edit_id').val(data.id);
                    $('#edit_title').val(data.title || '');
                    $('#edit_description').val(data.description || '');
                    $('#edit_status').val(data.status || 'Active');
                    
                    $('#edit_hero_title').val(data.hero_title || '');
                    $('#edit_hero_description').val(data.hero_description || '');
                    $('#edit_hero_status_badge').val(data.hero_status_badge || '');
                    $('#edit_registration_deadline').val(data.registration_deadline || '');
                    $('#edit_submission_deadline').val(data.submission_deadline || '');
                    $('#edit_price_india').val(data.price_india || '');
                    $('#edit_price_international').val(data.price_international || '');
                    
                    $('#edit_poster_card_title').val(data.poster_card_title || '');
                    $('#edit_poster_card_description').val(data.poster_card_description || '');
                    
                    // Counter Items
                    if(data.counter_data) {
                        try {
                            var counters = JSON.parse(data.counter_data);
                            if(Array.isArray(counters)) {
                                counters.forEach(function(item) {
                                    addEditCounterItem(item.icon, item.text, item.subtext);
                                });
                            }
                        } catch(e) {}
                    }
                    
                    // Features with only icon image
                    if(data.features) {
                        try {
                            var features = JSON.parse(data.features);
                            if(Array.isArray(features)) {
                                features.forEach(function(item) {
                                    addEditFeature(item.icon_image || '', item.title, item.description);
                                });
                            }
                        } catch(e) {}
                    }
                    
                    // Categories
                    if(data.categories) {
                        try {
                            var categories = JSON.parse(data.categories);
                            if(Array.isArray(categories)) {
                                categories.forEach(function(item) {
                                    addEditCategory(item.badge, item.title, item.color, item.themes);
                                });
                            }
                        } catch(e) {}
                    }
                    
                    // Requirements
                    if(data.submission_requirements) {
                        try {
                            var requirements = JSON.parse(data.submission_requirements);
                            if(Array.isArray(requirements)) {
                                requirements.forEach(function(item) {
                                    addEditRequirement(item.icon, item.title, item.description);
                                });
                            }
                        } catch(e) {}
                    }
                    
                    // Prizes
                    if(data.prizes) {
                        try {
                            var prizes = JSON.parse(data.prizes);
                            if(Array.isArray(prizes)) {
                                prizes.forEach(function(item) {
                                    var itemsStr = Array.isArray(item.items) ? item.items.join(', ') : '';
                                    addEditPrize(item.type, item.icon, item.title, itemsStr);
                                });
                            }
                        } catch(e) {}
                    }
                    
                    // FAQs
                    if(data.faqs) {
                        try {
                            var faqs = JSON.parse(data.faqs);
                            if(Array.isArray(faqs)) {
                                faqs.forEach(function(item) {
                                    addEditFaq(item.question, item.answer);
                                });
                            }
                        } catch(e) {}
                    }
                    
                    // Steps
                    if(data.how_to_participate) {
                        try {
                            var steps = JSON.parse(data.how_to_participate);
                            if(Array.isArray(steps)) {
                                steps.forEach(function(item) {
                                    addEditStep(item.icon, item.title, item.description);
                                });
                            }
                        } catch(e) {}
                    }
                    
                    $('#edit_meta_keywords').val(data.meta_keywords || '');
                    $('#edit_meta_description').val(data.meta_description || '');
                    
                    if(data.image) {
                        $('#current_image_preview').html('<img src="<?php echo base_url('uploads/competitions/'); ?>/' + data.image + '" style="max-height:100px; border:1px solid #ddd; padding:5px; border-radius:4px;">');
                    } else {
                        $('#current_image_preview').html('<span class="text-muted">No image</span>');
                    }
                    
                    if(data.poster_card_image) {
                        $('#current_poster_preview').html('<img src="<?php echo base_url('uploads/competitions/'); ?>/' + data.poster_card_image + '" style="max-height:100px; border:1px solid #ddd; padding:5px; border-radius:4px;">');
                    } else {
                        $('#current_poster_preview').html('<span class="text-muted">No image</span>');
                    }
                    
                    toastr.success('Data loaded successfully!');
                } else {
                    toastr.error(response.message || 'Failed to load competition data');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                toastr.error('Failed to load competition data. Please check console for details.');
            }
        });
    });

    // ============ DELETE BUTTON ============
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this competition?')) {
            $.ajax({
                url: '<?php echo base_url('admin/delete_competition'); ?>',
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
                }
            });
        }
    });

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

.category-item {
    background: #f8f9fa;
    border-radius: 5px;
}

.category-pink { border-left: 4px solid #ff6b9d; }
.category-yellow { border-left: 4px solid #ffd93d; }
.category-green { border-left: 4px solid #6bcb77; }
.category-blue { border-left: 4px solid #4d96ff; }
</style>