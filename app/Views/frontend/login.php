<?php 
use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();

     $specialties = $commanmodel->all_multiple_query_order_by('specialties',array(),'id','ASC');
     
?>

<section class="section-registration">
  <div class="container">
    <div class="section-title">
      <h2>Already Registered? <span>Login</span> Here</h2>
      <p>Fill in your details, and step into the spotlight.</p>
    </div>
    
    <!-- Tabs -->
    <div class="row justify-content-center">
      <div class="col-lg-5">
        
     
        

        <div id="india" class="tab-content-custom active">
          <div class="form-card">
          
            <div class="form-body">
                <form id="user_login">
              <div class="row g-4">
                <div class="col-md-12">
                  <label class="form-label">Email *</label>
                  <input type="text" class="form-control" name="login_email" >
                     <small class="text-danger errors" id="login_email_error"></small>
                </div>
                <div class="col-md-12">
                  <label class="form-label">Password *</label>
                  <input type="text" class="form-control" name="login_password" >
                    <small class="text-danger errors" id="login_password_error"></small>
                </div>
                
                <div class="col-12">
                        <input type="hidden" required autocomplete="off" name="user_login" value="Login" />
                  <button type="submit"  class="btn-register"> Login </button>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>



<script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous">
</script>
    <script>
      var BaseUrl = '<?php echo base_url(''); ?>/';	

      $(document).ready(function(){
        login_area();

      $('#user_login').on('submit', function(event){
	 
   event.preventDefault();
   
   $.ajax({
    url: BaseUrl+'login_process',
    method:"POST",
    data:$(this).serialize(),
    dataType:"json",
    beforeSend:function(){
     
     $('#login_submit').attr('disabled', 'disabled');
    },
    
    success:function(data)
    {
      
     
     if(data.error_user)
     {
           $('#login_submit').attr('disabled', false); 
         
      if(data.login_email_error != '')
      {
       $('#login_emailerror').html(data.login_email_error);
      }
      else
      {
       $('#login_email_error').html('');
      }
      if(data.pin_error != '')
      {
       $('#login_password_error').html(data.login_password_error);
      }
      else
      {
       $('#login_password_error').html('');
      }
     
     
      
      //$('#register_form').attr('disabled', false);
     }
     if(data.failed)
     {
          
      $('#success_message_login').html(data.failed);
      $('#login_submit').attr('disabled', false); 
     }
     if(data.success)
     {
        
          showAlert(data.class,data.title,data.message);
            $('#login_submit').attr('disabled', false); 
           login_area();
       
           
            
               $('.errors').html('');
       $('#form_user_register')[0].reset();
             setTimeout(function(){ 
   
            $('#myModal').modal('hide');
     
      }, 3000);
          
      
        
     }else {
            showAlert(data.class,data.title,data.message);
     }
    
    }
   })
  });	
   




function login_area() {
    var action = 'fetch_data';

    $.ajax({
        url: BaseUrl + 'chack-sing-in',
        method: "POST",
        dataType: "JSON",
        data: { action: action },
        success: function(data) {
            $('#login_area').html(data.output);
          if (data.success) {
                // Redirect to dashboard
                window.location.href = data.url;
            }
            if (document.querySelector('#bookingButton')) {
               
                $('#bookingButton').html(data.bookingbutton);
            }

          
        }
    });
}

    



});



</script>
