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
<section class="olmp section-registration">
  <div class="container">
    <div class="section-title"> <span class="sub-title"> ✦ Academic Excellence </span>
      <h2 style="margin-bottom: 10px">Olympiads for <span>Every</span> Young Mind</h2>
      <p>Our Olympiads are designed to inspire curiosity, enhance knowledge, and develop essential skills in children of all ages. Through engaging and challenging competitions, we encourage young minds to think creatively, solve problems confidently, and achieve academic excellence while enjoying the learning journey.</p>
    </div>
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
</section>
<section class="counter-section section-padding">
  <div class="snake-shape float-bob-y"> <img src="assets/img/counter/snake.png" alt="shape-img"> </div>
  <div class="sun-shape float-bob-x"> <img src="assets/img/counter/sun.png" alt="shape-img"> </div>
  <div class="counter-bg"></div>
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".2s">
        <div class="counter-items">
          <div class="counter-box">
            <div class="count">
              <h3 class="btss">21</h3>
            </div>
            <p>Total  Olympiads</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".4s">
        <div class="counter-items">
          <div class="counter-box">
            <div class="count">
              <h3 class="btss">KG–12</h3>
            </div>
            <p>All Grades Welcome</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".6s">
        <div class="counter-items">
          <div class="counter-box">
            <div class="count">
              <h3 class="btss">🌍</h3>
            </div>
            <p>India & International</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".8s">
        <div class="counter-items border-none">
          <div class="counter-box">
            <div class="count">
              <h3 class="btss">🏆</h3>
            </div>
            <p>Trophies, Prizes & Certificates</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="program-section-two section-padding fix">
  <div class="container">
    <div class="section-title text-center"> <span class="sub-title wow fadeInUp">Simple Process</span>
      <h2 class="char-animation"> How to <span> Participate?</span></h2>
      <p>Three simple steps — from registration to receiving your rewards.</p>
    </div>
    <div class="program-wrapper">
      <div class="row text-center">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 wow fadeInLeft" data-wow-delay=".2s">
          <div class="program-items">
            <div class="icon-box">
              <div class="icon"> <img src="assets/img/program/icon1.svg" alt="icon-image"> </div>
              <div class="program-waves">
                <div class="waves wave-1"></div>
                <div class="waves wave-2"></div>
                <div class="waves wave-3"></div>
              </div>
              <div class="arrow-shape"> <img src="assets/img/program/arrow-right.png" alt="shape-image"> </div>
            </div>
            <div class="program-content">
              <h3>Register</h3>
              <p>Click the Register button on your chosen competition or Olympiad and fill in the registration form with your details.</p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 wow fadeInLeft" data-wow-delay=".4s">
          <div class="program-items">
            <div class="icon-box">
              <div class="icon"> <img src="assets/img/program/icon2.svg" alt="icon-image"> </div>
              <div class="program-waves">
                <div class="waves wave-1 "></div>
                <div class="waves wave-2 "></div>
                <div class="waves wave-3 "></div>
              </div>
              <div class="arrow-shape"> <img src="assets/img/program/arrow-right2.png" alt="shape-image"> </div>
            </div>
            <div class="program-content">
              <h3>Submit Your Entry</h3>
              <p>Upload your artwork, video, or written submission using the link shared after registration — before the deadline.</p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 wow fadeInLeft" data-wow-delay=".6s">
          <div class="program-items">
            <div class="icon-box">
              <div class="icon"> <img src="assets/img/program/icon3.svg" alt="icon-image"> </div>
              <div class="program-waves">
                <div class="waves wave-1 "></div>
                <div class="waves wave-2 "></div>
                <div class="waves wave-3 "></div>
              </div>
            </div>
            <div class="program-content">
              <h3>Win Rewards</h3>
              <p>Await the results and receive trophies, prizes and certificates — every participant gets recognised!</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<section class="participate-section">
  <div class="container">
    <h2 style="color: #fff">Who Can Participate?</h2>
    <p> All competitions and Olympiads are open for students across India and
      internationally — from Kindergarten all the way to Grade 12. </p>
    <div class="participate-tags"> <span class="badge-item"> 👶 Kindergarten </span> <span class="badge-item"> 📗 Grade 1 – 3 </span> <span class="badge-item"> 📘 Grade 4 – 6 </span> <span class="badge-item"> 📙 Grade 7 – 9 </span> <span class="badge-item"> 📕 Grade 10 – 12 </span> <span class="badge-item"> 🇮🇳 India </span> <span class="badge-item"> 🌍 International </span> </div>
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