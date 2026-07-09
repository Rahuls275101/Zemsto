<section class="section-registration winer">
  <div class="container">
    <div class="section-title">
      <h2>Kids <span>Talent</span> Show Winner <?= date('Y')-1 ?>-<?= date('Y') ?></h2>
      <p>Celebrating the extraordinary talents of our young stars! The Kids Talent Show Winners have showcased exceptional creativity, confidence, and dedication through their remarkable performances. Their achievements inspire others to discover their talents, pursue their passions, and shine brightly on every stage.</p>
    </div>
    
    <!-- ============================================ -->
    <!-- FILTERS SECTION -->
    <!-- ============================================ -->
    <div class="filters-section mb-4" style="padding-bottom: 10px;">
      <div class="row align-items-end">
        <!-- Search -->
        <div class="col-lg-4 col-md-6">
          <div class="form-group">
    
            <input type="text" id="searchInput" class="form-control" placeholder="Search by name, school..." value="<?= esc($search_term ?? '') ?>">
          </div>
        </div>
        
        <!-- Year Filter -->
        <div class="col-lg-2 col-md-6">
          <div class="form-group">
            <select id="yearFilter" class="form-control">
              <option value="">Select Years</option>
              <?php foreach ($years as $y): ?>
                <option value="<?= esc($y->year) ?>" <?= ($selected_year == $y->year) ? 'selected' : '' ?>>
                  <?= esc($y->year) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        
        <!-- State Filter -->
        <div class="col-lg-2 col-md-6">
          <div class="form-group">
            <select id="stateFilter" class="form-control">
              <option value="">Select States</option>
              <?php foreach ($states as $s): ?>
                <option value="<?= esc($s->state) ?>" <?= ($selected_state == $s->state) ? 'selected' : '' ?>>
                  <?= esc($s->state) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        
        <!-- Category Filter -->
        <div class="col-lg-2 col-md-6">
          <div class="form-group">
            <select id="categoryFilter" class="form-control">
              <option value="">Select Categories</option>
              <?php foreach ($categories as $c): ?>
                <option value="<?= esc($c->category) ?>" <?= ($selected_category == $c->category) ? 'selected' : '' ?>>
                  <?= esc($c->category) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="col-lg-2 col-md-6">
          <div class="d-flex gap-2">
            <button id="applyFiltersBtn" class="theme-btn" style="border-radius: 5px; height: 44px; line-height: 44px;">
              <i class="fas fa-filter"></i> Apply Filters
            </button>
           
          </div>
        </div>
      </div>
      
      <!-- Active Filters Display -->
      <div id="activeFilters" class="mt-3">
        <?php if (!empty($search_term) || !empty($selected_year) || !empty($selected_state) || !empty($selected_category)): ?>
          <div class="d-flex flex-wrap gap-2 align-items-center">
            <span class="fw-bold">Active Filters:</span>
            <?php if (!empty($search_term)): ?>
              <span class="badge bg-primary filter-badge">
                <i class="fas fa-search"></i> <?= esc($search_term) ?>
                <a href="#" class="remove-filter text-white" data-type="search">×</a>
              </span>
            <?php endif; ?>
            <?php if (!empty($selected_year)): ?>
              <span class="badge bg-success filter-badge">
                <i class="fas fa-calendar"></i> <?= esc($selected_year) ?>
                <a href="#" class="remove-filter text-white" data-type="year">×</a>
              </span>
            <?php endif; ?>
            <?php if (!empty($selected_state)): ?>
              <span class="badge bg-info filter-badge">
                <i class="fas fa-map-marker-alt"></i> <?= esc($selected_state) ?>
                <a href="#" class="remove-filter text-white" data-type="state">×</a>
              </span>
            <?php endif; ?>
            <?php if (!empty($selected_category)): ?>
              <span class="badge bg-warning text-dark filter-badge">
                <i class="fas fa-tag"></i> <?= esc($selected_category) ?>
                <a href="#" class="remove-filter text-dark" data-type="category">×</a>
              </span>
            <?php endif; ?>
            <span class="text-muted small">(<?= count($winnersByCategory, COUNT_RECURSIVE) - count($winnersByCategory) ?> results found)</span>
          </div>
        <?php endif; ?>
      </div>
    </div>
    
    <!-- ============================================ -->
    <!-- RESULTS SECTION -->
    <!-- ============================================ -->
    <div class="row justify-content-center">
      <div class="col-lg-12">
        
        <!-- Results Count -->
        <div class="results-header mb-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
              <i class="fas fa-trophy text-warning"></i> 
              Total Winners: <span class="text-primary"><?= count($winnersByCategory, COUNT_RECURSIVE) - count($winnersByCategory) ?></span>
            </h5>
            <div class="text-muted">
              <i class="fas fa-layer-group"></i> <?= count($winnersByCategory) ?> Categories
            </div>
          </div>
        </div>
        
        <?php if (!empty($winnersByCategory)): ?>
          <?php 
          $categoryIcons = [
              'Dancing' => '💃',
              'Singing' => '🎤',
              'Fancy Dress' => '🎭',
              'Musical Instrument' => '🎵',
              'Photography' => '📸',
              'Public Speaking' => '🎙️'
          ];
          
          $rankColors = [
              '1st' => '#FFD700',
              '2nd' => '#C0C0C0',
              '3rd' => '#CD7F32'
          ];
          ?>
          
          <?php foreach ($winnersByCategory as $category => $winners): ?>
            <div class="category-section mb-4" style="background: #fff; padding: 23px; border-radius: 15px; box-shadow: 0 2px 15px rgba(0,0,0,0.08);">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h2 class="section-title mb-0" style="font-size: 24px;">
                  <?= ($categoryIcons[$category] ?? '🏆') . ' ' . $category ?>
                </h2>
                <span class="result-count badge bg-secondary"><?= count($winners) ?> Winners</span>
              </div>
              <hr>
              
              <div class="row g-4">
                <?php foreach ($winners as $winner): ?>
                  <div class="col-lg-3 col-md-6">
                    <div class="winner-card" style="
                      background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
                      border-radius: 12px;
                      padding: 20px 15px;
                      text-align: center;
                      transition: all 0.3s ease;
                      border: 2px solid #e0e0e0;
                      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
                      height: 100%;
                    ">
                      <!-- Rank Badge -->
                      <div class="rank-badge" style="
                        display: inline-block;
                        padding: 5px 15px;
                        border-radius: 20px;
                        font-weight: 700;
                        font-size: 14px;
                        margin-bottom: 12px;
                        background: <?= $rankColors[$winner->rank] ?? '#6c757d' ?>;
                        color: <?= ($winner->rank == '1st' || $winner->rank == '2nd') ? '#000' : '#fff' ?>;
                      ">
                        <?php 
                          if ($winner->rank == '1st') echo '🥇 1st';
                          elseif ($winner->rank == '2nd') echo '🥈 2nd';
                          elseif ($winner->rank == '3rd') echo '🥉 3rd';
                          else echo esc($winner->rank);
                        ?>
                      </div>
                      
                      <!-- Winner Image -->
                      <?php if (!empty($winner->image)): ?>
                        <div class="winner-image mb-2">
                          <img src="<?= base_url('assets/talent/' . $winner->image) ?>" 
                               alt="<?= esc($winner->name) ?>" 
                               style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 3px solid #003b8e;">
                        </div>
                      <?php else: ?>
                        <div class="winner-image mb-2">
                          <div style="width: 80px; height: 80px; border-radius: 50%; background: #e0e0e0; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 35px; color: #999; border: 3px solid #003b8e;">
                            👤
                          </div>
                        </div>
                      <?php endif; ?>
                      
                      <!-- Winner Name -->
                      <h3 class="winner-name" style="font-size: 18px; font-weight: 700; color: #003b8e; margin-bottom: 5px;">
                        <?= esc($winner->name) ?>
                      </h3>
                      
                      <!-- School -->
                      <p class="school-name" style="font-size: 13px; color: #666; margin-bottom: 5px;">
                        <i class="fas fa-school"></i> <?= esc($winner->school) ?>
                      </p>
                      
                      <!-- City, State -->
                      <p class="location" style="font-size: 12px; color: #888; margin-bottom: 8px;">
                        <i class="fas fa-map-marker-alt text-danger"></i> 
                        <?= esc($winner->city) ?>, <?= esc($winner->state) ?>
                      </p>
                      
                      <!-- Score -->
                      <?php if (!empty($winner->score)): ?>
                        <div class="score" style="font-size: 14px; font-weight: 600; color: #28a745;">
                          <i class="fas fa-star"></i> Score: <?= esc($winner->score) ?>
                        </div>
                      <?php endif; ?>
                      
                      <!-- Position Badge -->
                      <div class="position-badge mt-2">
                        <span class="badge" style="
                          background: <?= $winner->position == 'Winner' ? '#FFD700' : ($winner->position == 'Runner Up' ? '#C0C0C0' : '#CD7F32') ?>;
                          color: <?= $winner->position == 'Winner' ? '#000' : '#fff' ?>;
                          padding: 5px 12px;
                          font-size: 11px;
                        ">
                          <?php 
                            if ($winner->position == 'Winner') echo '🏆 WINNER';
                            elseif ($winner->position == 'Runner Up') echo '🥈 RUNNER UP';
                            else echo '🥉 2ND RUNNER UP';
                          ?>
                        </span>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
          
        <?php else: ?>
          <!-- No Results -->
          <div class="text-center py-5">
            <div style="font-size: 60px; margin-bottom: 20px;">🔍</div>
            <h4>No winners found</h4>
            <p class="text-muted">Try adjusting your filters or search term.</p>
            <button id="resetFiltersBtn2" class="btn btn-primary mt-3">
              <i class="fas fa-undo"></i> Reset Filters
            </button>
          </div>
        <?php endif; ?>
        
      </div>
    </div>
  </div>
</section>

<!-- ============================================ -->
<!-- STYLES -->
<!-- ============================================ -->
<style>
/* Filter Section */
.filters-section {
    background: #fff;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
}

.filters-section .form-group label {
    font-size: 14px;
    color: #555;
}

.filters-section .form-control {
    border-radius: 8px;
    border: 2px solid #e0e0e0;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.filters-section .form-control:focus {
    border-color: #003b8e;
    box-shadow: 0 0 0 0.2rem rgba(0, 59, 142, 0.15);
}

.filter-badge {
    padding: 8px 15px;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.remove-filter {
    text-decoration: none;
    margin-left: 5px;
    font-weight: 700;
    opacity: 0.7;
}

.remove-filter:hover {
    opacity: 1;
}

.results-header {
    background: #fff;
    padding: 15px 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

/* Winner Card Hover Effect */
.winner-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    border-color: #003b8e;
}

/* Category Section */
.category-section {
    animation: fadeInUp 0.5s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .filters-section .form-group {
        margin-bottom: 10px;
    }
    
    .winner-card {
        padding: 15px 10px !important;
    }
    
    .winner-card .winner-name {
        font-size: 16px !important;
    }
}

/* Rank Badge Animation */
.rank-badge {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
</style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous">
</script>
<!-- ============================================ -->
<!-- SCRIPTS -->
<!-- ============================================ -->
<script>
$(document).ready(function() {
    
    // ============================================
    // APPLY FILTERS
    // ============================================
    function applyFilters() {
        var search = $('#searchInput').val().trim();
        var year = $('#yearFilter').val();
        var state = $('#stateFilter').val();
        var category = $('#categoryFilter').val();
        
        var url = new URL(window.location.href);
        
        if (search) {
            url.searchParams.set('search', search);
        } else {
            url.searchParams.delete('search');
        }
        
        if (year) {
            url.searchParams.set('year', year);
        } else {
            url.searchParams.delete('year');
        }
        
        if (state) {
            url.searchParams.set('state', state);
        } else {
            url.searchParams.delete('state');
        }
        
        if (category) {
            url.searchParams.set('category', category);
        } else {
            url.searchParams.delete('category');
        }
        
        window.location.href = url.toString();
    }
    
    // Apply Filters Button
    $('#applyFiltersBtn').on('click', function() {
        applyFilters();
    });
    
    // Enter key on search
    $('#searchInput').on('keypress', function(e) {
        if (e.which == 13) {
            applyFilters();
        }
    });
    
    // ============================================
    // RESET FILTERS
    // ============================================
    function resetFilters() {
        var url = new URL(window.location.href);
        url.searchParams.delete('search');
        url.searchParams.delete('year');
        url.searchParams.delete('state');
        url.searchParams.delete('category');
        window.location.href = url.toString();
    }
    
    $('#resetFiltersBtn, #resetFiltersBtn2').on('click', function() {
        resetFilters();
    });
    
    // ============================================
    // REMOVE INDIVIDUAL FILTER
    // ============================================
    $(document).on('click', '.remove-filter', function(e) {
        e.preventDefault();
        var type = $(this).data('type');
        var url = new URL(window.location.href);
        url.searchParams.delete(type);
        window.location.href = url.toString();
    });
    
    // ============================================
    // AUTO SUBMIT ON FILTER CHANGE (Optional)
    // ============================================
    // Uncomment this if you want auto-submit on dropdown change
    /*
    $('#yearFilter, #stateFilter, #categoryFilter').on('change', function() {
        applyFilters();
    });
    */
    
});
</script>