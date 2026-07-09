<?php 

use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
   $addressView = $commanmodel->get_single_query('address',array('id' => 1)); 
?>

<!-- Contact Section Start -->
<section class="contact-section-inner inner-padding">
  <div class="container">
    <div class="contact-wrapper mt-0 mb-0 contact-wrapper-two">
      <div class="row g-4 align-items-center">
        <div class="col-xl-6 col-lg-6">
          <div class="contact-info-items">
            <div class="section-title text-center text-lg-start" style="margin-bottom: 16px;"> <span class="sub-title wow fadeInUp">We're here to help</span>
              <h2 class="char-animation"> Get in Touch <span>With Us</span> </h2>
            </div>
            <p class="wow fadeInUp mt-3 mt-md-0 text-center text-lg-start" data-wow-delay=".3s">Have a question about a competition, Olympiad, or online class? Our team is always ready to help — reach out through any channel below.</p>
            <div class="contact-info contact-info-two wow fadeInLeft" data-wow-delay=".3s">
              <div class="icon"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/contact/phone.svg" alt="icon-image"> </div>
              <div class="content"> <span>Call Us</span>
                <h3> <a href="tel:+<?php echo $addressView->phone_one;?>">+91 <?php echo $addressView->phone_one;?></a> </h3>
               <!-- <p>Mon – Sat, 9 AM – 6 PM IST</p>-->
              </div>
            </div>
            <div class="contact-info contact-info-two wow fadeInLeft" data-wow-delay=".5s">
              <div class="icon"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/contact/share.svg" alt="icon-image"> </div>
              <div class="content"> <span>Send Email</span>
                <h3> <a href="mailto:<?php echo $addressView->email_two;?>"><?php echo $addressView->email_two;?></a> </h3>
               <!-- <p>We reply within 24 hours</p>-->
              </div>
            </div>
            <div class="contact-info contact-info-two wow fadeInLeft" data-wow-delay=".7s">
              <div class="icon"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/contact/location01.svg" alt="icon-image"> </div>
              <div class="content"> <span>Visit Us</span>
                <h3><?php echo $addressView->address_tow;?></h3>
              </div>
            </div>
            <div class="contact-info contact-info-two wow fadeInLeft" data-wow-delay=".7s">
              <div class="icon"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/contact/location01.svg" alt="icon-image"> </div>
              <div class="content"> <span>Registered Office</span>
                <h3><?php echo $addressView->address;?></h3>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6">
          <div class="contact-from contact-from-two">
            <h2 class="text-white mb-3">Send Your Message</h2>
            <form action="" class="contFrm contFrm-two" id="contactForms" method="POST">
              <div class="row">
                <div class="col-sm-6 wow fadeInRight" data-wow-delay=".4s"> <span>Name</span>
                  <input type="text" name="fullname" placeholder="Your Name" required class="inptFld">
                </div>
                <div class="col-sm-6 wow fadeInLeft" data-wow-delay=".4s"> <span>Your Email</span>
                  <input type="email" name="email" placeholder="Email Address" required class="inptFld">
                </div>
                <div class="col-sm-12 wow fadeInRight" data-wow-delay=".5s"> <span>Phone</span>
                  <input type="tel" name="phone" placeholder="Phone Number" required class="inptFld">
                </div>
                <div class="col-sm-12 wow fadeInUp" data-wow-delay=".6s"> <span>Your message</span>
                  <textarea class="inptFld inptFld-2 mb-0" name="message" required placeholder="Your Message..."></textarea>
                </div>
              </div>
                  <div class="contact-button wow fadeInUp" data-wow-delay=".7s">
              <button type="submit" class="theme-btn">Send Your Message<i class="icon-arrow-icon"></i></button>
            </div>
            </form>
        
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Map Section Start -->
<div class="map-section">
  <div class="map-items">
    <div class="googpemap">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3504.3548723223676!2d77.3460054!3d28.5591046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce5895ca91d57%3A0xfcb441b0cadac5d!2sStellar%20Greens%20Apartments!5e0!3m2!1sen!2sin!4v1781700197546!5m2!1sen!2sin" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous">
</script>
<script>
$(document).ready(function(){
    $('#contactForms').on('submit', function(e){
        e.preventDefault();

        var formData = $(this).serialize(); // No file, simple form

        $.ajax({
            url: "<?= base_url('contact/send') ?>", // Controller function
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response){
                if(response.status == 'success'){
                   
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Your message has been sent successfully.',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>
