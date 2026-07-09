
<?php 
use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();

    $poet  = $commanmodel->all_multiple_query_order_by('clients',array('client_status' => 'Active','type' => 'Poet'),'client_id','ASC');
   
  
?>
 <?php $about= $commanmodel->get_single_query('cms_pages',array('cms_id' => 6)); ?>
<section><img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/awards_and_achieve.jpg" style="width:100%"></section>
<div class="breadcrumbs-area mb-50">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="breadcrumbs-menu">
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#" class="active"> <?php echo $about->cms_page_heading; ?></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- breadcrumbs-area-end --> 
<!-- about-main-area-start -->
<div class="about-main-area mb-70">
  <div class="container">
    <div class="row">
   
      <div class="col-lg-12 col-md-12 col-12">
        <div class="about-content">
    <?php echo $about->cms_page_description; ?>





</div>
</div></div></div></div>
