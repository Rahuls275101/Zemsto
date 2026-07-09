   <?php
use App\Models\Commanmodel;

$commanmodel = new Commanmodel();

 
?>
<style>.learning-box-items .learning-content .arrow-icon {
    position: absolute;
    background-color: var(--theme-color-2);
    width: 50px;
    height: 46px;
    line-height: 46px;
    text-align: center;
    border-radius: 14px;
    left: 50%;
    bottom: -58px;
    transform: translate(-50%);
}</style>


<section class="work-process-section olmp section-registration">
  <div class="container">
    <div class="section-title"> <span class="sub-title"> ✦ Academic Excellence </span>
      <h2 class=""> Competitions for <span>Kids – Learn, Compete & Shine!</span> </h2>
      <p>Unlock your child's potential through exciting competitions that inspire creativity, confidence, and academic excellence.</p>
    </div>
    

  <div class="bg-shape d-none d-xxl-block"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/work-process/big-shape.png" alt="shape-image"> </div>
  <div class="flower-shape d-none d-xxl-block"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/work-process/sunflower.png" alt="shape-image"> </div>
  <!-- frontend_competitions.php - Display on frontend -->
    <div class="testimonial-wrapper-2">
        <div class="swiper comp-slider">
            <div class="swiper-wrapper">
                <?php 
           
                $competitions = $commanmodel->all_multiple_query_order_by('competitions', ['status' => 'Active'], 'id', 'DESC');
                foreach($competitions as $competition): 
                ?>
                <div class="swiper-slide wow fadeInUp" data-wow-delay=".2s">
                    <div class="work-process-items comp">
                        <div class="work-image"> 
                            <img src="<?php echo base_url('uploads/competitions/' . $competition->image); ?>" alt="<?php echo $competition->title; ?>"> 
                        </div>
                        <div class="work-content">
                            <h2><?php echo $competition->title; ?></h2>
                            <p><?php echo $competition->description; ?></p>
                            <a href="<?= base_url('competition-details/'.$competition->id) ?>" class="theme-btn">Apply Now <i class="icon-arrow-icon"></i></a> 
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="array-button">
            <button class="array-prev"><i class="fal fa-arrow-left"></i></button>
            <button class="array-next"><i class="fal fa-arrow-right"></i></button>
        </div>
    </div>
</div>
</section>

<!-- CTA Section -->
<section class="cta-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-9">
        <h2 style="color: #fff">Ready to Let Your Child Shine?</h2>
        <p> Pick a competition, register in minutes, and give your child
          the stage they deserve — nationally and internationally. </p>
      </div>
      <div class="col-lg-3 text-lg-end mt-4 mt-lg-0"> <a href="#" class="theme-btn"> Browse &amp; Register → </a> </div>
    </div>
    <i class="fa-solid fa-trophy trophy-icon"></i> </div>
</section>