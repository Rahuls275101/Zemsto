
<?php
use App\Models\Commanmodel;

$commanmodel = new Commanmodel();


?>


<section class="page-title-area text-white bg_cover" style="background-image: url(<?php echo base_url('assets/frontend/'); ?>/assets/images/banner2.webp);">
  <div class="container">
    <div class="page-title-inner text-center">
      <h1 class="page-title">Clients</h1>
      <div class="gd-breadcrumb"> <span class="breadcrumb-entry"><a href="index.html">Home</a></span> <span class="separator"></span> <span class="breadcrumb-entry active">Clients</span> </div>
    </div>
  </div>
</section>
	<section class="partners-section clients-section">

    <div class="container" style="padding-top:80px;">

        <div class="row">

            <!-- College & Schools -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="client-box">
                    <?php $about34= $commanmodel->get_single_query('cms_pages',array('cms_id' => 34)); ?>
                    <h3><?php echo $about34->cms_page_heading; ?></h3>
<br>
                     <?php echo $about34->cms_page_description; ?>
                </div>
            </div>

            <!-- Commercial -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="client-box">
                    <?php $about35= $commanmodel->get_single_query('cms_pages',array('cms_id' => 35)); ?>
                    <h3><?php echo $about35->cms_page_heading; ?></h3>
					<br>

                      <?php echo $about35->cms_page_description; ?>
                </div>
            </div>

            <!-- Residential -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="client-box">
                    <?php $about36= $commanmodel->get_single_query('cms_pages',array('cms_id' => 36)); ?>
                    <h3> <?php echo $about36->cms_page_heading; ?></h3>

                      <?php echo $about36->cms_page_description; ?>
                </div>
            </div>

            <!-- Hotels -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="client-box">
                    <?php $about37= $commanmodel->get_single_query('cms_pages',array('cms_id' => 37)); ?>
                    <h3><?php echo $about37->cms_page_heading; ?></h3>
<br>
                      <?php echo $about37->cms_page_description; ?>
                </div>
            </div>

        </div>

    </div>

</section>