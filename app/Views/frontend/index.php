
<?php 
use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
    $addressView = $commanmodel->get_single_query('address',array('id' => 1)); 
  $category = $commanmodel->all_multiple_query_order_by_limit('category',array('parent_id' => 0),'category_id','ASC',6);
   $banner = $commanmodel->all_multiple_query_order_by('home_banner',array('banner_status' => 'Active'),'banner_id','ASC');
   
   $gallery = $commanmodel->all_multiple_query_order_by('clients',array('client_status' => 'Active','type' => 'Signature Talks'),'client_id','ASC');
   
    $poet  = $commanmodel->all_multiple_query_order_by_limit('clients',array('client_status' => 'Active','type' => 'Poet'),'client_id','ASC',1);
   
     $team= $commanmodel->all_multiple_query_order_by('team',array(),'team_id','ASC');
        $newblog = $commanmodel->all_multiple_query_order_by_limit('blogs',array('blog_status' => 'Active'),'blog_id','ASC',3); 
?>


<section class="hero-section3 hero-3 fix">
  <div class="bottom-shape"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/hero/bottom-shape.png" alt=""> </div>
  <div class="swiper banner-active">
    <div class="swiper-wrapper">
          <?php foreach($banner as $bannerrow) { ?>
      <div class="swiper-slide">
        <div class="hero-height">
          <div class="hero-bg bg-cover" style="background-image: url('<?php echo base_url('assets/images/'); ?>/<?php echo $bannerrow->banner_image; ?>');"></div>
        </div>
      </div>
        <?php } ?>

    </div>
  </div>
</section>
<section class="work-process-section">
  <div class="section-title text-center" style="margin-bottom: 40px">
    <h2 class=""> Competitions for <span>Kids – Learn, Compete & Shine!</span> </h2>
  </div>
  <div class="bg-shape d-none d-xxl-block"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/work-process/big-shape.png" alt="shape-image"> </div>
  <div class="flower-shape d-none d-xxl-block"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/work-process/sunflower.png" alt="shape-image"> </div>
  <!-- frontend_competitions.php - Display on frontend -->
<div class="container">
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
<section class="learning-section section-padding fix">
  <div class="shadow-shape"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/learning/shadow.png" alt="shape-image"> </div>
  <div class="sky-shape float-bob-y"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/learning/sky.png" alt="shape-image"> </div>
  <div class="rocket-shape float-bob-x"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/learning/rocket.png" alt="shape-image"> </div>
  <div class="container">
    <div class="section-title text-center">
      <h2 class=" text-white"> Olympiads for <span> Every Young Mind</span> </h2>
    </div>
  <!-- frontend_olympiads.php -->
<div class="row">
    <?php 

    $olympiads = $commanmodel->all_multiple_query_order_by('olympiads', ['status' => 'Active'], 'id', 'ASC');
    $delay = 0.5;
    foreach($olympiads as $index => $olympiad): 
        $delayClass = '';
        if($index % 4 == 0) $delayClass = 'fadeInRight';
        elseif($index % 4 == 1) $delayClass = 'fadeInUp';
        else $delayClass = 'fadeInLeft';
    ?>
    <div class="col-xl-3 col-lg-6 col-md-6 wow <?php echo $delayClass; ?>" data-wow-delay="<?php echo $delay; ?>s">
        <div class="learning-box-items">
            <div class="learning-bg"></div>
            <div class="learning-image"> 
                <img src="<?php echo base_url('uploads/olympiads/images/' . $olympiad->image); ?>" alt="<?php echo $olympiad->title; ?>"> 
            </div>
            <div class="thumb-icon"> 
                <img src="<?php echo base_url('uploads/olympiads/icon_bg/' . $olympiad->icon_bg); ?>" alt="shape-img">
                <div class="icon"> 
                    <img src="<?php echo base_url('uploads/olympiads/icons/' . $olympiad->icon); ?>" alt="icon-image"> 
                </div>
            </div>
            <div class="learning-content">
                <h3><a href="#"><?php echo $olympiad->title; ?></a></h3>
                <p><?php echo $olympiad->description; ?></p>
                <a href="<?php echo base_url('register'); ?>" class="arrow-icon"><i class="fas fa-arrow-right"></i></a> 
            </div>
        </div>
    </div>
    <?php 
    $delay += 0.4;
    endforeach; 
    ?>
</div>
  </div>
	<div class="cloud-pattren2"></div>
</section>


<?php 
// Group subjects by class
$classGroups = [];
if (!empty($classes)) {
    foreach($classes as $row) {
        $classGroups[$row->class_name][] = $row;
    }
}
?>

<?php if(!empty($classGroups)): ?>
    <?php foreach($classGroups as $className => $subjects): 
        // Set background color based on class
        $bgColor = '';
        $bgClass = '';
        if($className == 'Nursery') {
            $bgColor = '#a2d476';
            $bgClass = 'nur';
        } elseif($className == 'LKG') {
            $bgColor = '#fecdbd';
            $bgClass = 'lkg';
        } elseif($className == 'UKG') {
            $bgColor = '#aacdff';
            $bgClass = 'ukg';
        } else {
            $bgColor = '#e8f0fe';
            $bgClass = 'other';
        }
    ?>
    <section class="work-process-section <?= $bgClass ?> comp-slider" style="padding-top: 60px; background-color: <?= $bgColor ?>">
        <div class="section-title text-center" style="margin-bottom: 40px">
            <h2 class=""> Syllabus & Practice for <span><?= $className ?></span> Students </h2>
        </div>
        <div class="bg-shape d-none d-xxl-block"> 
            <img src="<?= base_url('assets/frontend/assets/img/work-process/big-shape.png') ?>" alt="shape-image"> 
        </div>
        <div class="flower-shape d-none d-xxl-block"> 
            <img src="<?= base_url('assets/frontend/assets/img/work-process/sunflower.png') ?>" alt="shape-image"> 
        </div>
        <div class="container">
            <div class="row practs">
                <?php foreach($subjects as $subject): ?>
                <div class="col-md-3 col-sm-6 wow fadeInUp" data-wow-delay=".2s">
                    <div class="work-process-items">
                        <div class="work-image"> 
                            <?php if($subject->image && file_exists('assets/syllabus/images/' . $subject->image)): ?>
                            <img src="<?= base_url('assets/syllabus/images/' . $subject->image) ?>" alt="<?= $subject->subject_name ?>"> 
                            <?php else: ?>
                            <img src="<?= base_url('assets/frontend/assets/img/nur-1.png') ?>" alt="<?= $subject->subject_name ?>"> 
                            <?php endif; ?>
                        </div>
                        <div class="work-content">
                            <h2><?= $subject->subject_name ?></h2>
                            <p><?= substr($subject->description ?? '', 0, 50) ?>...</p>
                            <a href="<?= base_url('practice/questions/' . $subject->id) ?>" class="theme-btn">Practice</a>
                            <?php if(!empty($subject->pdf_file) && file_exists('assets/syllabus/pdf/' . $subject->pdf_file)): ?>
                            <a href="<?= base_url('assets/syllabus/pdf/' . $subject->pdf_file) ?>" class="theme-btn" target="_blank">Syllabus</a>
                            <?php else: ?>
                            <a href="javascript:void(0)" class="theme-btn disabled">Syllabus</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php if($className == 'Nursery'): ?>
        <div class="cloud-pattren3"></div>
        <?php elseif($className == 'LKG'): ?>
        <div class="cloud-pattren4"></div>
        <?php endif; ?>
    </section>
    <?php endforeach; ?>
<?php else: ?>
    <section class="work-process-section" style="padding-top: 60px; background-color: #f8f9fc;">
        <div class="container">
            <div class="text-center py-5">
                <h3><i class="fas fa-info-circle"></i> No syllabus available</h3>
                <p>Please check back later for updated content.</p>
            </div>
        </div>
    </section>
<?php endif; ?>

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
              <h2 class=""><?php echo $about19->cms_page_heading; ?></h2>
            </div>
            <p class="wow fadeInUp mt-3 mt-md-0" data-wow-delay=".3s"> <?php echo $about19->cms_page_description; ?></p>
            <div class="icon-box-items">
              <div class="icon-item wow fadeInUp" data-wow-delay=".5s">
                  <?php $about20 = $commanmodel->get_single_query('cms_pages',array('cms_id' => 20)); ?>
                <div class="icon"> <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about20->cms_image; ?>" alt="icon-image"> </div>
                <div class="content">
                  <h3><?php echo $about20->cms_page_heading; ?></h3>
       <?php echo $about20->cms_page_small_description; ?>
                </div>
              </div>
              <div class="icon-item wow fadeInUp" data-wow-delay=".7s">
                  <?php $about21 = $commanmodel->get_single_query('cms_pages',array('cms_id' => 21)); ?>
                <div class="icon style-2"> <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about21->cms_image; ?>" alt="icon-image"> </div>
                <div class="content">
                  <h3><?php echo $about21->cms_page_heading; ?></h3>
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


<section class="counter-section section-padding">
  <div class="snake-shape float-bob-y"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/counter/snake.png" alt="shape-img"> </div>
  <div class="sun-shape float-bob-x"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/counter/sun.png" alt="shape-img"> </div>
  <div class="counter-bg"></div>
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3 col-md-4 col-sm-6 col-6 wow fadeInUp" data-wow-delay=".2s">
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
      <div class="col-lg-3 col-md-4 col-sm-6 col-6 wow fadeInUp" data-wow-delay=".4s">
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
      <div class="col-lg-3 col-md-4 col-sm-6 col-6 wow fadeInUp" data-wow-delay=".6s">
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
      <div class="col-lg-3 col-md-4 col-sm-6 col-6 wow fadeInUp" data-wow-delay=".8s">
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
<section class="testimonial-section-2 section-padding fix">
  <div class="container">
    <div class="section-title text-center">
      <h2> Read  &amp; <span>Student’s Parent</span> Testimonials </h2>
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
<section class="contact-section section-padding">
  <div class="perasute-shape float-bob-y"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/contact/perasute.png" alt="shape-img"> </div>
  <div class="star-shape"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/contact/star.png" alt="shape-img"> </div>
  <div class="emoji-shape float-bob-x"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/contact/emoji.png" alt="shape-img"> </div>
  <div class="container">
    <div class="section-title-area custom-padding-top2">
      <div class="section-title">
        <h2 class="text-white"> Quick Contact With Us </h2>
      </div>
    </div>
    <div class="contact-wrapper">
      <div class="row g-4">
        <div class="col-xl-5 col-lg-5 col-md-4">
          <div class="contact-info wow fadeInLeft" data-wow-delay=".3s">
            <div class="icon"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/contact/microphone.svg" alt="icon-image"> </div>
            <div class="content">
              <h3>Contact us:</h3>
              <p style="color: #fff; font-size: 15px;"> <a href="#" class="text-white d-block">+91 <?php echo $addressView->phone_one;?></a>  </p>
            </div>
          </div>
          <div class="contact-info wow fadeInLeft" data-wow-delay=".5s">
            <div class="icon"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/contact/location.svg" alt="icon-image"> </div>
            <div class="content">
              <h3>Our Location:</h3>
              <p style="color: #fff; font-size: 15px;">Steller Greens Flat no-B 804,8th Floor, D-Block,<br>
                Sector-44, Noida, Uttar Pradesh 201303, India</p>
            </div>
          </div>
        </div>
        <div class="col-xl-7 col-lg-7 col-md-8">
          <div class="contact-from">
            <form action="#" class="contFrm" id="contactForms" method="POST">
              <div class="row">
                <div class="col-sm-6 wow fadeInLeft" data-wow-delay=".3s">
                  <input type="text" name="fullname" placeholder="Your Name" required class="inptFld">
                </div>
                <div class="col-sm-6 wow fadeInRight" data-wow-delay=".3s">
                  <input type="email" name="email" placeholder="Email Address" required class="inptFld">
                </div>
                <div class="col-sm-6 wow fadeInLeft" data-wow-delay=".5s">
                  <input type="tel" name="phone" placeholder="Phone Number" required class="inptFld">
                </div>
                <div class="col-sm-6 wow fadeInRight" data-wow-delay=".5s">
                  <input type="text" name="subject" placeholder="Subject" required class="inptFld">
                </div>
                <div class="col-sm-12 wow fadeInUp" data-wow-delay=".5s">
                  <textarea class="inptFld mb-0" name="message" placeholder="Your Message..." required ></textarea>
                </div>
              </div>
                <div class="contact-button wow fadeInUp" data-wow-delay=".7s">
              <button type="submit" class="theme-btn style-2">Send Your Message<i class="icon-arrow-icon"></i></button>
            </div>
            </form>
          
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="news-section section-padding fix">
  <div class="hut-shape float-bob-x"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/news/hute.png" alt="shape-img"> </div>
  <div class="sky-shape float-bob-y"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/news/sky.png" alt="shape-img"> </div>
  <div class="container">
    <div class="section-title text-center">
      <h2 class=""> Read <span>Our Latest</span> Blogs </h2>
    </div>
    <div class="row">
        
         <?php foreach($newblog as $newblogrow) { ?>

             
        
      <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay=".5s">
        <div class="news-card-items">
          <div class="news-image"> <img src="<?php echo base_url('assets/blog/').'/'.$newblogrow->blog_image; ?>" alt="news-image">
            <div class="news-layer-wrapper">
              <div class="news-layer-image" style="background-image: url('<?php echo base_url('assets/blog/').'/'.$newblogrow->blog_image; ?>');"></div>
              <div class="news-layer-image" style="background-image: url('<?php echo base_url('assets/blog/').'/'.$newblogrow->blog_image; ?>');"></div>
              <div class="news-layer-image" style="background-image: url('<?php echo base_url('assets/blog/').'/'.$newblogrow->blog_image; ?>');"></div>
              <div class="news-layer-image" style="background-image: url('<?php echo base_url('assets/blog/').'/'.$newblogrow->blog_image; ?>');"></div>
            </div>
          </div>
          <div class="news-content">
            <h3> <a href="<?php echo base_url('blog-detail/').'/'.$newblogrow->url_slug; ?>" class="underline"><?php echo $newblogrow->blog_name; ?></a> </h3>
            <p><?php echo $newblogrow->blog_small_description; ?></p>
            <ul class="author-items">
              <li><i class="far fa-user"></i>Admin</li>
              <li class="calendar"><i class="far fa-calendar-alt"></i> <?php echo date('Y-m-d', strtotime($newblogrow->date_time)); ?></li>
            </ul>
          </div>
        </div>
      </div>
      <?php } ?>
     

    </div>
  </div>
</section>
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