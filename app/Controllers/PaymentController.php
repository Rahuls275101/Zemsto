<?php
namespace App\Controllers;
require_once(APPPATH . "Libraries/config.php");
require_once(APPPATH . "Libraries/razorpay-php/Razorpay.php");


namespace App\Controllers;
use App\Models\Commanmodel;
use App\Models\Travelmodel;

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
class PaymentController extends BaseController
{
    
    
    
    
    public function buyplan($id){
          $session = session();
             $commanmodel = new Commanmodel();
             
          if ($session->has('loggedin')) {
            $usersession = $session->get('loggedin'); 
            $loginId = $usersession['user_id'];
            
            $plan = $commanmodel->get_single_query('product_pricing_plans',array('id'=> 1));
         
             if($plan) {
                  $product = $commanmodel->get_single_query('product',array('product_id'=> $plan->product_id));
                   $userdata = $commanmodel->get_single_query('user_account',array('account_id'=> $usersession['user_id']));
                   
                   $plan_prce_id = $id;
                   $plan_prce_name = $plan->plan_name;
                   $plan_prce_price = $plan->price;
                   
                   
                    $plan_product_id = $product->product_id;
                    $plan_product_name = $product->product_name;
                    
                    $name = $userdata->user_name;
                     $email = $userdata->user_email;
                      $phone = $userdata->user_phone;
                    $adderess = $userdata->user_address;
                    
                    $amountInInr = (float) $plan->price;  
                      $api = new Api('rzp_test_qThjo54DWyFKHa', 'zRAGwRhizipHqH6wDpeSvNCU');
                      $db = \Config\Database::connect();
                         $receipt = 'order_' . time() . '_' . $loginId;
                         $now = date('Y-m-d H:i:s');
                         
                          $db->table('orders')->insert([
        'receipt'      => $receipt,
        'user_id'      => $loginId,
        'plan_id'      => (int)$plan->id,
        'product_id'   => (int)$product->product_id,
        'plan_name'    => (string)$plan->plan_name,
        'product_name' => (string)$product->product_name,
        'amount'       => $amountInInr,
        'currency'     => 'INR',
        'status'       => 'created',
        'created_at'   => $now,
        'updated_at'   => $now,
    ]);
    $insertId = $db->insertID();
    
  

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders


//
$orderData = [
    'receipt'         => 'order'.$insertId,
    'amount'          => $plan_prce_price * 100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];	
			   
$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount']/100;  
			     
			     $checkout = 'automatic';

if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
{
    $checkout = $_GET['checkout'];
}

$data = [
    "key"               => 'rzp_test_qThjo54DWyFKHa',
    "amount"            => $amount,
    "name"              => "HABBYAT",
    "description"       => "Tron Legacy",
    "image"             =>  base_url()."assets/frontend/images/logo.png",
    "prefill"           => [
    "name"              => $name,
    "email"             => $email,
    "contact"           => $phone,
    ],
    "notes"             => [
    "address"           => '',
    "merchant_order_id" => 'order'.$insertId,
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];


    $data['display_currency']  = 'INR';
    $data['display_amount']    = $amount;


$json = json_encode($data);
		?>
       
      
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name='razorpayform' action="<?php echo base_url()?>/razorpay-callback/<?php echo $insertId; ?>" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
</form>
<script>
// Checkout details as a json
var options = <?php echo $json?>;

/**
 * The entire list of Checkout fields is available at
 * https://docs.razorpay.com/docs/checkout-form#checkout-fields
 */
options.handler = function (response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
   // alert(response.razorpay_signature);
    document.razorpayform.submit();
};

// Boolean whether to show image inside a white frame. (default: true)
options.theme.image_padding = false;

options.modal = {
    ondismiss: function() {
        console.log("This code runs when the popup is closed");
    },
    // Boolean indicating whether pressing escape key 
    // should close the checkout form. (default: true)
    escape: true,
    // Boolean indicating whether clicking translucent blank
    // space outside checkout form should close the form. (default: false)
    backdropclose: false
};

var rzp = new Razorpay(options);


    rzp.open();
    e.preventDefault();

</script> 
<?php	     
        
                 
                 
             }
        } else {
            $loginId = 0;
        }    
             
             
         
        
    }
    
    
    

public function razorpayCallback($Inserted){
         
           $session = session();
    $commanmodel = new Commanmodel();
       $db = \Config\Database::connect();
      $current_order_id = $Inserted; 
    
           $OrderDetail = $commanmodel->get_single_query('orders',array('id'=> $current_order_id));
     
      if($OrderDetail)
      {
       
        
        
        		$success = true;

        $error = "Payment Failed";
        
        if (empty($_POST['razorpay_payment_id']) === false)
        {
           $api = new Api('rzp_test_qThjo54DWyFKHa', 'zRAGwRhizipHqH6wDpeSvNCU');
        
            try
            {
                // Please note that the razorpay order ID must
                // come from a trusted source (session here, but
                // could be database or something else)
                $attributes = array(
                    'razorpay_order_id' => $_SESSION['razorpay_order_id'],
                    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                    'razorpay_signature' => $_POST['razorpay_signature']
                );
        
                $api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        
        
        }
                
        
         if ($success === true)
{
                         		
                         	date_default_timezone_set("Asia/Kolkata");
                      
                         		  $db->table('orders')->where('id', $Inserted)->update([
        'razorpay_payment_id' => $_POST["razorpay_payment_id"],
        'razorpay_signature'  => $_POST['razorpay_signature'],
        'status'              => 'paid'
    ]);
                                        
                        
                                          
                        				
                        					
                        				if($db) {
                        				    return redirect()->to('/order-invoice/'.$Inserted)->with('msg', [
        'status' => 'success',
        'message' => '<strong>Well done!</strong> Your order has been successfully placed!',
    ]);
                                        
                        				}
			                         	
	     	
			                         	


	
           
                         		
                         		
                         		
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
             //	$this->session->set_flashdata('square', 'Your payment failed');
			
			                         //   redirect(base_url().'home');
}
        
       
      }
      else
      {
       // return redirect('404');
      }
            
      }
    
    
    public function index()
{
    $session = session();
    $commanmodel = new Commanmodel();
    helper(['form', 'url']);
    $validation =  \Config\Services::validation();
    
    $rules = [
        'name' => [
            'label'  => 'First Name',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Please enter First Name',
            ],
        ],
        'phone' => [
            'label'  => 'Phone Number',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Please enter phone number',
            ],
        ],
        'email' => [
            'label'  => 'Email',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Please enter email',
            ],
        ],
        'city' => [
            'label'  => 'City',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Please enter city',
            ],
        ],
        'state' => [
            'label'  => 'State',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Please enter state',
            ],
        ],
        'address' => [
            'label'  => 'Address',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Please enter address',
            ],
        ],
    ];
    
    if ($this->validate($rules)) {
        if ($session->has('loggedin')) {
            $usersession = $session->get('loggedin'); 
            $loginId = $usersession['user_id'];
        } else {
            $loginId = 0;
        }

     
        $bookingInformetion = $commanmodel->calculateCartSummary();
       
        
        // Capture shipping details if provided, else use the billing details or leave them blank
        $shippingName = $this->request->getVar('shipping_name') ?: $this->request->getVar('name');
        $shippingEmail = $this->request->getVar('shipping_email') ?: $this->request->getVar('email');
        $shippingPhone = $this->request->getVar('shipping_phone') ?: $this->request->getVar('phone');
        $shippingAddress = $this->request->getVar('shipping_address') ?: $this->request->getVar('address');
        $shippingCity = $this->request->getVar('shipping_city') ?: $this->request->getVar('city');
        $shippingState = $this->request->getVar('shipping_state') ?: $this->request->getVar('state');
        $shippingPin = $this->request->getVar('shipping_pin') ?: $this->request->getVar('pin_code');

            
             if ($this->request->getVar('saved_address')=='Yes') {
                 
                   $address_data = array(
            'address_user_id' => $loginId,
            'address_book_user_name' => $this->request->getVar('name'),
            'address_book_email' => $this->request->getVar('email'),
            'address_book_phone' => $this->request->getVar('phone'),
            'address_book_address' => $this->request->getVar('address'),
            'address_book_city' => $this->request->getVar('city'),
            'address_book_state' => $this->request->getVar('state'),
            'address_book_pin_no' => $this->request->getVar('pin_code'),
            'address_shipping_user_name' => $shippingName,
            'address_shipping_email' => $shippingEmail,
            'address_shipping_phone' => $shippingPhone,
            'address_shipping_address' => $shippingAddress,
            'address_shipping_city' => $shippingCity,
            'address_shipping_state' => $shippingState,
            'address_shipping_pin_no' => $shippingPin,
            );
            $AddressApplied = $commanmodel->insert_query('manage_address',$address_data);
            
            
        }


        // Preparing booking data
        $bookingData = [
           
            'order_book_user_id' => $loginId,
            'order_book_user_name' => $this->request->getVar('name'),
            'order_book_email' => $this->request->getVar('email'),
            'order_book_phone' => $this->request->getVar('phone'),
            'order_book_address' => $this->request->getVar('address'),
            'order_book_city' => $this->request->getVar('city'),
            'order_book_state' => $this->request->getVar('state'),
            'order_book_pin_no' => $this->request->getVar('pin_code'),
            'order_shipping_user_name' => $shippingName,
            'order_shipping_email' => $shippingEmail,
            'order_shipping_phone' => $shippingPhone,
            'order_shipping_address' => $shippingAddress,
            'order_shipping_city' => $shippingCity,
            'order_shipping_state' => $shippingState,
            'order_shipping_pin_no' => $shippingPin,
            'coupon_code' => $bookingInformetion['coupon'] ? $bookingInformetion['coupon']['coupon_code'] : '',
            'coupon_type' =>  $bookingInformetion['coupon'] ? $bookingInformetion['coupon']['coupon_type'] : '',
            'coupon_value' =>  $bookingInformetion['coupon'] ? $bookingInformetion['coupon']['coupon_value'] : '',
            'order_book_subtotal' => $bookingInformetion['subTotal'],
            'order_book_exclusive_gst' => $bookingInformetion['exclusiveGST'],
            'order_book_shipping' => $bookingInformetion['shipping'],
            'order_book_total' => $bookingInformetion['totalWithGST'],
            'order_book_status' => 'Pending',
            'coupon_type' => $this->request->getVar('payment_method'),
            'order_book_date' =>  date("Y-m-d H:i:s"),
        ];

        // Insert the booking data into the database
        $Inserted = $commanmodel->insert_query_get_inserid('order_book', $bookingData);
        
            foreach($bookingInformetion['products'] as $item) {
                
               
                   $bookingNumber = $this->generateBookingNumber();
                     $product_data = array(
                'booking_product_vender' => $item['vender'],
                'booking_product_order_book_id' => $Inserted,
                'booking_product_order_id' => $bookingNumber,
                'booking_product_product_id' => $item['product_id'],
                'booking_product_product_name' =>  $item['product_name'],
                 'booking_product_varian' => $item['varian'],
                'booking_product_price' => $item['price'],
                'booking_product_shipping' => $item['shipping'],
                  'discount_per_product' => $item['discount_per_product'],
                'booking_product_quantity' => $item['quantity'],
                'booking_product_tax' =>  $item['tax'],
                'booking_product_tax_rate' =>  $item['tax_rate'],
                'booking_product_sub_total' =>  $item['sub_total'],
                'booking_product_image' =>  $item['image'],
                 'booking_product_status' => 'pending',
               
                );
                
                $commanmodel->insert_query('booking_product', $product_data);
            }
            
            
         
             return  $this->payment_confirmation($Inserted,$this->request->getVar('payment_method'),$bookingData);
           
        
    }
}



 private function payment_confirmation($Inserted, $paymentMethod, $bookingData)
{
    $commanmodel = new Commanmodel();

    if ($paymentMethod == 'COD') {
      
        $verification = $commanmodel->order_verification($Inserted);
        
        return redirect()->to('/order-invoice/'.$Inserted)->with('msg', $verification);
    } else {
         $this->razorpay($Inserted, $paymentMethod, $bookingData);
    }

    // Add logic for other payment methods
   // return redirect()->to('/payment/gateway')->with('order_id', $bookingNumber);
}

    
   private function razorpay($inserid,$paymentMethod,$bookingData) {
     
      $session = session();
    $commanmodel = new Commanmodel();
     $infofomedetails = $session->infofomedetails;
     $order_book = $commanmodel->get_single_query('order_book', ['order_book_id' => $inserid]);
       if ($inserid) {
           	  $api = new Api('rzp_test_qThjo54DWyFKHa', 'zRAGwRhizipHqH6wDpeSvNCU');

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders


//
$orderData = [
    'receipt'         => 'order'.$inserid,
    'amount'          => $bookingData['order_book_total'] * 100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];	
			   
$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount']/100;  
			     
			     $checkout = 'automatic';

if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
{
    $checkout = $_GET['checkout'];
}

$data = [
    "key"               => 'rzp_test_qThjo54DWyFKHa',
    "amount"            => $amount,
    "name"              => "HABBYAT",
    "description"       => "Tron Legacy",
    "image"             =>  base_url()."assets/frontend/images/logo.png",
    "prefill"           => [
    "name"              => $order_book->order_book_user_name,
    "email"             => $order_book->order_book_email,
    "contact"           => $order_book->order_book_phone,
    ],
    "notes"             => [
    "address"           => '',
    "merchant_order_id" => 'order'.$inserid,
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];


    $data['display_currency']  = 'INR';
    $data['display_amount']    = $amount;


$json = json_encode($data);
		?>
       
      
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name='razorpayform' action="<?php echo base_url()?>/razorpay-callback/<?php echo $inserid; ?>" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
</form>
<script>
// Checkout details as a json
var options = <?php echo $json?>;

/**
 * The entire list of Checkout fields is available at
 * https://docs.razorpay.com/docs/checkout-form#checkout-fields
 */
options.handler = function (response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
   // alert(response.razorpay_signature);
    document.razorpayform.submit();
};

// Boolean whether to show image inside a white frame. (default: true)
options.theme.image_padding = false;

options.modal = {
    ondismiss: function() {
        console.log("This code runs when the popup is closed");
    },
    // Boolean indicating whether pressing escape key 
    // should close the checkout form. (default: true)
    escape: true,
    // Boolean indicating whether clicking translucent blank
    // space outside checkout form should close the form. (default: false)
    backdropclose: false
};

var rzp = new Razorpay(options);


    rzp.open();
    e.preventDefault();

</script> 
<?php	     
        }
     
 }
 
 public function razorpay_callback($Inserted){
         
           $session = session();
    $commanmodel = new Commanmodel();
      $current_order_id = $Inserted; 
      $OrderDetail = $commanmodel->order_detail_get_by_id_validate_order($current_order_id);
      if($OrderDetail)
      {
       
        
        
        		$success = true;

        $error = "Payment Failed";
        
        if (empty($_POST['razorpay_payment_id']) === false)
        {
           $api = new Api('rzp_test_qThjo54DWyFKHa', 'zRAGwRhizipHqH6wDpeSvNCU');
        
            try
            {
                // Please note that the razorpay order ID must
                // come from a trusted source (session here, but
                // could be database or something else)
                $attributes = array(
                    'razorpay_order_id' => $_SESSION['razorpay_order_id'],
                    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                    'razorpay_signature' => $_POST['razorpay_signature']
                );
        
                $api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        
        
        }
                
        
         if ($success === true)
{
                         		
                         	date_default_timezone_set("Asia/Kolkata");
                      
                         		
                                        
                            		    $cofirmrray['order_TXNID'] = $_POST["razorpay_payment_id"];
                            		    $cofirmrray['order_payment_status'] = 'success';
                            		    $cofirmrray['order_TXNDATE'] = date("Y-m-d h:i:s");
                            		    $cofirmrray['order_TXN_signature'] = $_POST['razorpay_signature'];
                            		     $cofirmrray['status'] ='Active';
                            		      $cofirmrray['status_color'] = 'success';
                            		    
                            		    
                                         $verification = $commanmodel->order_verification($Inserted);
                                        $update =   $commanmodel->update_query('order_book',$cofirmrray, ['order_book_id' => $Inserted]);
                                       
                                       
                                          
                        				
                        					
                        				if($update) {
                        				    return redirect()->to('/order-invoice/'.$Inserted)->with('msg', $verification);
                                        
                        				}
			                         	
	     	
			                         	


	
           
                         		
                         		
                         		
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
             //	$this->session->set_flashdata('square', 'Your payment failed');
			
			                         //   redirect(base_url().'home');
}
        
       
      }
      else
      {
       // return redirect('404');
      }
            
      }

    
  

private function ccavenues($Inserted, $paymentMethod, $bookingData)
{
    $commanmodel = new Commanmodel();
    
    			     			 
	function encrypt($plainText,$key)
{
	$key = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	$encryptedText = bin2hex($openMode);
	return $encryptedText;
}

/*
* @param1 : Encrypted String
* @param2 : Working key provided by CCAvenue
* @return : Plain String
*/
function decrypt($encryptedText,$key)
{
	$key = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$encryptedText = hextobin($encryptedText);
	$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	return $decryptedText;
}

function hextobin($hexString) 
 { 
	$length = strlen($hexString); 
	$binString="";   
	$count=0; 
	while($count<$length) 
	{       
	    $subString =substr($hexString,$count,2);           
	    $packedString = pack("H*",$subString); 
	    if ($count==0)
	    {
			$binString=$packedString;
	    } 
	    
	    else 
	    {
			$binString.=$packedString;
	    } 
	    
	    $count+=2; 
	} 
        return $binString; 
  }		     			 
			 
			 
		$merchant_data='';
	$working_key='2B22A1CD2B40A8555E922593845B938A';//Shared by CCAVENUES
	$access_code='AVQS82KF90CE31SQEC';//Shared by CCAVENUES
	$paydta = [];
	
	$paydta['tid'] = '';
	$paydta['merchant_id'] = '2581359';
	$paydta['order_id'] = $Inserted;
	$paydta['amount'] = $bookingData['order_book_total'];
	$paydta['currency'] = 'INR';
	$paydta['redirect_url'] = base_url('ccavenues-response/'.$Inserted);
	$paydta['cancel_url'] = base_url('ccavenues-response/'.$Inserted);;
	$paydta['language'] = 'EN';
	$paydta['billing_name'] =$bookingData['order_book_user_name'];
	$paydta['billing_address'] = $bookingData['order_book_address'];
	$paydta['billing_city'] = $bookingData['order_book_city'];
	$paydta['billing_state'] =$bookingData['order_book_state'];
	$paydta['billing_zip'] = $bookingData['order_book_pin_no'];
	$paydta['billing_country'] = 'India';
	$paydta['billing_tel'] = $bookingData['order_book_phone'];
	$paydta['billing_email'] =$bookingData['order_book_email'];
	$paydta['promo_code'] = '';
	$paydta['customer_identifier'] = '';
	
	

	
	foreach ($paydta as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}

	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.		     			 
			   ?>
			 <form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>  
<?php	    
}



 public function ccavenues_response($orderid=NULL)
      {
      $current_order_id = $orderid; 
      $OrderDetail = $this->Commanmodel->order_detail_get_by_id_validate($current_order_id);
      if($OrderDetail)
      {
       
        
   	function encrypt($plainText,$key)
{
	$key = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	$encryptedText = bin2hex($openMode);
	return $encryptedText;
}

/*
* @param1 : Encrypted String
* @param2 : Working key provided by CCAvenue
* @return : Plain String
*/
function decrypt($encryptedText,$key)
{
	$key = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$encryptedText = hextobin($encryptedText);
	$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	return $decryptedText;
}

function hextobin($hexString) 
 { 
	$length = strlen($hexString); 
	$binString="";   
	$count=0; 
	while($count<$length) 
	{       
	    $subString =substr($hexString,$count,2);           
	    $packedString = pack("H*",$subString); 
	    if ($count==0)
	    {
			$binString=$packedString;
	    } 
	    
	    else 
	    {
			$binString.=$packedString;
	    } 
	    
	    $count+=2; 
	} 
        return $binString; 
  }	     
        
$workingKey='2B22A1CD2B40A8555E922593845B938A';	
	//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$order_TXNID = '';
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
 
                for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
		
			if($i==1)	$order_TXNID=$information[1];
	}
        
        
         if ($order_status==="Success")
{
                         		
                         	date_default_timezone_set("Asia/Kolkata");
                      
                         		
                           		    $cofirmrray['order_TXNID'] = $order_TXNID;
                            		    $cofirmrray['order_payment_status'] = 'success';
                            		    $cofirmrray['order_TXNDATE'] = date("Y-m-d h:i:s");
                            	
                            		    
                            		      $verification = $commanmodel->order_verification($orderid);
                                       
                                       $update = $this->Commanmodel->update_query('order_book', $cofirmrray, array('order_book_id' =>$orderid)); 
                                       
                        				
                        					
                        				if($update) {
                        				    redirect(base_url('thank-you'));
                        				}
			                         	
	     	
			                         	


	
           
                         		
                         		
                         		
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
             	$this->session->set_flashdata('square', 'Your payment failed');
			 
			                            redirect(base_url().'home');
}
        
       
      }
      else
      {
        return redirect('404');
      }
      }

    public function order_invoice($Inserted)
    {
          $commanmodel = new Commanmodel();
         $session = session();
 $msg = $session->getFlashdata('msg');
    $order = $commanmodel->get_single_query('order_book',array('order_book_id'=> $Inserted));
       
       $data = array(
            'title' => "contact us : Rent House", 
            'keyword' => "Home : Rent House",
            'description' => "Home : Rent House",
            'search' => '',
          'order' => '',
          'msg' => $msg,
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
        return view('frontend/header',$data).view('frontend/invoice').view('frontend/footer');
    }
    
  

    public function generateBookingNumber() {
        $prefix = 'ORDER'; // You can customize the prefix
        $timestamp = time(); // Get the current timestamp
        $randomPart = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6); // Generate a random alphanumeric string
    
        $bookingNumber = $prefix . $timestamp . $randomPart;
        return $bookingNumber;
    }

}
