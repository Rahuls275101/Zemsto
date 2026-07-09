<section class="shop-section inner-padding">
  <div class="container">
    <div class="section-title text-center">
      <h2>Find <span>Your</span> Books</h2>
      <p>Select your Class and click on the Search button.</p>
    </div>

    <div class="row g-4">
      <div class="col-xl-12">
        <div class="shop-main-sidebar">
          <form method="GET" action="<?= base_url('books') ?>">
            <div class="row g-3 align-items-center">
              <!-- Country -->
              <div class="col-lg-3 col-md-6">
                <select class="form-select filter-select" name="country">
                  <option value="India" <?= ($selected_country == 'India') ? 'selected' : '' ?>>India</option>
                  <option value="USA" <?= ($selected_country == 'USA') ? 'selected' : '' ?>>USA</option>
                  <option value="Canada" <?= ($selected_country == 'Canada') ? 'selected' : '' ?>>Canada</option>
                </select>
              </div>

              <!-- Class -->
              <div class="col-lg-2 col-md-6">
                <select class="form-select filter-select" name="class">
                  <option value="">All Classes</option>
                  
                  
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
                  <!--<?php if (!empty($classes)): ?>
                    <?php foreach ($classes as $class): ?>
                      <option value="<?= esc($class->book_class) ?>" <?= ($selected_class == $class->book_class) ? 'selected' : '' ?>>
                        <?= esc($class->book_class) ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>-->
                </select>
              </div>

              <!-- Subject -->
              <div class="col-lg-3 col-md-6">
                <select class="form-select filter-select text-uppercase" name="subject">
                  <option value="">All Subjects</option>
                  <option value="Math" <?= ($selected_subject == 'Math') ? 'selected' : '' ?>>Math</option>
                  <option value="Science" <?= ($selected_subject == 'Science') ? 'selected' : '' ?>>Science</option>
                  <option value="English" <?= ($selected_subject == 'English') ? 'selected' : '' ?>>English</option>
                  <option value="Computer" <?= ($selected_subject == 'Computer') ? 'selected' : '' ?>>Computer</option>
                </select>
              </div>

              <!-- Book Type -->
              <div class="col-lg-2 col-md-6">
                <select class="form-select filter-select" name="book_type">
                  <option value="">All Types</option>
                  <option value="Physical Book" <?= ($selected_type == 'Physical Book') ? 'selected' : '' ?>>Physical Book</option>
                  <option value="E-Book" <?= ($selected_type == 'E-Book') ? 'selected' : '' ?>>E-Book</option>
                  <option value="Audio Book" <?= ($selected_type == 'Audio Book') ? 'selected' : '' ?>>Audio Book</option>
                </select>
              </div>

              <!-- Search Button -->
              <div class="col-lg-2 col-md-12">
                <button type="submit" class="btn btn-primary btn-search w-100">
                  <i class="bi bi-search"></i> Search
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- ============================================ -->
      <!-- BOOKS LIST -->
      <!-- ============================================ -->
      <div class="col-xl-12">
        <div class="row g-4">
          <?php if (!empty($books) && is_array($books)): ?>
            <?php foreach ($books as $book): ?>
              <?php
              $discount = '';
              $discount_percent = '';
              if (isset($book->book_discount_price, $book->book_price) && $book->book_discount_price && $book->book_discount_price > $book->book_price) {
                $discount = '<del>INR ' . esc($book->book_discount_price) . '</del>';
                $discount_percent = round((($book->book_discount_price - $book->book_price) / $book->book_discount_price) * 100);
                $discount_percent = '<span class="discount-icon">' . $discount_percent . '%</span>';
              }

              $image = (!empty($book->book_image)) 
                ? base_url('assets/books/' . esc($book->book_image)) 
                : base_url('assets/img/shop/default.jpg');
              ?>
              <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                <div class="shop-box-items style-inner">
                  <div class="shop-image">
                    <img src="<?= $image ?>" alt="<?= esc($book->book_name ?? 'Book') ?>">
                   
                    <?= $discount_percent ?>
                  </div>
                  <div class="content">
                
                    <h3><a href="<?= base_url('book-details/' . ($book->url_slug  ?? 0)) ?>"><?= esc($book->book_name ?? '') ?></a></h3>
                    <ul>
                      <li>INR <?= esc($book->book_price ?? 0) ?></li>
                      <li><?= $discount ?></li>
                    </ul>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-12 text-center">
              <h4>No books found</h4>
            </div>
          <?php endif; ?>
        </div>

        <!-- ============================================ -->
        <!-- ✅ PAGINATION - Using Controller Data -->
        <!-- ============================================ -->
        <?php if ($total_pages > 1): ?>
          <div class="pagination-wrap">
            <?php
            // Build query string without 'page'
            $queryParams = $query_params;
            unset($queryParams['page']);
            $queryString = http_build_query($queryParams);
            $queryString = !empty($queryString) ? '?' . $queryString . '&page=' : '?page=';
            ?>

            <!-- Previous Button -->
            <?php if ($current_page > 1): ?>
              <a href="<?= $base_url . $queryString . ($current_page - 1) ?>" class="wow fadeInUp" data-wow-delay=".2s">
                <i class="fas fa-chevron-left"></i>
              </a>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php
            $start = max(1, $current_page - 2);
            $end = min($total_pages, $current_page + 2);
            
            if ($start > 1): ?>
              <a href="<?= $base_url . $queryString . '1' ?>" class="wow fadeInUp" data-wow-delay=".2s">01</a>
              <?php if ($start > 2): ?>
                <span class="wow fadeInUp" data-wow-delay=".4s">...</span>
              <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
              <?php if ($i == $current_page): ?>
                <a href="#" class="active wow fadeInUp" data-wow-delay=".4s"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></a>
              <?php else: ?>
                <a href="<?= $base_url . $queryString . $i ?>" class="wow fadeInUp" data-wow-delay=".4s"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></a>
              <?php endif; ?>
            <?php endfor; ?>

            <?php if ($end < $total_pages): ?>
              <?php if ($end < $total_pages - 1): ?>
                <span class="wow fadeInUp" data-wow-delay=".6s">...</span>
              <?php endif; ?>
              <a href="<?= $base_url . $queryString . $total_pages ?>" class="wow fadeInUp" data-wow-delay=".6s"><?= str_pad($total_pages, 2, '0', STR_PAD_LEFT) ?></a>
            <?php endif; ?>

            <!-- Next Button -->
            <?php if ($current_page < $total_pages): ?>
              <a href="<?= $base_url . $queryString . ($current_page + 1) ?>" class="wow fadeInUp" data-wow-delay=".8s">
                <i class="fas fa-chevron-right"></i>
              </a>
            <?php endif; ?>
          </div>

          <!-- Pagination Info -->
          <div class="text-center mt-3">
            <p class="text-muted">
              Showing <?= (($current_page - 1) * $per_page + 1) ?> 
              to <?= min($current_page * $per_page, $total_records) ?> 
              of <?= $total_records ?> books
            </p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>