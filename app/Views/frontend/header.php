<?php 

use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
   $addressView = $commanmodel->get_single_query('address',array('id' => 1)); 
    $request = service('request');
     $session = session();
     
      
?>


<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
 
<meta property="og:url" content="<?php echo $pageurl; ?>" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $title; ?>" />
<meta property="og:description" content="<?php echo $description; ?>" />
<meta property="og:image" content="<?php echo $pageimage;?>" />
<meta name="twitter:card" content="summary_large_image">
<title><?php echo $title; ?></title>
<meta name="description" content="<?php echo $description; ?>"/>
<meta name="keywords" content="<?php echo $keyword; ?>" />
<meta name="copyright" content=""/>
<meta name="author" content=" " />
<meta name="email" content="" />
<meta name="Distribution" content="Global" />
<meta name="page-topic" content=" " />
<meta name="page-type" content="Rich Internet Media" />
<meta name="Rating" content="General" />
<meta name="Robots" content="INDEX,FOLLOW" />
<meta name="Revisit-after" content="7 Days" />
<link rel="canonical" href="<?= current_url(); ?>" />
<meta name="site" content=" " />



 <link rel="shortcut icon" href="<?php echo base_url('assets/frontend/'); ?>/assets/images/img/favicon.png" type="image/png">

<link rel="shortcut icon" href="<?php echo base_url('assets/frontend/'); ?>/assets/img/favicon.png">
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>/assets/css/font-awesome.css">
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>/assets/css/animate.css">
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>/assets/css/magnific-popup.css">
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>/assets/css/meanmenu.css">
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>/assets/css/odometer.css">
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>/assets/css/swiper-bundle.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>/assets/css/nice-select.css">
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>/assets/css/icomon.css">
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>/assets/css/main.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
@media (max-width: 991px) {
.contact-info-wrapper .contact-info-box .contact-inform {
    display: flex;
    gap: 15px;
            max-width: 100%;
}
.contact-info-wrapper .contact-info-box .contact-inform h3 {
    color: var(--white);
    margin-bottom: -2px;
    font-size: 20px;
}
footer .contact-head{    text-align: center;}
.footer-widgets-wrapper .single-footer-widget {
    margin-top: 30px;
    position: relative;
    z-index: 88;
    text-align: center;
}.section-registration {
    padding: 154px 0 80px;
    background: #eee;
}.olmp .learning-box-items {
   
    margin-bottom: 30px;
}
.footer-two {
    background-color: var(--bg-3);
    position: relative;
    margin-top: 2px;
}.section-registration .section-title h2 {
    margin-bottom: 11px;
    font-size: 33px;
    font-weight: 500;
    line-height: 35px;
    letter-spacing: -1px;
}.section-title h2 {
    
    font-size: 33px !important;
    font-weight: 500;
    line-height: 35px !important;
    letter-spacing: -1px !important;
}.work-process-items {
    text-align: center; margin-bottom:30px !important;
}
}



.learning-box-items .learning-content h3 {
    font-size: 23px;
}
h1, h2, h3, h4, h5, h6 {
    font-family: "Roboto", sans-serif;
    margin: 0;
    padding: 0;
    color: var(--header);
    font-weight: 600;
    transition: all .4s ease-in-out;
}.section-title h2 {
    font-size: 34px;
    line-height: 141%;
}
#pic3 img{ height: 130px}.contact-list .content {
    width: 73%;
}.work-process-items .work-content h2 {
    margin-bottom: 4px;
    font-size: 25px;
}
.icon-box-items .content{font-family: "Manrope", sans-serif;
    font-size: 15px;
    line-height: 22px;
    font-weight: 500;}.preloader p{text-align:center}
    h1, h2, h3, h4, h5, h6 {
    font-family: "Roboto", sans-serif;
    margin: 0;
    padding: 0;
    color: var(--header);
    font-weight: 400;
    transition: all .4s ease-in-out;
}.result-count {
  
    color: #fff;
}
.section-title h2 span::before{display:none}
.work-process-items.comp .work-image img {
    width: 250px;
    height: 250px;
    border-radius: 146px;
}
</style>
<body>

<button id="back-top" class="back-to-top"> <i class="far fa-arrow-up"></i> </button>
<div class="fix-area">
  <div class="offcanvas__info">
    <div class="offcanvas__wrapper">
      <div class="offcanvas__content">
        <div class="offcanvas__top mb-5 d-flex justify-content-between align-items-center">
          <div class="offcanvas__logo"> <a href="<?php echo base_url(''); ?>"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/logo/logo.png" alt="logo-img" style="height: 70px"> </a> </div>
          <div class="offcanvas__close">
            <button> <i class="fas fa-times"></i> </button>
          </div>
        </div>
        <div class="mobile-menu fix mt-3"></div>
        <div class="social-icon d-flex align-items-center"> <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a> <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a> <a href="javascript:void(0)"><i class="fab fa-youtube"></i></a> <a href="javascript:void(0)"><i class="fab fa-linkedin-in"></i></a> </div>
        <div class="offcanvas__contact">
          <h3>Contact Us</h3>
          <ul class="contact-list">
            <li>
              <div class="icon"> <i class="far fa-phone-alt"></i> </div>
              <div class="content">
                <p>Call Us</p>
                <h4><a href="tel:+<?php echo $addressView->phone_one;?>">+91 <?php echo $addressView->phone_one;?></a></h4>
              </div>
            </li>
            <li>
              <div class="icon"> <i class="fal fa-envelope"></i> </div>
              <div class="content">
                <p>Send Email</p>
                <h4><a href="mailto:<?php echo $addressView->email_two;?>"><?php echo $addressView->email_two;?></a></h4>
              </div>
            </li>
            <li>
              <div class="icon"> <i class="fal fa-map-marker-alt"></i> </div>
              <div class="content">
                <p>Location</p>
                <h4><?php echo $addressView->address;?></h4>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="offcanvas__overlay"></div>
<header class="header-section">
  <div class="header-top-section">
    <div class="header-shape"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/header1.png" alt="img"> </div> 
    <div class="container">
      <div class="header-top-wrapper">
        <p>Zemsto competition inspires kids to do their best <a href="<?php echo base_url('contact-us'); ?>">Learn More</a></p>
        <ul class="header-contact-list">
         
          <li> <i class="far fa-phone-alt"></i> <a href="tel:91 <?php echo $addressView->phone_one;?>"><?php echo $addressView->phone_one;?></a> </li>
          <li> <i class="fa fa-map-marker"></i> <?php echo $addressView->address;?> </li>
        </ul>
      </div>
    </div>
  </div>
  <div id="header-sticky" class="header-1">
    <div class="container">
      <div class="mega-menu-wrapper">
        <div class="header-main">
          <div class="header-left"> <a href="<?php echo base_url(''); ?>" class="header-logo"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/logo/logo.png" alt="img"> </a></div>
          <div class="mean__menu-wrapper">
            <div class="main-menu">
              <nav id="mobile-menu">
                <ul>
                  <li> <a href="<?php echo base_url('about-us'); ?>"> About Us</a></li>
                  <li> <a href="<?php echo base_url('olympiads'); ?>"> Olympiads</a></li>
                  <li> <a href="<?php echo base_url('competitions'); ?>"> Competitions</a></li>
                   <li> <a href="<?php echo base_url('winners-member'); ?>"> Hall of Fame</a></li>
                     <li> <a href="<?php echo base_url('talent-winners'); ?>"> Winners</a></li>
        <!--          <li> <a href="#"> Activities</a></li>
                
                 -->
                  <li> <a href="<?php echo base_url('olympiad-result'); ?>"> Results</a></li>
                  <li> <a href="<?php echo base_url('books'); ?>"> Books Store</a></li>
                  <li> <a href="<?php echo base_url('contact-us'); ?>"> Contact Us</a></li>
                  <li> <a href="javascript:void(0)"> More <i class="fas fa-chevron-down"></i> </a>
                    <ul class="submenu">
                      <li><a href="<?php echo base_url('gallery'); ?>">Gallery</a></li>
                      <li><a href="<?php echo base_url('blogs'); ?>">Blog</a></li>
                      <li><a href="<?php echo base_url('faq'); ?>">FAQs</a></li>
                    </ul>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
          <div class="header-right d-flex justify-content-end align-items-center">
      
               <a href="<?php echo base_url('dashboard'); ?>" class="theme-btn"><i class="fas fa-user-alt" style="margin-left:0px"></i></a>
            <a href="<?php echo base_url('register'); ?>" class="theme-btn">Join Now <i class="icon-arrow-icon"></i></a>
            <div class="header__hamburger my-auto d-xl-none">
              <div class="sidebar__toggle"> <i class="fal fa-bars"></i> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="cloud-pattren1"></div>
</header>