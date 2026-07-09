<section class="shop-details-section inner-padding">
  <div class="container">
    <div class="shop-details-wrapper">
      <div class="row">
        <!-- ============================================ -->
        <!-- LEFT SIDE - IMAGES -->
        <!-- ============================================ -->
        <div class="col-lg-4">
          <div class="shop-details-image">
            <div class="tab-content">
              <?php if (!empty($images)): ?>
                <?php foreach ($images as $key => $image): ?>
                  <?php $image = trim($image); ?>
                  <?php if (!empty($image)): ?>
                    <div id="thumb<?= $key + 1 ?>" class="tab-pane fade <?= ($key == 0) ? 'show active' : '' ?>">
                      <div class="shop-thumb">
                        <img src="<?= base_url('assets/books/' . $image) ?>" alt="<?= esc($book->book_name ?? 'Book') ?>">
                      </div>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php else: ?>
                <div id="thumb1" class="tab-pane fade show active">
                  <div class="shop-thumb">
                    <img src="<?= base_url('assets/img/shop/default.jpg') ?>" alt="Default Image">
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- ============================================ -->
        <!-- RIGHT SIDE - DETAILS -->
        <!-- ============================================ -->
        <div class="col-lg-8">
          <div class="product-details-content">
            <h2 class="pb-3 text-anim" style="font-size: 32px">
              <?= esc($book->book_name ?? '') ?> 
              <small>(Class: <?= esc($book->book_class ?? '') ?>)</small>
            </h2>
            
            <p class="mb-3 wow fadeInUp" data-wow-delay=".2s">
              <?= esc($book->book_description ?? '') ?>
            </p>
            
            <div class="price-list wow fadeInUp" data-wow-delay=".4s">
              <ul>
                <li>Total price: INR <?= esc($book->book_price ?? 0) ?></li>
                <?php if (!empty($book->book_discount_price) && $book->book_discount_price > $book->book_price): ?>
                  <li><del>INR <?= esc($book->book_discount_price) ?></del></li>
                <?php endif; ?>
              </ul>
            </div>

            <!-- Book Info -->
            <div class="book-info mt-3">
              <p><strong>Class:</strong> <?= esc($book->book_class ?? '') ?></p>
              <p><strong>Subject:</strong> <?= esc($book->book_subject ?? '') ?></p>
              <p><strong>Type:</strong> <?= esc($book->book_type ?? '') ?></p>
              <p><strong>Status:</strong> <?= esc($book->book_status ?? '') ?></p>
            </div>

            <div class="cart-quantity wow fadeInUp" data-wow-delay=".6s">
              <p class="qty">
                <button class="qtyminus" aria-hidden="true">−</button>
                <input type="number" name="qty" id="qty2" min="1" max="10" step="1" value="1">
                <button class="qtyplus" aria-hidden="true">+</button>
              </p>
              <!-- ============================================ -->
              <!-- ✅ ENQUIRY BUTTON - Opens Modal -->
              <!-- ============================================ -->
              <a href="javascript:void(0)" class="shop-btn theme-btn" data-bs-toggle="modal" data-bs-target="#enquiryModal">
                Enquire Now
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================ -->
<!-- RELATED BOOKS -->
<!-- ============================================ -->
<section class="shop-section-inner section-padding fix pt-0">
  <div class="container">
    <div class="section-title text-center">
      <span class="sub-title wow fadeInUp">Related Products</span>
      <h2 class="char-animation">Your Related <span>Products</span></h2>
    </div>
    <div class="row">
      <?php if (!empty($related_books)): ?>
        <?php foreach ($related_books as $related): ?>
          <?php
          $image = (!empty($related->book_image)) 
            ? base_url('assets/books/' . $related->book_image) 
            : base_url('assets/img/shop/default.jpg');
          ?>
          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".5s">
            <div class="shop-box-items style-inner">
              <div class="shop-image">
                <img src="<?= $image ?>" alt="<?= esc($related->book_name) ?>">
                <ul class="shop-icon d-flex justify-content-center align-items-center">
                  <li>
                    <a href="<?= base_url('book/' . $related->url_slug) ?>">
                      <i class="fas fa-eye"></i>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0);">
                      <i class="far fa-shopping-cart"></i>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="content">
                <h3>
                  <a href="<?= base_url('book/' . $related->url_slug) ?>">
                    <?= esc($related->book_name) ?>
                  </a>
                </h3>
                <ul>
                  <li>INR <?= esc($related->book_price) ?></li>
                  <?php if (!empty($related->book_discount_price) && $related->book_discount_price > $related->book_price): ?>
                    <li><del>INR <?= esc($related->book_discount_price) ?></del></li>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 text-center">
          <h4>No related books found</h4>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ============================================ -->
<!-- ✅ ENQUIRY MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="enquiryModalLabel">
          <i class="fas fa-paper-plane"></i> Enquire Now
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="enquiryForm">
          <!-- Hidden Fields -->
          <input type="hidden" name="book_id" value="<?= $book->book_id ?? 0 ?>">
          <input type="hidden" name="book_name" value="<?= esc($book->book_name ?? '') ?>">

          <!-- Name -->
          <div class="mb-3">
            <label for="enquiryName" class="form-label">Your Name *</label>
            <input type="text" class="form-control" id="enquiryName" name="name" placeholder="Enter your full name" required>
            <div class="invalid-feedback" id="nameError"></div>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="enquiryEmail" class="form-label">Email Address *</label>
            <input type="email" class="form-control" id="enquiryEmail" name="email" placeholder="Enter your email" required>
            <div class="invalid-feedback" id="emailError"></div>
          </div>

          <!-- Phone -->
          <div class="mb-3">
            <label for="enquiryPhone" class="form-label">Phone Number *</label>
            <input type="tel" class="form-control" id="enquiryPhone" name="phone" placeholder="Enter your phone number" required>
            <div class="invalid-feedback" id="phoneError"></div>
          </div>

          <!-- Message -->
          <div class="mb-3">
            <label for="enquiryMessage" class="form-label">Message</label>
            <textarea class="form-control" id="enquiryMessage" name="message" rows="3" placeholder="Any specific requirements..."></textarea>
            <div class="invalid-feedback" id="messageError"></div>
          </div>

          <!-- Book Info Display -->
          <div class="alert alert-info">
            <strong>Book:</strong> <?= esc($book->book_name ?? '') ?>
            <br>
            <strong>Price:</strong> INR <?= esc($book->book_price ?? 0) ?>
          </div>

          <button type="submit" class="btn btn-primary w-100" id="submitEnquiry">
            <i class="fas fa-paper-plane"></i> Send Enquiry
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous">
</script>
<!-- ============================================ -->
<!-- ✅ AJAX & SWEETALERT SCRIPT -->
<!-- ============================================ -->
<script>
$(document).ready(function() {

  // ============================================
  // ENQUIRY FORM SUBMIT
  // ============================================
  $('#enquiryForm').on('submit', function(e) {
    e.preventDefault();

    // Clear previous errors
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').text('');

    // Show loading
    $('#submitEnquiry').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');
    $('#submitEnquiry').attr('disabled', true);

    // Get form data
    var formData = new FormData(this);

    $.ajax({
      type: "POST",
      url: "<?= base_url('book/save-enquiry') ?>",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "JSON",
      success: function(response) {
        // Reset button
        $('#submitEnquiry').html('<i class="fas fa-paper-plane"></i> Send Enquiry');
        $('#submitEnquiry').attr('disabled', false);

        if (response.status) {
          // ✅ Success - SweetAlert
          Swal.fire({
            icon: 'success',
            title: 'Enquiry Sent!',
            text: response.message,
            confirmButtonColor: '#f7941d',
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              // Close modal and reset form
              $('#enquiryModal').modal('hide');
              $('#enquiryForm')[0].reset();
            }
          });
        } else {
          // ❌ Validation Errors
          if (response.errors) {
            $.each(response.errors, function(key, value) {
              // Find the field and show error
              var field = $('#enquiryForm [name="' + key + '"]');
              if (field.length) {
                field.addClass('is-invalid');
                field.closest('.mb-3').find('.invalid-feedback').text(value);
              }
            });

            Swal.fire({
              icon: 'warning',
              title: 'Validation Error',
              text: 'Please check the highlighted fields.',
              confirmButtonColor: '#f7941d'
            });
          } else {
            // Error message
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: response.message || 'Something went wrong. Please try again.',
              confirmButtonColor: '#f7941d'
            });
          }
        }
      },
      error: function(xhr, status, error) {
        // Reset button
        $('#submitEnquiry').html('<i class="fas fa-paper-plane"></i> Send Enquiry');
        $('#submitEnquiry').attr('disabled', false);

        Swal.fire({
          icon: 'error',
          title: 'Server Error!',
          text: 'Please try again later.',
          confirmButtonColor: '#f7941d'
        });
        console.log('Error:', xhr.responseText);
      }
    });
  });

  // ============================================
  // CLEAR ERRORS ON INPUT
  // ============================================
  $('#enquiryForm input, #enquiryForm textarea').on('input', function() {
    $(this).removeClass('is-invalid');
    $(this).closest('.mb-3').find('.invalid-feedback').text('');
  });

  // ============================================
  // RESET FORM ON MODAL CLOSE
  // ============================================
  $('#enquiryModal').on('hidden.bs.modal', function() {
    $('#enquiryForm')[0].reset();
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').text('');
    $('#submitEnquiry').html('<i class="fas fa-paper-plane"></i> Send Enquiry');
    $('#submitEnquiry').attr('disabled', false);
  });

});
</script>