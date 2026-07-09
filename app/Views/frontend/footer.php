<?php 

use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
   $addressView = $commanmodel->get_single_query('address',array('id' => 1));
 
?> 
<footer class="footer-section footer-two"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/footer-bg-3.png" style="width: 100%; margin-top: -47px;">
  <div class="bottom-shape shape-2"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/footer/bg-bottom2.png" alt="shape-img"> </div>
  <div class="hut-shape float-bob-y"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/footer/hut.png" alt="shape-img"> </div>
  <div class="emoji-shape"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/footer/emoji.png" alt="shape-img"> </div>
  <div class="sky-shape"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/footer/sky.png" alt="shape-img"> </div>
  <div class="container">
    <div class="contact-info-wrapper">
      <div class="row g-4">
        <div class="col-xl-3 col-lg-3 col-md-7">
          <div class="contact-items wow fadeInLeft" data-wow-delay=".2s">
            <div class="contact-head"> <a href="<?php echo base_url(''); ?>"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/footer/logow.png" alt="logo-image" style="height:90px"> </a> </div>
          </div>
        </div>
        <div class="col-xl-9 col-lg-9">
          <div class="contact-info-box d-flex">
            <div class="contact-inform wow fadeInLeft" data-wow-delay=".4s">
              <div class="icon"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/footer/support.svg" alt="icon-image"> </div>
              <div class="content">
                <h3>For Support:</h3>
                <p> <a href="tel:+<?php echo $addressView->phone_one;?>">+91 <?php echo $addressView->phone_one;?> </a> </p>
              </div>
            </div>
            <div class="contact-inform wow fadeInLeft" data-wow-delay=".6s">
              <div class="icon"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/footer/email.svg" alt="icon-image"> </div>
              <div class="content">
                <h3>Email us</h3>
                <p> <a href="mailto: <?php echo $addressView->email_two;?>">
                  <?php echo $addressView->email_two;?></a> </p>
              </div>
            </div>
            <div class="contact-inform wow fadeInLeft" data-wow-delay=".8s">
              <div class="icon"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/footer/location.svg" alt="icon-image"> </div>
              <div class="content">
                <h3>Location</h3>
                <p><?php echo $addressView->address;?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-widgets-wrapper footer-widgets-two">
      <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 wow fadeInUp" data-wow-delay=".2s">
          <div class="single-footer-widget">
            <div class="widget-head">
              <h3>Quick Links</h3>
            </div>
            <div class="widget-content">
              <ul class="list-area">
                <li><a href="<?php echo base_url('talent-winners'); ?>"> Winners</a></li>
                <li><a href="<?php echo base_url('winners-member'); ?>"> Hall of Fame</a></li>
                <li><a href="<?php echo base_url('olympiad-result'); ?>"> Results</a></li>
                <li><a href="<?php echo base_url('books'); ?>"> Books Store</a></li>
                <li><a href="<?php echo base_url('gallery'); ?>"> Gallery</a></li>
                <li><a href="<?php echo base_url('blogs'); ?>"> Blog</a></li>
                <li><a href="<?php echo base_url('contact-us'); ?>"> Contact Us</a></li>
                <li><a href="<?php echo base_url('faq'); ?>"> FAQs</a></li>
              </ul>
            </div>
          </div>
        </div>
<!--        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 wow fadeInUp" data-wow-delay=".4s">
          <div class="single-footer-widget">
            <div class="widget-head">
              <h3>Olympiads</h3>
            </div>
            <div class="widget-content">
              <ul class="list-area">
                <li><a href="#">English Olympiad</a></li>
                <li><a href="#">Math Olympiad</a></li>
                <li><a href="#">EVS Olympiad</a></li>
                <li><a href="#">हिन्दी ओलम्पियाड</a></li>
                <li><a href="#">Drawing Olympiad</a></li>
              </ul>
            </div>
          </div>
        </div>-->
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 wow fadeInUp" data-wow-delay=".6s">
          <div class="single-footer-widget">
            <div class="widget-head">
              <h3>Competition</h3>
            </div>
            <div class="widget-content">
              <ul class="list-area">
                     <?php 
           
                $competitions = $commanmodel->all_multiple_query_order_by('competitions', ['status' => 'Active'], 'id', 'DESC');
                foreach($competitions as $competition): 
                ?>
                <li><a href="<?= base_url('competition-details/'.$competition->id) ?>"><?php echo $competition->title; ?></a></li>
                    <?php endforeach; ?>
             
              </ul>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".8s">
            
          <div class="single-footer-widget">
            <div class="widget-head">
              <h3>Subscribe Now</h3>
            </div>
     <div class="widget-content">
    <form class="footer-signUp-box" id="newsletterForm">
        <div class="input-wrapper input-style">
            <i class="far fa-envelope mail-icon"></i>
            <input type="email" id="newsletterEmail" name="email" placeholder="Enter your e-mail" required="" style="color: black;">
        </div>
        <button type="submit" class="theme-btn" id="subscribeBtn">
            Subscribe <i class="icon-arrow-icon"></i>
        </button>
    </form>
    <p>By subscribing, you’re accept <a href="<?php echo base_url('contact-us'); ?>"> Privacy Policy</a></p>
</div>
          </div>
        </div>
      </div>
      <div class="footer-bottom footer-bottom-2">
        <p class="wow fadeInLeft" data-wow-delay=".5s">© <a href="<?php echo base_url(''); ?>"> Zemsto </a> 2026 . All rights reserved | <a href="https://www.starwebmaker.com" target="_blank">Designed by Star Web Maker</a> </p>
        <ul class="social-icon social-two wow fadeInRight" data-wow-delay=".5s">
          <li> <a href="#"><i class="fab fa-facebook-f"></i></a> </li>
          <li> <a href="#"><i class="fab fa-twitter"></i></a> </li>
          <li> <a href="#"><i class="fab fa-linkedin-in"></i></a> </li>
          <li> <a href="#"><i class="fab fa-twitter"></i></a> </li>
        </ul>
      </div>
    </div>
  </div>
</footer>

<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/jquery-3.7.1.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/bootstrap.bundle.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/jquery.nice-select.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/odometer.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/jquery.appear.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/swiper-bundle.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/jquery.meanmenu.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/jquery.magnific-popup.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/wow.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/gsap.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/ScrollTrigger.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/SplitText.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/splitType.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/main.js"></script>


<?php
$uri = service('uri');

if ($uri->getPath() == '/') {
?>
<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/fly1.js" type="text/javascript"></script> 
<?php
}
?>

<script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/snd.js" type="text/javascript"></script>


<script>
$(document).ready(function() {

    // ============================================
    // NEWSLETTER SUBSCRIPTION - AJAX
    // ============================================
    $('#newsletterForm').on('submit', function(e) {
        e.preventDefault();
        
        var email = $('#newsletterEmail').val().trim();
        
        // Validation
        if (email === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please enter your email address.',
                confirmButtonColor: '#f7941d',
                confirmButtonText: 'OK'
            });
            return false;
        }
        
        // Email validation
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Email',
                text: 'Please enter a valid email address.',
                confirmButtonColor: '#f7941d',
                confirmButtonText: 'OK'
            });
            return false;
        }
        
        // Show loading
        $('#subscribeBtn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Subscribing...');
        $('#subscribeBtn').attr('disabled', true);
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('newsletter/subscribe') ?>",
            data: { email: email },
            dataType: "JSON",
            success: function(response) {
                $('#subscribeBtn').html('Subscribe <i class="icon-arrow-icon"></i>');
                $('#subscribeBtn').attr('disabled', false);
                
                if (response.status) {
                    // Success
                    Swal.fire({
                        icon: 'success',
                        title: 'Subscribed! 🎉',
                        text: response.message,
                        confirmButtonColor: '#f7941d',
                        confirmButtonText: 'Great!'
                    });
                    $('#newsletterEmail').val('');
                } else {
                    // Error
                    Swal.fire({
                        icon: 'error',
                        title: 'Subscription Failed',
                        text: response.message,
                        confirmButtonColor: '#f7941d',
                        confirmButtonText: 'Try Again'
                    });
                }
            },
            error: function() {
                $('#subscribeBtn').html('Subscribe <i class="icon-arrow-icon"></i>');
                $('#subscribeBtn').attr('disabled', false);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong. Please try again later.',
                    confirmButtonColor: '#f7941d',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

});
</script>
<script>
/*document.addEventListener('contextmenu', e => e.preventDefault());

document.addEventListener('keydown', function(e){

    if (e.key === 'F12') {
        e.preventDefault();
    }

    if (e.ctrlKey && e.shiftKey &&
        ['I','J','C'].includes(e.key.toUpperCase())) {
        e.preventDefault();
    }

    if (e.ctrlKey &&
        ['U','S'].includes(e.key.toUpperCase())) {
        e.preventDefault();
    }

});*/
</script>
        <script>
       
     function showAlert(alert_class, alert_title, alert_message) {
    Swal.fire({
        icon: alert_class,
        title: alert_title,
        text: alert_message,
        timer: 2000, // Timer in milliseconds (2 seconds)
        showConfirmButton: true // Show the "OK" button
    });
}
    </script>


</body>
</html>