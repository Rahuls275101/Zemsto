<?php 
use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();

   $gallery = $commanmodel->all_multiple_query_order_by('clients',array('client_status' => 'Active'),'client_id','ASC');
   
  
?>

<section class="gallery-section inner-padding">
  <div class="container">
    <div class="section-title" style="margin-bottom: 30px;">
      <h2>Children <span>Event Photo</span> Gallery</h2>
      <p>Pick your competition, fill in your details, and step into the spotlight.</p>
    </div>
    
    <!-- Filter Buttons -->
    <div class="filter-btns">
      <button class="active" data-filter="all">All Events</button>
      <button data-filter="sports">Olympiads</button>
      <button data-filter="art">Activities</button>
      <button data-filter="dance">Winners</button>
      <button data-filter="education">Hall of Fame</button>
    </div>
    
    <!-- Gallery -->
    <div class="row gallery-container">
        <?php foreach($gallery as $galleryrow) { 
        
        $class = '';
        if($galleryrow->type == 'Olympiads') {
            $class = 'sports';
        } else  if($galleryrow->type == 'Activities')  {
            $class = 'art';
        } else  if($galleryrow->type == 'Winners')  {
            $class = 'dance';
        }  else  if($galleryrow->type == 'Hall of Fame')  {
            $class = 'education';
        }
        
        ?>
      <div class="col-lg-4 col-md-6 gallery-card <?php echo $class; ?>">
        <div class="gallery-item"> <img src="<?=  base_url('assets/client/' . $galleryrow->client_image); ?>" alt="">
          <div class="gallery-overlay">
           <!-- <h5>Sports Day</h5>-->
            <p><?= $galleryrow->name; ?></p>
          </div>
        </div>
      </div>
      <?php } ?>




  
    </div>
  </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



<script>
$('.filter-btns button').click(function(){

    $('.filter-btns button').removeClass('active');
    $(this).addClass('active');

    let value = $(this).attr('data-filter');

    if(value == 'all'){
        $('.gallery-card').show(300);
    }else{
        $('.gallery-card').hide();
        $('.' + value).show(300);
    }

});
</script>