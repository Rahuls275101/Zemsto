
<?php 

use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
   $addressView = $commanmodel->get_single_query('address',array('id' => 1)); 
    $request = service('request');
     $session = session();
     
      $faq1 = $commanmodel->all_multiple_query_order_by_limit('faq',array('faq_status' => 'Active','type' => 'Competitions & Olympiads'),'faq_id','ASC',100);
       $faq2 = $commanmodel->all_multiple_query_order_by_limit('faq',array('faq_status' => 'Active','type' => 'Registration & Fees'),'faq_id','ASC',100);
        $faq3 = $commanmodel->all_multiple_query_order_by_limit('faq',array('faq_status' => 'Active','type' => 'Delivery & Tracking'),'faq_id','ASC',100);
    
?>

   
  
  
  
  <section class="faq-section inner-padding">
  <div class="container">
    <div class="faq-wrapper">
      <div class="row g-4">
        <div class="col-lg-5">
          <div class="faq-tittle">
                 <?php $about18= $commanmodel->get_single_query('cms_pages',array('cms_id' => 18)); ?>
            <div class="section-title"> <span class="sub-title wow fadeInUp">Help Centre</span>
              <h2 class="char-animation"> <?php echo $about18->cms_page_heading; ?> </h2>
            </div>
            <p class="mt-3 mt-md-0 wow fadeInUp" data-wow-delay=".5s"><?php echo $about18->cms_page_small_description; ?></p>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="faq-box-item" style="margin-bottom: 40px">
            <div style="margin-bottom: 20px">
              <h3 style="font-size: 29px;">Competitions & Olympiads</h3>
              <p>Participation, eligibility and details</p>
            </div>
            <ul class="accordion-box">
              <!--Block-->
              
                   <?php foreach($faq1 as  $key => $faqrow) { ?>
              <li class="accordion block  <?php if($key == 0) { ?> active-block  <?php } else { ?>  <?php } ?> wow fadeInUp">
                <div class="acc-btn  <?php if($key == 0) { ?> active <?php } else { ?>  <?php } ?>"> <?php echo $faqrow->faq_question; ?>?
                  <div class="icon far fa-plus-circle"></div>
                </div>
                <div class="acc-content  <?php if($key == 0) { ?> current <?php } else { ?>  <?php } ?>">
                  <div class="content">
                    <div class="text"> <?php echo $faqrow->faq_answer; ?></div>
                  </div>
                </div>
              </li>
              
                      <?php } ?>
             
      
            </ul>
          </div>
          <div class="faq-box-item" style="margin-bottom: 40px">
            <div style="margin-bottom: 20px">
              <h3 style="font-size: 29px;">Registration & Fees</h3>
              <p>Process, fees and refund policy</p>
            </div>
            <ul class="accordion-box">
              <!--Block-->
           <?php foreach($faq2 as  $key => $faqrow) { ?>
              <li class="accordion block  <?php if($key == 0) { ?> active-block  <?php } else { ?>  <?php } ?> wow fadeInUp">
                <div class="acc-btn  <?php if($key == 0) { ?> active <?php } else { ?>  <?php } ?>"> <?php echo $faqrow->faq_question; ?>?
                  <div class="icon far fa-plus-circle"></div>
                </div>
                <div class="acc-content  <?php if($key == 0) { ?> current <?php } else { ?>  <?php } ?>">
                  <div class="content">
                    <div class="text"> <?php echo $faqrow->faq_answer; ?></div>
                  </div>
                </div>
              </li>
              
                      <?php } ?>
             

            </ul>
          </div>
          <div class="faq-box-item" style="margin-bottom: 40px">
            <div style="margin-bottom: 20px">
              <h3 style="font-size: 29px;">Delivery & Tracking</h3>
              <p>Trophies, medals and certificates</p>
            </div>
            <ul class="accordion-box">
              <!--Block-->
      <?php foreach($faq3 as  $key => $faqrow) { ?>
              <li class="accordion block  <?php if($key == 0) { ?> active-block  <?php } else { ?>  <?php } ?> wow fadeInUp">
                <div class="acc-btn  <?php if($key == 0) { ?> active <?php } else { ?>  <?php } ?>"> <?php echo $faqrow->faq_question; ?>?
                  <div class="icon far fa-plus-circle"></div>
                </div>
                <div class="acc-content  <?php if($key == 0) { ?> current <?php } else { ?>  <?php } ?>">
                  <div class="content">
                    <div class="text"> <?php echo $faqrow->faq_answer; ?></div>
                  </div>
                </div>
              </li>
              
                      <?php } ?>
             

            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>