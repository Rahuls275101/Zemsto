

<?php
use App\Models\Commanmodel;

$commanmodel = new Commanmodel();
  $addressView = $commanmodel->get_single_query('address',array('id' => 1)); 
  $team= $commanmodel->all_multiple_query_order_by('team',array(),'team_id','ASC');
?>


                 <?php $about= $commanmodel->get_single_query('cms_pages',array('cms_id' => 1)); ?>
                  
    <section class="about-section inner-padding">
  <div class="container">
    <div class="row align-items-center justify-content-between"> 
      
      <!-- Left Content -->
      <div class="col-lg-6">
        <div class="section-title"> <span class="sub-title"> ✦ ABOUT Zemsto </span>
          <h2 class="about-title mt-4 mb-2"> <?php echo $about->cms_page_heading; ?></h2>
        </div>
       <?php echo $about->cms_page_description; ?> 
        <div class="d-flex flex-wrap gap-3 mt-5"> <a href="<?php echo base_url('register'); ?>" class="theme-btn"> Register Now → </a> <a href="<?php echo base_url('winners-member'); ?>" class="border-btn"> Meet the Team </a> </div>
      </div>
      
      <!-- Right Stats -->
      <div class="col-lg-5">
        <div class="stat-card mb-4">
              <?php $about31= $commanmodel->get_single_query('cms_pages',array('cms_id' => 31)); ?>
          <div class="stat-icon"> 📅 </div>
          <div>
            <h3><?php echo $about31->cms_page_heading; ?></h3>
            <h5><?php echo $about31->cms_page_small_description; ?></h5>
            <p><?php echo $about31->cms_page_description; ?> </p>
          </div>
        </div>
        <div class="stat-card mb-4">
              <?php $about32 = $commanmodel->get_single_query('cms_pages',array('cms_id' => 32)); ?>
          <div class="stat-icon"> 🧒 </div>
          <div>
            <h3><?php echo $about32->cms_page_heading; ?></h3>
            <h5><?php echo $about32->cms_page_small_description; ?></h5>
            <p> <?php echo $about32->cms_page_description; ?> </p>
          </div>
        </div>
        <div class="stat-card">
              <?php $about33 = $commanmodel->get_single_query('cms_pages',array('cms_id' => 33)); ?>
          <div class="stat-icon"> 🌍 </div>
          <div>
            <h3><?php echo $about33->cms_page_heading; ?></h3>
            <h5><?php echo $about33->cms_page_small_description; ?></h5>
            <p><?php echo $about33->cms_page_description; ?> </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="counter-section section-padding">
  <div class="snake-shape float-bob-y"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/counter/snake.png" alt="shape-img"> </div>
  <div class="sun-shape float-bob-x"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/counter/sun.png" alt="shape-img"> </div>
  <div class="counter-bg"></div>
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".2s">
        <div class="counter-items">
              <?php $about22= $commanmodel->get_single_query('cms_pages',array('cms_id' => 22)); ?>
          <div class="icon"> <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about22->cms_image; ?>" alt="icon-image"> </div>
          <div class="counter-box">
            <div class="count">
              <h3 class="odometer" data-count="<?php echo $about22->cms_page_heading; ?>">0</h3>
              <span class="plus">+</span> </div>
            <p> <?php echo $about22->cms_page_small_description; ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".4s">
        <div class="counter-items">
              <?php $about23= $commanmodel->get_single_query('cms_pages',array('cms_id' => 23)); ?>
          <div class="icon"> <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about23->cms_image; ?>" alt="icon-image"> </div>
          <div class="counter-box">
            <div class="count">
              <h3 class="odometer" data-count="<?php echo $about23->cms_page_heading; ?>">0</h3>
              <span class="plus">+</span> </div>
            <p> <?php echo $about23->cms_page_small_description; ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".6s">
        <div class="counter-items">
              <?php $about24= $commanmodel->get_single_query('cms_pages',array('cms_id' => 24)); ?>
          <div class="icon"> <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about24->cms_image; ?>" alt="icon-image"> </div>
          <div class="counter-box">
            <div class="count">
              <h3 class="odometer" data-count="<?php echo $about24->cms_page_heading; ?>">0</h3>
              <span class="plus">+</span> </div>
            <p> <?php echo $about24->cms_page_small_description; ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".8s">
        <div class="counter-items border-none">
              <?php $about25= $commanmodel->get_single_query('cms_pages',array('cms_id' => 25)); ?>
          <div class="icon"> <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about25->cms_image; ?>" alt="icon-image"> </div>
          <div class="counter-box">
            <div class="count">
              <h3 class="odometer" data-count="<?php echo $about25->cms_page_heading; ?>">0</h3>
              <span class="plus">+</span> </div>
            <p> <?php echo $about25->cms_page_small_description; ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="about-section-two section-padding fix">
  <div class="love-shape float-bob-x"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/about/love.png" alt="shape-img"> </div>
  <div class="container">
    <div class="about-wrapper-2 about-activities-wrapper">
      <div class="row g-4">
          <?php $about19= $commanmodel->get_single_query('cms_pages',array('cms_id' => 19)); ?>
        <div class="col-lg-6">
          <div class="about-activities-image">
            <div class="about-image"> <img class="img-custom-anim-bottom" src="<?php echo base_url('assets/images/'); ?>/<?php echo $about19->cms_image; ?>" alt="about-image" style="width:100%">
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6">
          <div class="about-content-two">
              
            <div class="section-title" style="margin-bottom: 10px;">
              <h2 class="char-animation"><?php echo $about19->cms_page_heading; ?></h2>
            </div>
            <p class="wow fadeInUp mt-3 mt-md-0" data-wow-delay=".3s"> <?php echo $about19->cms_page_description; ?></p>
            <div class="icon-box-items">
              <div class="icon-item wow fadeInUp" data-wow-delay=".5s">
                  <?php $about20 = $commanmodel->get_single_query('cms_pages',array('cms_id' => 20)); ?>
                <div class="icon"> <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about20->cms_image; ?>" alt="icon-image"> </div>
                <div class="content">
                  <h3 class="mb-2"><?php echo $about20->cms_page_heading; ?></h3>
       <?php echo $about20->cms_page_small_description; ?>
                </div>
              </div>
              <div class="icon-item wow fadeInUp" data-wow-delay=".7s">
                  <?php $about21 = $commanmodel->get_single_query('cms_pages',array('cms_id' => 21)); ?>
                <div class="icon style-2"> <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about21->cms_image; ?>" alt="icon-image"> </div>
                <div class="content">
                  <h3 class="mb-2"><?php echo $about21->cms_page_heading; ?></h3>
                 <?php echo $about21->cms_page_small_description; ?>
                </div>
              </div>
            </div>
            <div class="about-two-button wow fadeInUp" data-wow-delay=".8s"> <a href="<?php echo base_url('about-us'); ?>" class="theme-btn">Apply Now <i class="icon-arrow-icon"></i></a>
              <div class="wave-area">
                <div class="promo-video">
                  <div class="waves-block">
                    <div class="waves wave-1"></div>
                    <div class="waves wave-2"></div>
                    <div class="waves wave-3"></div>
                  </div>
                  <a class="video-popup" href="https://www.youtube.com/watch?v=Cn4G2lZ_g2I"> <i class="fas fa-play"></i> </a> </div>
                <p class="video-text">Paly Video</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="feature-section choose-us-section choose-us-section-2 section-padding fix" style="background: #fff">
  <div class="sun-shape float-bob-y"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/feature/sun.png" alt="shape-image"> </div>
  <div class="sky-shape"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/feature/sky.png" alt="shape-image"> </div>
  <div class="butterfly-shape float-bob-y"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/feature/butterfly.png" alt="shape-image"> </div>
  <div class="container">
    <div class="feature-wrapper choose-us-wrapper choose-us-wrapper-two">
      <div class="row">
        <div class="col-xl-6 col-lg-6">
          <div class="choose-us-content">
                   <?php $about6= $commanmodel->get_single_query('cms_pages',array('cms_id' => 6)); ?>
            <div class="section-title"> <span class="sub-title wow fadeInUp"> What We Stand For</span>
              <h2 class="char-animation"><?php echo $about6->cms_page_heading; ?></h2>
              <p class="wow fadeInUp" data-wow-delay=".3s"><?php echo $about6->cms_page_small_description; ?></p>
            </div>
            <div class="row g-4">
              <div class="col-xl-6 col-lg-6 col-md-6 wow zoomIn" data-wow-delay=".4s">
                <div class="choose-img-items">
                         <?php $about7= $commanmodel->get_single_query('cms_pages',array('cms_id' => 7)); ?>
                  <div class="icon-box"> <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about7->cms_image; ?>" alt="svg-image">
                    <h4><?php echo $about7->cms_page_heading; ?></h4>
                    <p><?php echo $about7->cms_page_small_description; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 wow zoomIn" data-wow-delay=".4s">
                <div class="choose-img-items">
                         <?php $about15= $commanmodel->get_single_query('cms_pages',array('cms_id' => 15)); ?>
                  <div class="icon-box box-1"> <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about15->cms_image; ?>" alt="svg-image">
                    <h4><?php echo $about15->cms_page_heading; ?></h4>
                    <p><?php echo $about15->cms_page_small_description; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 wow zoomIn" data-wow-delay=".4s">
                <div class="choose-img-items">
                         <?php $about16= $commanmodel->get_single_query('cms_pages',array('cms_id' => 16)); ?>
                  <div class="icon-box box-2"> <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about16->cms_image; ?>" alt="svg-image">
                    <h4><?php echo $about16->cms_page_heading; ?></h4>
                    <p><?php echo $about16->cms_page_small_description; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 wow zoomIn" data-wow-delay=".4s">
                <div class="choose-img-items">
                         <?php $about17= $commanmodel->get_single_query('cms_pages',array('cms_id' => 17)); ?>
                  <div class="icon-box box-3"> <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about17->cms_image; ?>" alt="svg-image">
                    <h4><?php echo $about17->cms_page_heading; ?></h4>
                    <p><?php echo $about17->cms_page_small_description; ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6">
          <div class="feature-image">
            <div class="feature-bg"> <img class="img-custom-anim-top" src="<?php echo base_url('assets/images/'); ?>/<?php echo $about6->cms_image; ?>" alt="feature-image" style="width:100%"> </div>
            <a href="tel:<?php echo $addressView->phone_one;?>"><i class="fas fa-phone-alt"></i>+91 <?php echo $addressView->phone_one;?></a> </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="pricing-section section-padding fix">
  <div class="snake-shape"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/pricing/snake.png" alt="shape-image"> </div>
  <div class="crown-shape"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/pricing/crown.png" alt="shape-image"> </div>
  <div class="tubelight-shape"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/pricing/tubelight.png" alt="shape-image"> </div>

  <div class="sky-shape"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/newsletter/sky.png" alt="shape-image"> </div>
  <div class="star-shape"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/newsletter/star.png" alt="shape-image"> </div>
  <div class="container">
    <div class="section-title text-center"> <span class="sub-title">Our TEAM</span>
      <h2 class="char-animation">Most Dedicated <span>team</span> for Your Child </h2>
    </div>
 <!-- Team Section Frontend Display -->
<div class="row g-4">
    <?php

    $teachers = $commanmodel->getDataFromTable('teacher', ['teacher_status' => 'Active'], ['column' => 'teacher_id', 'order' => 'DESC'], 100, 0);
    $teachers = $teachers['filteredRecords'];
    
    $delays = ['.2s', '.4s', '.2s', '.4s'];
    $i = 0;
    foreach ($teachers as $teacher): 
    ?>
    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?= $delays[$i % 4] ?>">
        <div class="team-box">
            <div class="team-image">
                <img src="<?= base_url('assets/teacher/' . $teacher->teacher_image) ?>" alt="<?= $teacher->teacher_name ?>">
            </div>
            <div class="social-profile">
                <ul class="social-icon">
                    <?php if ($teacher->teacher_facebook): ?>
                    <li><a href="<?= $teacher->teacher_facebook ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <?php endif; ?>
                    <?php if ($teacher->teacher_instagram): ?>
                    <li><a href="<?= $teacher->teacher_instagram ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <?php endif; ?>
                    <?php if ($teacher->teacher_linkedin): ?>
                    <li><a href="<?= $teacher->teacher_linkedin ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                    <?php endif; ?>
                    <?php if ($teacher->teacher_twitter): ?>
                    <li><a href="<?= $teacher->teacher_twitter ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                    <?php endif; ?>
                </ul>
                <a href="#" class="share-btn"><i class="fas fa-share-alt"></i></a>
            </div>
            <div class="team-content">
                <h3><a href="#"><?= $teacher->teacher_name ?></a></h3>
                <p><?= $teacher->teacher_position ?></p>
            </div>
        </div>
    </div>
    <?php 
    $i++;
    endforeach; 
    ?>
</div>
  </div>
</section>
<section class="testimonial-section-2 section-padding fix">
  <div class="container">
    <div class="section-title text-center">
      <h2 class="char-animation"> Read  &amp; <span>Student’s Parent</span> Testimonials </h2>
    </div>
    <div class="testimonial-wrapper-2">
      <div class="swiper testimonial-slider">
        <div class="swiper-wrapper">
            
            <?php foreach($team as $teamrow) { ?>
          <div class="swiper-slide wow fadeInUp" data-wow-delay=".2s">
            <div class="testimonial-box-items">
              <div class="testi-item-bg"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/testimonial/bg-border-1.png" alt="shape-image"> </div>
              <div class="testimonial-content">
                <div class="client-image-2"> <img src="<?php echo base_url('assets/team/').'/'.$teamrow->team_logo; ?>" alt="client-image">
                  <ul class="icon">
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                  </ul>
                </div>
                <p><?php echo $teamrow->overview; ?></p>
                <div class="client-info-2">
                  <h3><?php echo $teamrow->team_name; ?></h3>
                  <p><?php echo $teamrow->designation; ?></p>
                </div>
              </div>
            </div>
          </div>
          
          <?php } ?>
      

        </div>
      </div>
      <div class="array-button">
        <button class="array-prev"><i class="fal fa-arrow-left"></i></button>
        <button class="array-next"><i class="fal fa-arrow-right"></i></button>
      </div>
    </div>
  </div>
</section>