<section class="news-section news-standard inner-padding">
  <div class="container">
	  
    <div class="news-details-area">
      <div class="row">
        <div class="col-lg-8">
          <div class="blog-post-details">
            <div class="single-blog-post">
              
              <div class="post-content">
				  <h2 class="headline char-animation"> <?php echo $blogs->blog_name; ?> </h2>
                <ul class="post-list d-flex align-items-center wow fadeInUp" data-wow-delay=".3s">
                  <li> <i class="fas fa-user-circle"></i> Admin </li>
                  <li> <i class="far fa-calendar-alt"></i> <?php echo date('Y-m-d', strtotime($blogs->date_time)); ?></li>
                 
                </ul>
				  <div><img src="<?php echo base_url('assets/blog/').'/'.$blogs->blog_image; ?>" style="width: 100%; margin-bottom: 20px; border-radius: 10px"></div>
                
     <?php echo $blogs->blog_description; ?>
              </div>
            </div>
            
            
          </div>
        </div>
        <div class="col-lg-4">
          <div class="main-sidebar">
           
            <div class="single-sidebar-widget">
              <div class="wid-title char-animation">
                <h3>Recent Post</h3>
              </div>
              <div class="recent-post-area">
                   <?php foreach($newblog as $newblogrow) { ?>
                <div class="recent-items wow fadeInLeft" data-wow-delay=".3s">
                  <div class="recent-thumb"> <img src="<?php echo base_url('assets/blog/').'/'.$newblogrow->blog_image; ?>" style="width: 100%;" alt="img"> </div>
                  <div class="recent-content">
                    <ul>
                      <li> <i class="far fa-calendar-alt"></i> <?php echo date('Y-m-d', strtotime($newblogrow->date_time)); ?> </li>
                    </ul>
                    <h4> <a href="<?php echo base_url('blog-detail/').'/'.$newblogrow->url_slug; ?>"> <?php echo $newblogrow->blog_name; ?></a> </h4>
                  </div>
                </div>
                   <?php } ?>
              
        
              </div>
            </div>
  <!--          <div class="single-sidebar-widget">
              <div class="wid-title char-animation">
                <h3>Categories</h3>
              </div>
              <div class="news-widget-categories">
                <ul>
                  <li class="wow fadeInLeft" data-wow-delay=".2s"><a href="news-details.html"> Olympiads</a> <span>(5)</span></li>
                  <li class="wow fadeInLeft" data-wow-delay=".3s"><a href="news-details.html">Activities</a> <span>(3)</span></li>
                  <li class="active wow fadeInLeft" data-wow-delay=".4s"><a href="news-details.html">Winners </a><span>(6)</span></li>
                  <li class="wow fadeInLeft" data-wow-delay=".5s"><a href="news-details.html">Hall of Fame</a> <span>(2)</span></li>
                  <li class="wow fadeInLeft" data-wow-delay=".6s"><a href="news-details.html">Results</a> <span>(4)</span></li>
                  <li class="wow fadeInLeft" data-wow-delay=".7s"><a href="news-details.html">Examination</a> <span>(7)</span></li>
                </ul>
              </div>
            </div>-->
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>