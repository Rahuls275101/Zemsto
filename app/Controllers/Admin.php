<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPExcel_IOFactory;
use App\Models\Commanmodel;
use App\Models\Answarmodel;
use App\Models\Usermodel;
use App\Models\Franchisemodel;
use App\Models\Questionsmodel;

require_once(APPPATH . "Libraries/config.php");
require_once(APPPATH . "Libraries/razorpay-php/Razorpay.php");

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;


class Admin extends BaseController
{

 
    public function index()
    {
        $session = session();
        
           
        
        
        $commanmodel = new Commanmodel();
        return view('admin/login');
    }

    public function admin_login() {
       
        $session = session();
        $commanmodel = new Commanmodel();
        $rules = [
           
            'email'         => 'required|valid_email',
            'password'      => 'required|min_length[5]|max_length[16]',
            
        ];

        if($this->validate($rules)){

            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
           // password_hash($password, PASSWORD_DEFAULT);
            $admindetails =$commanmodel->login_valid($email);
            
            if($admindetails){
                $pass = $admindetails->password;
                $authenticatePassword = password_verify($password, $pass);
                if($authenticatePassword){
                    
                     
                    $ses_data = [
                        'id' => $admindetails->id,
                         'referral_code' => $admindetails->referral_code,
                         'name' => $admindetails->name,
                        'email' => $admindetails->email,
                         'image' => $admindetails->admin_image,
                        'name' => $admindetails->name,
                        'position' => $admindetails->position, 
                        'admin_type' => $admindetails->admin_type,
                        
                        'isLoggedIn' => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to('admin/dashboard');
                
                }else{
                    $session->setFlashdata('login_failed', 'Password is incorrect.');
                    return redirect()->to('/admin');
                }
            } else{
          

                $session->setFlashdata('login_failed', 'Invalid Email-Id and Password');
               
                return redirect()->to('/admin');
            }

           
        }else{
          

            $session->setFlashdata('login_failed', 'Invalid Email-Id and Password');
           
            return redirect()->to('/admin');
        }
       
      
       
    }


    public function dashboard()
    {
         $session = session();
       $commanmodel = new Commanmodel();
       $table_header = [
                
            ['data' => 'id'],
             ['data' => 'img'],
              ['data' => 'item'],
              ['data' => 'category'],
               ['data' => 'price'],
                ['data' => 'seller'],
                 ['data' => 'payment_type'],
                ['data' => 'shipping_address'],
                 ['data' => 'stauts'],
                  ['data' => 'action'],
          
      
           
        
        ];
        
        $data['table_column'] = json_encode($table_header);
        
         $data['vender'] = $commanmodel->get_single_query_count('admin',array()) - 1;
         $data['user'] = $commanmodel->get_single_query_count('user_account',array());
         $data['product'] = $commanmodel->get_single_query_count('product',array());
          $data['order'] = $commanmodel->get_single_query_count('order_book',array('order_book_status'=>'Success'));
         
     
        return view('admin/head').view('admin/sidebar').view('admin/index',$data).view('admin/footer');
       
    }
    
    
    
    
      public function logout() {
        $session = session();
        $session->destroy();
        
        $session->setFlashdata('login_failed', 'Successfully logged out!');
        return redirect()->to('/admin'); // Adjust the redirect URL as per your application's routes
    }


 public function setting()
    { 
        
        $session = session();
       $commanmodel = new Commanmodel();
        $data['addressView'] = $commanmodel->get_single_query('address',array('id' => 1));  
        
       return view('admin/head').view('admin/sidebar').view('admin/setting',$data).view('admin/footer');
       
    }

public function address_manage_process()
{
    $session = session();
    $commanmodel = new Commanmodel();

    // Check if page is being updated
    if ($this->request->getVar('pageUpdated')) {
        
        // Validate header logo only if a new file is uploaded
        if ($this->request->getFile('header_logo')->isValid()) {
            $validatedheaderlogo = $this->validate([
                'header_logo' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[header_logo]'
                        . '|is_image[header_logo]'
                        . '|mime_in[header_logo,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                ],
            ]);
            
            if ($validatedheaderlogo) {
                $fileheader = $this->request->getFile('header_logo');
                $header_logo = $fileheader->getRandomName();
                $fileheader->move('assets/img', $header_logo);
            } else {
                $header_logo = $this->request->getVar('edit_header_logo'); // Use existing header logo if no new file
            }
        } else {
            $header_logo = $this->request->getVar('edit_header_logo'); // Use existing header logo if no file uploaded
        }

        // Validate footer logo only if a new file is uploaded
        if ($this->request->getFile('footer_logo')->isValid()) {
            $validatedfooterlogo = $this->validate([
                'footer_logo' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[footer_logo]'
                        . '|is_image[footer_logo]'
                        . '|mime_in[footer_logo,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                ],
            ]);
            
            if ($validatedfooterlogo) {
                $filefooter = $this->request->getFile('footer_logo');
                $footer_logo = $filefooter->getRandomName();
                $filefooter->move('assets/img', $footer_logo);
            } else {
                $footer_logo = $this->request->getVar('edit_footer_logo'); // Use existing footer logo if no new file
            }
        } else {
            $footer_logo = $this->request->getVar('edit_footer_logo'); // Use existing footer logo if no file uploaded
        }

        // Prepare the data for insertion
        $post_data = [
            'header_logo' => $header_logo,
            'footer_logo' => $footer_logo,
            'web_name' => $this->request->getVar('web_name'),
            'email' => $this->request->getVar('email'),
              'email_two' => $this->request->getVar('email_two'),
            'phone_one' => $this->request->getVar('phone_one'),
            'phone_two' => $this->request->getVar('phone_two'),
           'phone_tree' => $this->request->getVar('phone_tree'),
            'address' => $this->request->getVar('address'),
            'address_tow' => $this->request->getVar('address_tow'),
            'copyright' => $this->request->getVar('copyright'),
            'facebook' => $this->request->getVar('facebook'),
            'twitter' => $this->request->getVar('twitter'),
            'linkedin' => $this->request->getVar('linkedin'),
            'instagram' => $this->request->getVar('instagram'),
            
        
        ];

        // Attempt to update the data in the database
        $inserted = $commanmodel->update_query('address', $post_data, ['id' => 1]);

        // Handle success or failure
        if ($inserted) {
            $session->setFlashdata('created', 'This Website Settings has been updated.');
            return redirect()->to(base_url('admin/setting'));
        } else {
            $session->setFlashdata('failed', 'Sorry, this address has not been updated. Please try again.');
            $data['addressView'] = $commanmodel->get_single_query('address', ['id' => 1]);
            return view('admin/head') . view('admin/sidebar') . view('admin/setting', $data) . view('admin/footer');
        }

    } else {
        // Handle if 'pageUpdated' is not set
        $session->setFlashdata('failed', 'Submit process is not working!');
        $data['addressView'] = $commanmodel->get_single_query('address', ['id' => 1]);
        return view('admin/head') . view('admin/sidebar') . view('admin/setting', $data) . view('admin/footer');
    }
}





 public function password_manage_process()
{
    $session = session();
    $commanmodel = new Commanmodel();

    if($this->request->getVar('pageUpdated')) {
        // Handle password update
        if (!empty($this->request->getVar('password'))) {
            // Password validation rules
            $validatedpassword = $this->validate([
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[6]|max_length[20]',
                ],
            ]);

            // Check if password validation is successful
            if ($validatedpassword) {
                // Hash the password
                $password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
            } else {
                $session->setFlashdata('failed', 'Please enter a password with a minimum length of 6 characters.');
                $data['addressView'] = $commanmodel->get_single_query('address', array('id' => 1));
                return view('admin/head') . view('admin/sidebar') . view('admin/setting', $data) . view('admin/footer');
            }
        }

        // Handle profile image upload
        $validatedImage = $this->validate([
            'profile_images' => [
                'label' => 'Image File',
                'rules' => 'uploaded[profile_images]'
                    . '|is_image[profile_images]'
                    . '|mime_in[profile_images,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
            ],
        ]);

        // If image is uploaded, process it, otherwise use the existing one
        if ($validatedImage) {
            $file = $this->request->getFile('profile_images');
            $profile_images = $file->getRandomName();
            $file->move('assets/vender', $profile_images);
            
            $ses_data['image'] = $profile_images; // example update

            // Set the updated session data
            $session->set($ses_data);
        } else {
            $profile_images = $this->request->getVar('edit_profile_images');
        }

        // Prepare the post data for updating the admin info
        $post_data = [
            'name' => $this->request->getVar('name'),
            'admin_address' => $this->request->getVar('admin_address'),
            'admin_image' => $profile_images,
            'email' => $this->request->getVar('login_email'),
        ];

        // If password was validated, add it to the post data
        if (!empty($password)) {
            $post_data['password'] = $password;
        }

        // Update the admin record
        $updated = $commanmodel->update_query('admin', $post_data, array('id' => $session->id));

        // Check if update was successful
        if ($updated) {
          $session->setFlashdata('created', 'Your profile has been successfully updated.');

            return redirect()->to(base_url('admin/setting'));
        } else {
            $session->setFlashdata('failed', 'Sorry, the username, email, and password have not been updated. Please try again.');
            $data['addressView'] = $commanmodel->get_single_query('address', array('id' => 1));
            return view('admin/head') . view('admin/sidebar') . view('admin/setting', $data) . view('admin/footer');
        }
    } else {
        // If pageUpdated is not set
        $session->setFlashdata('failed', 'Submit process is not working!');
        $data['addressView'] = $commanmodel->get_single_query('address', array('id' => 1));
        return view('admin/head') . view('admin/sidebar') . view('admin/setting', $data) . view('admin/footer');
    }
}


     public function home_banner()
    { 
        $session = session();
        $commanmodel = new Commanmodel();
        $data['bannerView'] = $commanmodel->get_multiple_query_order_by('home_banner','banner_id','DESC');    

        
        return view('admin/head').view('admin/sidebar').view('admin/banner',$data).view('admin/footer');
     
    }
    
    
    
    
    
    
     public function home_banner_process()
    {
        $session = session();
        $commanmodel = new Commanmodel();
        $data['bannerView'] = $commanmodel->get_multiple_query_order_by('home_banner','banner_id','DESC');
        if($this->request->getVar('upload_banner'))
        {
            if($_FILES['home_banner']['name']!=""){
          
                
                $file = $this->request->getFile('home_banner');

        // Generate a new secure name
        $home_banner = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/images', $home_banner);
            }
            else{
            $session->setFlashdata('failed', 'Please choose banner image!');    
          
            
            return view('admin/head').view('admin/sidebar').view('admin/banner',$data).view('admin/footer');
            }
			 
        $post_data = array(
        'banner_image' => $home_banner,
		'banner_first_title' => $this->request->getVar('first_title'),
			'banner_first_second' => $this->request->getVar('banner_first_second'),
	'banner_date' => $this->request->getVar('date'),
        'redirect_url' => $this->request->getVar('redirect_url')
	
        );
        $inserted = $commanmodel->insert_query('home_banner',$post_data); 
                   if($inserted)
                   {
                    $session->setFlashdata('created', 'This Home Banner has been uploaded successfully.');
                     return redirect()->to('/admin/home_banner');
                   }
                   else
                   {
            $session->setFlashdata('failed', 'Sorry, This Home Banner has not been uploaded.');      
   
        return view('admin/head').view('admin/sidebar').view('admin/banner',$data).view('admin/footer');
                   }


            }
        else
        {
        $session->setFlashdata('failed', 'Submit process is not working!');      
      return view('admin/head').view('admin/sidebar').view('admin/banner',$data).view('admin/footer');
        }  

       
    }


    public function edit_home_banner($banner_id)
    {
        $session = session();
        $commanmodel = new Commanmodel();
        $data['bannerView'] = $commanmodel->get_single_query('home_banner',array('banner_id' => $banner_id));    
    
        return view('admin/head').view('admin/sidebar').view('admin/edit-home-banner',$data).view('admin/footer');
       
    }

    public function edit_home_banner_process($banner_id)
    {
        $session = session();
        $commanmodel = new Commanmodel();
        $data['bannerView'] = $commanmodel->get_single_query('home_banner',array('banner_id' => $banner_id)); 
        if($this->request->getVar('EditBanner'))
        {
            if($_FILES['banner_image']['name']!=""){
                
                $file = $this->request->getFile('banner_image');

        // Generate a new secure name
        $home_banner = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/images', $home_banner);
            }
            else{
              $home_banner = $this->request->getVar('banner_image_old');
            }
        if($this->request->getVar('banner_status')=='Active')
        {
          $banner_status_color = 'success';
        }
        if($this->request->getVar('banner_status')=='Inactive')
        {
          $banner_status_color = 'danger';
        }
        $post_data = array(
     'banner_image' => $home_banner,
		'banner_first_title' => $this->request->getVar('first_title'),
		'banner_first_second' => $this->request->getVar('banner_first_second'),
	'banner_date' => $this->request->getVar('date'),
        'redirect_url' => $this->request->getVar('redirect_url'),
        'banner_status' => $this->request->getVar('banner_status'),
        'banner_status_color' => $banner_status_color 
        );
        $updated = $commanmodel->update_query('home_banner',$post_data,array('banner_id' => $banner_id)); 
        if($updated)
        {
        $session->setFlashdata('created', 'This banner has been updated.');
         return redirect()->to('/admin/home_banner');
        }
        else
        {
        $session->setFlashdata('failed', 'Sorry, This banner has not been uploaded.');     
      return view('admin/head').view('admin/sidebar').view('admin/edit-home-banner',$data).view('admin/footer');
        }
            }
        else
        {
        $session->setFlashdata('failed', 'Submit process is not working!');  
        
     return view('admin/head').view('admin/sidebar').view('admin/edit-home-banner',$data).view('admin/footer');
        }  
       
    }




    public function delete_home_banner($banner_id)
    {
        $session = session();
        $commanmodel = new Commanmodel();
     $deleteClient = $commanmodel->delete_query('home_banner',array('banner_id' =>$banner_id));
     if($deleteClient)
     {
      $session->setFlashdata('created', 'This Home Banner is delete.');
       return redirect()->to('/admin/home_banner');
     }
     else
     {
      $session->setFlashdata('failed', 'This Home Banner is not delete!');
       return redirect()->to('/admin/home_banner'); 
     }
    
    }





public function cms_pages()
    {
       
             $commanmodel = new Commanmodel();
        $data['cmsView'] = $commanmodel->get_multiple_query_order_by('cms_pages','cms_id','ASC');    
       
        
          return view('admin/head').view('admin/sidebar').view('admin/cms-pages',$data).view('admin/footer');
       
    }


    public function edit_cms($cms_id)
    {
          $commanmodel = new Commanmodel();
        $data['cmsView'] = $commanmodel->get_single_query('cms_pages',array('cms_id' => $cms_id));    
        
        return view('admin/head').view('admin/sidebar').view('admin/edit-cms',$data).view('admin/footer');
       
    }




 public function edit_cms_process($cms_id)
    {
        
             $session = session();
        $commanmodel = new Commanmodel();
         if($this->request->getVar('pageUpdated'))
        {
              if($_FILES['product_image']['name']!=""){
         
                
                       $file = $this->request->getFile('product_image');

        // Generate a new secure name
        $image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/images', $image);
            }
            else{
                  $image=$this->request->getVar('product_image_old');
            }
            
            
    $post_data = array(
        'cms_image' =>  $image,
    'cms_page_heading' =>$this->request->getVar('cms_page_heading'),
    'cms_page_small_description' =>$this->request->getVar('cms_page_small_description'),
    'cms_page_description' =>$this->request->getVar('cms_page_description')
    );
                   $inserted = $commanmodel->update_query('cms_pages',$post_data,array('cms_id' => $cms_id)); 
                   if($inserted)
                   {
                     $session->setFlashdata('created', 'This Page contant has been updated.');
           
                    return redirect()->to('admin/cms_pages');
                   }
                   else
                   {
             $session->setFlashdata('failed', 'Sorry, This blog has not been updated. Please try again?');    
        $data['cmsView'] = $commanmodel->get_single_query('cms_pages',array('cms_id' => $cms_id));    
      return view('admin/head').view('admin/sidebar').view('admin/edit-cms',$data).view('admin/footer');
                   }


                
        }
        else
        {
             $session->setFlashdata('failed', 'Submit process is not working!');    
        $data['cmsView'] = $commanmodel->get_single_query('cms_pages',array('cms_id' => $cms_id));    
       return view('admin/head').view('admin/sidebar').view('admin/edit-cms',$data).view('admin/footer');
        }



       
    }
    


    public function meta()
    { 
        $commanmodel = new Commanmodel();
        $session = session();
       if(session()->get('admin_type')=='Supar Admin') {
           
             $data['table_name'] = '';
             
             
         
    
            $table_header = [
                
            ['data' => 'id'],
             ['data' => 'page'],
            ['data' => 'images'],
            ['data' => 'meta'],
           
            ['data' => 'action'],
        
        ];
        
        $data['table_column'] = json_encode($table_header);
       
       return view('admin/head').view('admin/sidebar').view('admin/meta',$data).view('admin/footer');
       } else {
            
            return redirect()->back()->withInput();
       }
       
    }
    
    
        public function meta_list()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input


// Define filters based on your requirements
$filters = [];

// Add search filter if a search term is provided
// if (!empty($searchname)) {
// $filters[] = [
//     'column' => 'product_title',
//     'value' => $searchname,
//     'type' => 'like',
// ];
// }






// if (session()->get('admin_type')=='Admin') { 
//     $filters[] = [
//     'column' => 'product_create_by',
//     'value' => session()->get('id'),
//     'type' => 'where',
// ];
// }

// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'meta_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('meta', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {

$name = $alldata_view->meta_title;

$images = '<img class="cat-thumb" src="'.base_url().'/assets/meta/'.$alldata_view->meta_image.'" >'; 



$action = '<div class="btn-group">
			<button type="button"
				class="btn btn-outline-success"></button>
			<button type="button"
				class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
				data-bs-toggle="dropdown" aria-haspopup="true"
				aria-expanded="false" data-display="static">
				<span class="sr-only">Info</span>
			</button>
			<div class="dropdown-menu">
				<a class="dropdown-item editRecordmeta" href="javascript:void(0);"  data-meta_id="'.$alldata_view->meta_id.'" data-meta_title="'.$alldata_view->meta_title.'"   data-meta_keyword="'.$alldata_view->meta_keyword.'" data-meta_description="'.$alldata_view->meta_description.'" data-meta_image="'.$alldata_view->meta_image.'" >Edit</a>
				
			</div>
		</div>';


      

$data[] = [
    "id" => $sn,
     "page" => $alldata_view->meta_page,
    "images" => $images,
    "meta" => $name,
    
   
    "action" => $action 
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}
    
    
    
        function meta_save(){
           $session = session();
      
             $commanmodel = new Commanmodel();
         $status = $this->request->getVar('meta_status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }
         
        
         
         
               $validated = $this->validate([
            'meta_image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[meta_image]'
                    . '|is_image[meta_image]'
                    . '|mime_in[meta_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    
            ],
        ]);
 
       
  
        if ($validated) {
             $file = $this->request->getFile('meta_image');

        // Generate a new secure name
        $meta_image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/meta', $meta_image);
        } else {
             $meta_image = '';
        }
         
         
      
         

        $title = strip_tags($this->request->getVar('meta_name'));
        $titleURL = strtolower(url_title($title));
        
   

        $data = array( 
        
        'meta_name' => $this->request->getVar('meta_name'), 
         
        'meta_status' => $this->request->getVar('meta_status'), 
        'meta_status_color' => $status_color,
        'meta_image' => $meta_image,
        'url_slug' => $titleURL,
       
            );
        $Inserted=$commanmodel->insert_query('meta',$data);
        echo json_encode($Inserted);
     
    }
        function meta_update(){
             $session = session();
       
             helper(['form', 'url']);
               $commanmodel = new Commanmodel();
        
         
         
              $validated = $this->validate([
            'edit_meta_image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[edit_meta_image]'
                    . '|is_image[edit_meta_image]'
                    . '|mime_in[edit_meta_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                   
            ],
        ]);
 
       
  
        if ($validated) {
             $file = $this->request->getFile('edit_meta_image');

        // Generate a new secure name
        $meta_image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/meta', $meta_image);
        } else {
             $meta_image = $this->request->getVar('edit_meta_image_old');
        }

        
        $data = array(  
             
       
        'meta_title' => $this->request->getVar('meta_title'), 
        'meta_keyword' => $this->request->getVar('meta_keyword'), 
        'meta_description' => $this->request->getVar('meta_description'), 
        

        'meta_image' => $meta_image,
    
       
        );
        $where = array(             
        'meta_id' => $this->request->getVar('edit_meta_id')
            );
        $updated=$commanmodel->update_query('meta',$data,$where);
        echo json_encode($updated);
     
    }
    
    


// Modified user() function - for School List
public function user()
{
    $session = session();
    if(session()->get('admin_type')=='Supar Admin' or session()->get('admin_type')=='Promoter' or session()->get('admin_type')=='Franchise') {
        
        $data['table_name'] = 'admin';

        $table_header = [
            ['data' => 'id'],
            ['data' => 'school_name'],
            ['data' => 'email'],
            ['data' => 'phone'],
            ['data' => 'city'],
            ['data' => 'status'],
            ['data' => 'action'],
        ];
        
        $data['table_column'] = json_encode($table_header);
     
        return view('admin/head')
            . view('admin/sidebar')
            . view('admin/user', $data)
            . view('admin/footer');
    } else {
        $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
        return redirect()->back()->withInput();
    }
}

// Modified em_userlist() - for Schools List
public function em_userlist()
{
    $session = session();
    $commanmodel = new Commanmodel();

    $draw = $_POST['draw'];
    $start = $_POST['start'];
    $length = $_POST['length'];
    $searchname = $_POST['searchname'];
    $id = $_POST['id']; 
    $status = $_POST['status']; 
    
    $filters = [];

    // Search by school name or email
    if (!empty($searchname)) {
        $filters[] = [
            'column' => 'school_name',
            'value' => $searchname,
            'type' => 'like',
        ];
    }

    // Filter by city
    if (!empty($_POST['city'])) {
        $filters[] = [
            'column' => 'city',
            'value' => $_POST['city'],
            'type' => 'like',
        ];
    }

    // Filter by status
    if (!empty($status)) {
        $filters[] = [
            'column' => 'status',
            'value' => $status,
            'type' => 'like',
        ];
    }

    // Only show schools (admin_type = 'School')
    $filters[] = [
        'column' => 'admin_type',
        'value' => 'School',
        'type' => 'where',
    ];

    // Exclude super admin
    $filters[] = [
        'column' => 'id !=',
        'value' => 1,
        'type' => 'where',
    ];

    if (!empty($_POST['order'])) {
        $order = [
            'column' => 'id',
            'order' => 'DESC',
        ];
    }

    $result = $commanmodel->getDataFromTable('admin', $filters, $order, $length, $start);

    $alldata = $result['filteredRecords'];
    $data = [];
    $sn = $start + 1;

    foreach ($alldata as $school) {
        $school_info = 'School: ' . $school->school_name . '<br>Code: ' . $school->school_code . '<br>Principal: ' . $school->principal_name;
        $email = $school->email;
        $phone = $school->phone;
        $city = $school->city;
        
        // Status badge
        $status_badge = '<span class="badge badge-' . ($school->status == 'Active' ? 'success' : 'danger') . '">' . $school->status . '</span>';
        
        $action = '<div class="btn-group">
            <button type="button" class="btn btn-outline-' . ($school->status == 'Active' ? 'success' : 'danger') . '">' . $status_badge . '</button>
            <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                <span class="sr-only">Info</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="' . base_url('admin/edit-user/' . $school->id) . '">Edit</a>
                <a class="dropdown-item" href="' . base_url('admin/user-delete/' . $school->id) . '" onclick="return confirm(\'Are you sure you want to delete this school?\')">Delete</a>
            </div>
        </div>';

        $data[] = [
            "id" => $sn,
            "school_name" => $school_info,
            "email" => $email,
            "phone" => $phone,
            "city" => $city,
            "status" => $status_badge,
            "action" => $action
        ];

        $sn++;
    }

    $response = [
        "draw" => intval($draw),
        "recordsTotal" => $result['filteredRecordCount'],
        "recordsFiltered" => $result['totalRecords'],
        "data" => $data
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}

// Modified create_user() - for School Registration
public function create_user()
{
    $session = session();
    if(session()->get('admin_type')=='Supar Admin' or session()->get('user')=='Yes') {
        helper(['form', 'url']);
        
        $data = [
            'cities' => ['Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'Hyderabad', 'Kolkata', 'Pune', 'Ahmedabad'],
            'states' => ['Maharashtra', 'Delhi', 'Karnataka', 'Tamil Nadu', 'Telangana', 'West Bengal', 'Gujarat']
        ];
        
        return view('admin/head')
            . view('admin/sidebar')
            . view('admin/create_user', $data)
            . view('admin/footer');
    } else {
        $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
        return redirect()->back()->withInput();
    }
}

// Modified create_user_process() - for School Registration
public function create_user_process()
{
    $session = session();
    if(session()->get('admin_type')=='Supar Admin' or session()->get('user')=='Yes') {
        $commanmodel = new Commanmodel();
        helper(['form', 'url']);
        $validation = \Config\Services::validation();
        
        $rules = [
            'school_name' => [
                'label' => 'School Name',
                'rules' => 'required',
                'errors' => ['required' => 'Please enter school name'],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[admin.email]',
                'errors' => [
                    'required' => 'Please enter email',
                    'valid_email' => 'Please enter valid email',
                    'is_unique' => 'This email already registered'
                ],
            ],
            'phone' => [
                'label' => 'Phone',
                'rules' => 'required|numeric|min_length[10]|max_length[15]',
                'errors' => [
                    'required' => 'Please enter phone number',
                    'numeric' => 'Please enter valid phone number',
                    'min_length' => 'Phone number must be at least 10 digits',
                    'max_length' => 'Phone number must not exceed 15 digits'
                ],
            ],
            'city' => [
                'label' => 'City',
                'rules' => 'required',
                'errors' => ['required' => 'Please select city'],
            ],
            'state' => [
                'label' => 'State',
                'rules' => 'required',
                'errors' => ['required' => 'Please select state'],
            ],
            'principal_name' => [
                'label' => 'Principal Name',
                'rules' => 'required',
                'errors' => ['required' => 'Please enter principal name'],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Please enter password',
                    'min_length' => 'Password must be at least 6 characters'
                ],
            ],
            'confirm_password' => [
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Please confirm password',
                    'matches' => 'Password does not match'
                ],
            ],
        ];

        if($this->validate($rules)) {
            $status = $this->request->getVar('status');
            $status_color = ($status == 'Active') ? 'success' : 'danger';
            
            // Generate unique school code
            $school_code = strtoupper(substr($this->request->getVar('school_name'), 0, 3) . rand(1000, 9999));
            
            $postData = array(
                'school_name' => $this->request->getVar('school_name'),
                'school_code' => $school_code,
                'email' => $this->request->getVar('email'),
                'phone' => $this->request->getVar('phone'),
                'address' => $this->request->getVar('address'),
                'city' => $this->request->getVar('city'),
                'state' => $this->request->getVar('state'),
                'pincode' => $this->request->getVar('pincode'),
                'affiliation' => $this->request->getVar('affiliation'),
                'established_year' => $this->request->getVar('established_year'),
                'principal_name' => $this->request->getVar('principal_name'),
                'principal_phone' => $this->request->getVar('principal_phone'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'password_show' => $this->request->getVar('password'),
                'status' => $status,
                'status_color' => $status_color,
                'admin_type' => 'School',
                'name' => $this->request->getVar('school_name'), // For backward compatibility
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            // Handle logo upload
            if($file = $this->request->getFile('logo')) {
                if($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move('uploads/schools/', $newName);
                    $postData['logo'] = $newName;
                }
            }
            
            $insertid = $commanmodel->insert_query_get_inserid('admin', $postData);
            
            if($insertid) {
                $session->setFlashdata('created', 'School registered successfully! School Code: ' . $school_code);
                return redirect()->to('/admin/user');
            } else {
                $session->setFlashdata('failed', 'Sorry, school registration failed. Please try again.');
                return redirect()->to('/admin/user');
            }
        } else {
            $data["validation"] = $validation->getErrors();
            $data['cities'] = ['Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'Hyderabad', 'Kolkata', 'Pune', 'Ahmedabad'];
            $data['states'] = ['Maharashtra', 'Delhi', 'Karnataka', 'Tamil Nadu', 'Telangana', 'West Bengal', 'Gujarat'];
            
            return view('admin/head')
                . view('admin/sidebar')
                . view('admin/create_user', $data)
                . view('admin/footer');
        }
    } else {
        $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
        return redirect()->back()->withInput();
    }
}

// Modified edit_user() - for Editing School
public function edit_user($id)
{
    $session = session();
    if(session()->get('admin_type')=='Supar Admin' or session()->get('admin_type')=='Promoter' or session()->get('admin_type')=='Franchise') {
        $commanmodel = new Commanmodel();
        $validation = \Config\Services::validation();

        $school = $commanmodel->get_single_query('admin', ['id' => $id]);

        $data = [
            'admin' => $school,
            'id' => $id,
            'cities' => ['Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'Hyderabad', 'Kolkata', 'Pune', 'Ahmedabad'],
            'states' => ['Maharashtra', 'Delhi', 'Karnataka', 'Tamil Nadu', 'Telangana', 'West Bengal', 'Gujarat'],
            'validation' => [] // Initialize as empty array
        ];

        helper(['form', 'url']);

        return view('admin/head')
            . view('admin/sidebar')
            . view('admin/edit_user', $data)
            . view('admin/footer');
    } else {
        $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page.');
        return redirect()->to('/admin/dashboard');
    }
}

// Modified edit_user_process() - for Updating School
public function edit_user_process($id)
{
    $session = session();
    if(session()->get('admin_type')=='Supar Admin' or session()->get('admin_type')=='Promoter' or session()->get('admin_type')=='Franchise') {
        $commanmodel = new Commanmodel();
        helper(['form', 'url']);
        $validation = \Config\Services::validation();
        
        $school = $commanmodel->get_single_query('admin', ['id' => $id]);
        
        $rules = [
            'school_name' => [
                'label' => 'School Name',
                'rules' => 'required',
                'errors' => ['required' => 'Please enter school name'],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Please enter email',
                    'valid_email' => 'Please enter valid email'
                ],
            ],
            'phone' => [
                'label' => 'Phone',
                'rules' => 'required|numeric|min_length[10]|max_length[15]',
                'errors' => [
                    'required' => 'Please enter phone number',
                    'numeric' => 'Please enter valid phone number',
                    'min_length' => 'Phone number must be at least 10 digits',
                    'max_length' => 'Phone number must not exceed 15 digits'
                ],
            ],
            'city' => [
                'label' => 'City',
                'rules' => 'required',
                'errors' => ['required' => 'Please select city'],
            ],
            'state' => [
                'label' => 'State',
                'rules' => 'required',
                'errors' => ['required' => 'Please select state'],
            ],
            'principal_name' => [
                'label' => 'Principal Name',
                'rules' => 'required',
                'errors' => ['required' => 'Please enter principal name'],
            ],
        ];

        if($this->validate($rules)) {
            $status = $this->request->getVar('status');
            $status_color = ($status == 'Active') ? 'success' : 'danger';
            
            $postData = array(
                'school_name' => $this->request->getVar('school_name'),
                'email' => $this->request->getVar('email'),
                'phone' => $this->request->getVar('phone'),
                'address' => $this->request->getVar('address'),
                'city' => $this->request->getVar('city'),
                'state' => $this->request->getVar('state'),
                'pincode' => $this->request->getVar('pincode'),
                'affiliation' => $this->request->getVar('affiliation'),
                'established_year' => $this->request->getVar('established_year'),
                'principal_name' => $this->request->getVar('principal_name'),
                'principal_phone' => $this->request->getVar('principal_phone'),
                'status' => $status,
                'status_color' => $status_color,
                'name' => $this->request->getVar('school_name'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            // Update password if provided
            if($this->request->getVar('password') && !empty($this->request->getVar('password'))) {
                $postData['password'] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
                $postData['password_show'] = $this->request->getVar('password');
            }
            
            // Handle logo upload
            if($file = $this->request->getFile('logo')) {
                if($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move('uploads/schools/', $newName);
                    $postData['logo'] = $newName;
                }
            }
            
            $where_data = ['id' => $id];
            $update = $commanmodel->update_query('admin', $postData, $where_data);
            
            if($update) {
                $session->setFlashdata('created', 'School updated successfully!');
                return redirect()->to('/admin/user');
            } else {
                $session->setFlashdata('failed', 'Sorry, school update failed. Please try again.');
                return redirect()->to('/admin/user');
            }
        } else {
            $data["validation"] = $this->validator;
            $data['admin'] = $school;
            $data['id'] = $id;
            $data['cities'] = ['Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'Hyderabad', 'Kolkata', 'Pune', 'Ahmedabad'];
            $data['states'] = ['Maharashtra', 'Delhi', 'Karnataka', 'Tamil Nadu', 'Telangana', 'West Bengal', 'Gujarat'];
            
            return view('admin/head')
                . view('admin/sidebar')
                . view('admin/edit_user', $data)
                . view('admin/footer');
        }
    } else {
        $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
        return redirect()->back()->withInput();
    }
}

// Modified user_delete() - for Deleting School
public function user_delete($id)
{
    $session = session();
    if(session()->get('admin_type')=='Supar Admin' or session()->get('admin_type')=='Admin') {
        $commanmodel = new Commanmodel();

        $school = $commanmodel->get_single_query('admin', ['id' => $id]);
        
        if($school) {
            // Delete school logo if exists
            if($school->logo && file_exists('uploads/schools/' . $school->logo)) {
                unlink('uploads/schools/' . $school->logo);
            }
            
            $delete = $commanmodel->delete_query('admin', ['id' => $id]);
            if($delete) {
                $session->setFlashdata('created', 'School deleted successfully!');
            } else {
                $session->setFlashdata('failed', 'Failed to delete school.');
            }
        } else {
            $session->setFlashdata('failed', 'School not found.');
        }

        return redirect()->to('/admin/user');
    } else {
        $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
        return redirect()->to('/admin/dashboard');
    }
}

  
  private function getUniqueFileName($fileName)
{
    $filePath = 'assets/images/' . $fileName;
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $baseName = pathinfo($fileName, PATHINFO_FILENAME);
    $counter = 1;

    // If file with the same name exists, append a counter to the file name
    while (file_exists($filePath)) {
        $filePath = 'assets/images/' . $baseName . '-' . $counter . '.' . $ext;
        $counter++;
    }

    return basename($filePath);  // Return the unique file name
}
   public function our_blogs(){
         $commanmodel = new Commanmodel();
        $data['blogView'] = $commanmodel->get_multiple_query_order_by('blogs','blog_id','DESC');    
    
        
        return view('admin/head').view('admin/sidebar').view('admin/our-blogs', $data).view('admin/footer');
       
    }


    public function create_blog()
    {
          
         $session = session();
         return view('admin/head').view('admin/sidebar').view('admin/create-blog').view('admin/footer');
       
    }

 public function create_blog_process()
    {
        
        $commanmodel = new Commanmodel();
        $session = session();
        helper(['form', 'url']);
        $validation =  \Config\Services::validation();
        
        
        if($this->request->getVar('CreateNewBlog'))
        {
      
        
                $rules = [
            'blog_name' => [
                'label'  => 'Blog name',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please blog name',
                ],
            ],
            'blog_status' => [
                'label'  => 'Blog small description',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please select status',
                    
                ],
            ],
            
           'blog_small_description' => [
                'label'  => 'Blog status',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please enter small descriptio',
                    
                ],
            ],
        ];
        
                if($this->validate($rules) == FALSE)
                {    
      
            $data["validation"] = $validation->getErrors();
             return view('admin/head').view('admin/sidebar').view('admin/create-blog', $data).view('admin/footer');
                }
                else
                {


    $status = $this->request->getVar('blog_status');
    if($status=='Active')
    {
      $status_color = 'success';
    }
    if($status=='Inactive')
    {
      $status_color = 'danger';
    }
            if($_FILES['blog_image']['name']!=""){
                
                
                $file = $this->request->getFile('blog_image');

        // Generate a new secure name
        $blog_image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/blog', $blog_image);
                
          
            }
            else{
           $blog_image = '';
            }












        $title = strip_tags($this->request->getVar('blog_name'));
        $titleURL = strtolower(url_title($title));
   


    $post_data = array(
    'blog_name' => $this->request->getVar('blog_name'),
    'url_slug' => $titleURL,
    
    'blog_status' => $this->request->getVar('blog_status'),

    'blog_status_color' => $status_color,
    'blog_image' => $blog_image,

    'blog_small_description' => $this->request->getVar('blog_small_description'),
    'blog_description' => $this->request->getVar('blog_description'),
    'meta_title' => $this->request->getVar('meta_title'),
    'meta_keyword' => $this->request->getVar('meta_keyword'),
    'meta_description' => $this->request->getVar('meta_description')
    );
                   $inserted = $commanmodel->insert_query('blogs',$post_data); 
                   if($inserted)
                   {
                 
                    $session->setFlashdata('created', 'This blog has been created!');
                
                    return redirect()->to('/admin/blog');
                    
                   }
                   else
                   {
         
            
             $session->setFlashdata('failed', 'Sorry, This course has not been created. Please try again?');  
        return view('admin/head').view('admin/sidebar').view('admin/create-blog', $data).view('admin/footer');
                   }


                }
        }
        else
        {
   
             $session->setFlashdata('failed', 'Submit process is not working!'); 
        return view('admin/head').view('admin/sidebar').view('admin/create-blog', $data).view('admin/footer');
        }



       
    }
    
    public function delete_our_blog($blog_id)
    {
         $session = session();
         $commanmodel = new Commanmodel();
     $deleteBlog = $commanmodel->delete_query('blogs',array('blog_id' =>$blog_id));
     if($deleteBlog)
     {
     
      $session->setFlashdata('created', 'This blog is delete.');
       return redirect()->to('/admin/blog');
     }
     else
     {
          $session->setFlashdata('failed', 'This is not delete!');

       return redirect()->to('/admin/blog');
     }
    
    }


    public function edit_our_blog($blog_id)
    {
      $commanmodel = new Commanmodel();
        $data['blogView'] = $commanmodel->get_single_query('blogs',array('blog_id' => $blog_id));    
 
        
         return view('admin/head').view('admin/sidebar').view('admin/edit-blog', $data).view('admin/footer');
       
    }


 public function edit_blog_process($blog_id)
    {
       $commanmodel = new Commanmodel();
       $session = session();
  helper(['form', 'url']);
        $validation =  \Config\Services::validation();
        if($this->request->getVar('CreateEditBlog'))
        {
         $rules = [
            'blog_name' => [
                'label'  => 'Blog name',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please blog name',
                ],
            ],
            'blog_status' => [
                'label'  => 'Blog small description',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please select status',
                    
                ],
            ],
            
           'blog_small_description' => [
                'label'  => 'Blog status',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please enter small descriptio',
                    
                ],
            ],
        ];
        
                if($this->validate($rules) == FALSE)
                {   
                    $data["validation"] = $validation->getErrors();
        $data['blogView'] = $commanmodel->get_single_query('blogs',array('blog_id' => $blog_id));    
        
        return view('admin/head').view('admin/sidebar').view('admin/edit-blog', $data).view('admin/footer');
                }
                else
                {


    $status = $this->request->getVar('blog_status');
    if($status=='Active')
    {
      $status_color = 'success';
    }
    if($status=='Inactive')
    {
      $status_color = 'danger';
    }
            if($_FILES['blog_image']['name']!=""){
                    $file = $this->request->getFile('blog_image');

        // Generate a new secure name
        $blog_image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/blog', $blog_image);
            }
            else{
                  $blog_image= $this->request->getVar('blog_image_old');
            }


 $title = strip_tags($this->request->getVar('blog_name'));
        $titleURL = strtolower(url_title($title));
 
    $post_data = array(
    'blog_name' => $this->request->getVar('blog_name'),
    'blog_status' => $this->request->getVar('blog_status'),
  'url_slug' => $titleURL,
  
    'blog_status_color' => $status_color,
    'blog_image' => $blog_image,
  
    'blog_small_description' => $this->request->getVar('blog_small_description'),
    'blog_description' => $this->request->getVar('blog_description'),
    'meta_title' => $this->request->getVar('meta_title'),
    'meta_keyword' => $this->request->getVar('meta_keyword'),
    'meta_description' => $this->request->getVar('meta_description')
    );
                   $inserted = $commanmodel->update_query('blogs',$post_data,array('blog_id' => $blog_id)); 
                   if($inserted)
                   {
                    $session->setFlashdata('created', 'This blog has been updated.');
               
                    
                     return redirect()->to('/admin/blog');
                   }
                   else
                   {
            $session->setFlashdata('failed', 'Sorry, This blog has not been updated. Please try again?');    
        $data['blogView'] = $commanmodel->get_single_query('blogs',array('blog_id' => $blog_id));    
    
     return view('admin/head').view('admin/sidebar').view('admin/edit-blog', $data).view('admin/footer');
                   }


                }
        }
        else
        {
            $session->setFlashdata('failed', 'Submit process is not working!');    
        $data['blogView'] = $commanmodel->get_single_query('blogs',array('blog_id' => $blog_id));    
       
        return view('admin/head').view('admin/sidebar').view('admin/edit-blog', $data).view('admin/footer');
        }



      
    }
         public function team()
    {
        $session = session();
        $commanmodel = new Commanmodel();
      $category = $commanmodel->all_multiple_query_order_by('category',array('parent_id'=> '0','subparent_id'=> '0'),'menu_order','ASC');
         $team= $commanmodel->all_multiple_query_order_by('team',array(),'team_id','ASC');
        
          $data = array(
       'team' => $team,
        'category' => $category,
      
		);

        
        
         return view('admin/head',$data).view('admin/sidebar').view('admin/team').view('admin/footer');
    }
       public function team_save()
    {
        $session = session();
        $commanmodel = new Commanmodel();
      $category = $commanmodel->all_multiple_query_order_by('category',array('parent_id'=> '0','subparent_id'=> '0'),'menu_order','ASC');
        
        
              $status = $this->request->getVar('status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }
         
           $file = $this->request->getFile('logo');

        // Generate a new secure name
        $logo = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/team', $logo);
        
          $postData = array(
                
                'team_name' => $this->request->getVar('name'),
                'team_logo' => $logo,
               'overview' => $this->request->getVar('overview'),
                'designation' => $this->request->getVar('designation'),
                'team_status' => $status, 
                'team_status_color' => $status_color
                );
             $insertid = $commanmodel->insert_query_get_inserid('team',$postData);
        
        
            $session->setFlashdata('created', 'This team has been Updated successfully!');
                
        return redirect()->to('/admin/team');
    }
    
         public function team_edit($id)
    {
        $session = session();
        $commanmodel = new Commanmodel();
      $category = $commanmodel->all_multiple_query_order_by('category',array('parent_id'=> '0','subparent_id'=> '0'),'menu_order','ASC');
         $team= $commanmodel->get_single_query('team',array('team_id' =>$id));
        
          $data = array(
              'id' => $id,
       'team' => $team,
        'category' => $category,
      
		);

        
        
         return view('admin/head',$data).view('admin/sidebar').view('admin/team_edit').view('admin/footer');
    }
    
          public function team_update($id)
    {
        $session = session();
        $commanmodel = new Commanmodel();
      $category = $commanmodel->all_multiple_query_order_by('category',array('parent_id'=> '0','subparent_id'=> '0'),'menu_order','ASC');
        
        
              $status = $this->request->getVar('status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }
         
         
         
         
         
                $validated = $this->validate([
            'logo' => [
                'label' => 'Image File',
                'rules' => 'uploaded[logo]'
                    . '|is_image[logo]'
                    . '|mime_in[logo,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[logo,100]'
                    . '|max_dims[logo,1024,768]',
            ],
        ]);
 
       
  
        if ($validated) {
          $file = $this->request->getFile('logo');

        // Generate a new secure name
        $logo = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/team', $logo);
        } else {
             $logo = $this->request->getVar('logo_old');
        }
         
         
         
         
         
     
        
          $postData = array(
                    
                'team_name' => $this->request->getVar('name'),
                'team_logo' => $logo,
               'overview' => $this->request->getVar('overview'),
                'designation' => $this->request->getVar('designation'),
                'team_status' => $status, 
                'team_status_color' => $status_color
                );
      
          $where_data = array(
                    'team_id' => $id
                    );
             $insertid = $commanmodel->update_query('team',$postData,$where_data);
        
            $session->setFlashdata('created', 'This team has been Updated successfully!');
                
        return redirect()->to('/admin/team');
    }
    
     public function faq()
    {
         $session = session();
        $commanmodel = new Commanmodel();
       
        $data['id'] = '';
    $data['faqView'] =  $commanmodel->all_multiple_query_order_by('faq',array(),'faq_id','ASC');
        
         return view('admin/head',$data).view('admin/sidebar').view('admin/faq',$data).view('admin/footer');
       
    }


    public function faq_process()
    {
         $session = session();
         $commanmodel = new Commanmodel();
        $data['faqView'] = $commanmodel->get_multiple_query_order_by('faq','faq_id','DESC');
        
        if($this->request->getVar('CreateFaq'))
        {
         $status = $this->request->getVar('faq_status'); 
         if($status=='Active')
         {
           $status_color = 'success';
         }
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }

        $post_data = array(
             'type' => $this->request->getVar('type'),
        'faq_question' => $this->request->getVar('faq_question'),
        'faq_answer' => $this->request->getVar('faq_answer'),
        'faq_status' => $this->request->getVar('faq_status'),
        'faq_status_color' => $status_color
        );
        $inserted = $commanmodel->insert_query('faq',$post_data); 
                   if($inserted)
                   {
                   $session->setFlashdata('created', 'This Faq has been saved.');
                    return redirect()->to(base_url('admin/faq/'.$this->request->getVar('type')));
                    
                   }
                   else
                   {
   $session->setFlashdata('failed', 'Sorry, This faq has not been saved.');  
     return view('admin/head',$data).view('admin/sidebar').view('admin/faq',$data).view('admin/footer');
                   }


            }
        else
        {
       $session->setFlashdata('failed', 'Submit process is not working!');   
        return view('admin/head',$data).view('admin/sidebar').view('admin/faq',$data).view('admin/footer');
        }  

       
    }



    public function delete_faq($faq_id)
    {
         $session = session();
         $commanmodel = new Commanmodel();
     $deleteClient = $commanmodel->delete_query('faq',array('faq_id' =>$faq_id));
     if($deleteClient)
     { 
     $session->setFlashdata('created', 'This Faq is delete.');
      return redirect()->to(base_url('admin/faq/'));
     }
     else
     {
     $session->setFlashdata('failed', 'This faq is not delete!');
      return redirect()->to(base_url('admin/faq/')); 
     }
    
    }


    public function edit_faq($faq_id)
    {
          $commanmodel = new Commanmodel();
        $data['faqView'] = $commanmodel->get_single_query('faq',array('faq_id' => $faq_id));   
        
       
       return view('admin/head',$data).view('admin/sidebar').view('admin/edit-faq',$data).view('admin/footer');
       
    }

    public function edit_faq_process($faq_id)
    {
         $session = session();
          $commanmodel = new Commanmodel();
$data['faqView'] = $commanmodel->get_single_query('faq',array('faq_id' => $faq_id)); 
        if($this->request->getVar('EditFaq'))
        {
         $status = $this->request->getVar('faq_status'); 
         if($status=='Active')
         {
           $status_color = 'success';
         }
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }
        $post_data = array(
              'type' => $this->request->getVar('type'),
        'faq_question' => $this->request->getVar('faq_question'),
        'faq_answer' => $this->request->getVar('faq_answer'),
        'faq_status' => $this->request->getVar('faq_status'),
        'faq_status_color' => $status_color
        );
        $inserted = $commanmodel->update_query('faq',$post_data,array('faq_id' => $faq_id)); 
                   if($inserted)
                   {
                   $session->setFlashdata('created', 'This Faq has been Updated.');
                    return redirect()->to(base_url('admin/faq/'.$this->request->getVar('type')));
                   }
                   else
                   {
           $session->setFlashdata('failed', 'Sorry, This faq has not been updated.');   
   return view('admin/head',$data).view('admin/sidebar').view('admin/edit-faq',$data).view('admin/footer');
                   }


            }
        else
        {
       $session->setFlashdata('failed', 'Submit process is not working!');   
       return view('admin/head',$data).view('admin/sidebar').view('admin/edit-faq',$data).view('admin/footer');
        }  

       
    }
     public function our_gallery()
    {
         $session = session();
         $commanmodel = new Commanmodel();
        $data['clientView'] = $commanmodel->get_multiple_query_order_by('clients','client_id','DESC');    
   
       
       return view('admin/head',$data).view('admin/sidebar').view('admin/our-gallery').view('admin/footer');
    }

public function our_gallery_process()
{
    $session = session();
    $commanmodel = new Commanmodel();

    // Check if form is submitted with 'name'
    if ($this->request->getVar('name')) {
        $clientLogoFile = $this->request->getFile('client_logo');
        $locationFile = $this->request->getFile('location');

        // Validate client_logo is uploaded
        if (!$clientLogoFile || !$clientLogoFile->isValid()) {
            $session->setFlashdata('failed', 'Please choose an image for Client Logo.');
            return $this->loadGalleryView($commanmodel);
        }

        // Upload client_logo
        $client_logo = $clientLogoFile->getRandomName();
        $clientLogoFile->move('assets/client', $client_logo);

    

        // Prepare data
        $post_data = [
            'name'         => $this->request->getVar('name'),
           
            'type'         => $this->request->getVar('type'),
            'client_image' => $client_logo
        ];

        // Insert into DB
        $inserted = $commanmodel->insert_query('clients', $post_data);

        if ($inserted) {
            $session->setFlashdata('created', 'Gallery has been uploaded successfully.');
            return redirect()->to('/admin/our_gallery');
        } else {
            $session->setFlashdata('failed', 'Sorry, the gallery could not be uploaded.');
            return $this->loadGalleryView($commanmodel);
        }
    } else {
        $session->setFlashdata('failed', 'Form submission failed!');
        return $this->loadGalleryView($commanmodel);
    }
}

// Helper method to load gallery view
private function loadGalleryView($commanmodel)
{
    $data['clientView'] = $commanmodel->get_multiple_query_order_by('clients', 'client_id', 'DESC');
    return view('admin/head', $data)
        . view('admin/sidebar')
        . view('admin/our-gallery')
        . view('admin/footer');
}




    public function delete_gallery($client_id)
    {
        $session = session();
         $commanmodel = new Commanmodel();
     $deleteClient = $commanmodel->delete_query('clients',array('client_id' =>$client_id));
     if($deleteClient)
     {
      $session->setFlashdata('created', 'This gallery is delete.');
      return redirect()->to('/admin/our_gallery');
     }
     else
     {
      $session->setFlashdata('failed', 'This is not delete!');
       return redirect()->to('/admin/our_gallery');
     }
    
    }
    
    
    // Ajax: edit ke liye data bhejna
public function edit_gallery($id)
{
    $commanmodel = new Commanmodel();
    $data = $commanmodel->get_single_query('clients', ['client_id' => $id]);

    if ($data) {
        return $this->response->setJSON([
            'status' => true,
            'data' => $data
        ]);
    } else {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'Record not found'
        ]);
    }
}

// Ajax: update ke liye
public function our_gallery_update()
{
    $session = session();
    $commanmodel = new Commanmodel();

    $client_id = $this->request->getVar('client_id');
    $oldData = $commanmodel->get_single_query('clients', ['client_id' => $client_id]);

    if (!$oldData) {
        return $this->response->setJSON(['status' => false, 'message' => 'Invalid ID']);
    }

    $client_logo = $oldData->client_image;

    if (!empty($_FILES['client_logo']['name'])) {
        $file = $this->request->getFile('client_logo');
        if ($file->isValid() && !$file->hasMoved()) {
            $client_logo = $file->getRandomName();
            $file->move('assets/client', $client_logo);

            if ($oldData->client_image && file_exists('assets/client/' . $oldData->client_image)) {
                unlink('assets/client/' . $oldData->client_image);
            }
        }
    }
    
 

    $update_data = [
        'name' => $this->request->getVar('name'),
      
        'type' => $this->request->getVar('type'),
        'client_image' => $client_logo
    ];

    $updated = $commanmodel->update_query('clients', $update_data, ['client_id' => $client_id]);

    if ($updated) {
        return $this->response->setJSON(['status' => true, 'message' => 'Gallery updated successfully']);
    } else {
        return $this->response->setJSON(['status' => false, 'message' => 'Update failed']);
    }
}
    

    
    
      public function enquiry()
{
     $session = session();
 
      $commanmodel = new Commanmodel();


        $data['table_name'] = 'attributes';
    
            $table_header = [
                
            ['data' => 'id'],
          
            ['data' => 'info'],
            ['data' => 'pro'],
            ['data' => 'message'],
      
           
        
        ];
        
        $data['table_column'] = json_encode($table_header);
    
 
   return view('admin/head').view('admin/sidebar').view('admin/enquiry', $data).view('admin/footer');

}
  
     public function enquirylist()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input

// Define filters based on your requirements
$filters = [];



if (session()->get('admin_type')=='Admin') { 
    $filters[] = [
    'column' => 'enquiry_vender',
    'value' => session()->get('id'),
    'type' => 'where',
];
}

// Add search filter if a search term is provided
if (!empty($searchname)) {
$filters[] = [
    'column' => 'enquiry_name',
    'value' => $searchname,
    'type' => 'like',
];
}

// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'enquiry_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('enquiry', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {



$info = 'Name : '.$alldata_view->enquiry_name.'<br>Email : '.$alldata_view->enquiry_email.'<br>Phone : '.$alldata_view->enquiry_phone;



      
      $product = $commanmodel->get_single_query('product',array('product_id'=> $alldata_view->enquiry_pro_id));

$data[] = [
    "id" => $sn,
  
    "info" => $info,
     "pro" => $product->product_title,
     "message" => $alldata_view->enquiry_message,
   
 
  
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}





      public function customer()
{
     $session = session();
 
      $commanmodel = new Commanmodel();


        $data['table_name'] = 'attributes';
    
            $table_header = [
                
            ['data' => 'id'],
          
            ['data' => 'name'],
             ['data' => 'email'],
              ['data' => 'phone'],
          
             ['data' => 'action'],
           
        
        ];
        
        $data['table_column'] = json_encode($table_header);
    
 
   return view('admin/head').view('admin/sidebar').view('admin/customer', $data).view('admin/footer');

}
  
  public function customerlist()
{
    $commanmodel = new Commanmodel();
    $request = \Config\Services::request();
    $db = \Config\Database::connect();

    $draw   = $request->getPost('draw');
    $start  = $request->getPost('start');
    $length = $request->getPost('length');

    $searchname = $request->getPost('searchname');
    $status     = $request->getPost('status');

    $builder = $db->table('user_account');

    // STATUS FILTER
    if (!empty($status)) {
        $builder->where('user_status', $status);
    }

    // SEARCH FILTER
    if (!empty($searchname)) {
        $builder->groupStart()
            ->like('user_name', $searchname)
            ->orLike('user_specialty', $searchname)
            ->orLike('user_address', $searchname)
            ->groupEnd();
    }

    // TOTAL COUNT
    $totalRecords = $builder->countAllResults(false);

    // ORDER
    $builder->orderBy('account_id','DESC');

    // PAGINATION
    $builder->limit($length, $start);

    $query = $builder->get();
    $alldata = $query->getResult();

    $data = [];
    $sn = $start + 1;

    foreach ($alldata as $row) {

        $action = '<div class="btn-group">
                        <button type="button"
                        class="btn btn-outline-'.$row->user_status_color.'">
                        '.$row->user_status.'
                        </button>
                   </div>';

        $data[] = [
            "id"    => $sn,
            "name"  => 'Name : '.$row->user_name.
                       '<br> Specialty : '.$row->user_specialty.
                       '<br> Address : '.$row->user_address,
            "email" => $row->user_email,
            "phone" => $row->user_phone,
            "action"=> $action
        ];

        $sn++;
    }

    $response = [
        "draw" => intval($draw),
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $totalRecords,
        "data" => $data
    ];

    return $this->response->setJSON($response);
}





public function activity_logs()
{
    $commanmodel = new Commanmodel();
    $session = session();
    
    // Check if admin is logged in

    // Get filter parameters
    $search = $this->request->getVar('search') ?? '';
    $activityType = $this->request->getVar('activity_type') ?? '';
    $status = $this->request->getVar('status') ?? '';
    $dateFrom = $this->request->getVar('date_from') ?? '';
    $dateTo = $this->request->getVar('date_to') ?? '';
    $page = $this->request->getVar('page') ?? 1;
    $limit = 20;
    $offset = ($page - 1) * $limit;
    
    // Build filters array for getDataFromTable
    $filters = [];
    
    // Add search filter
    if (!empty($search)) {
        $filters[] = [
            'column' => 'user_name',
            'value' => $search,
            'type' => 'like'
        ];
        // Also search in other fields
        $filters[] = [
            'column' => 'user_email',
            'value' => $search,
            'type' => 'like'
        ];
        $filters[] = [
            'column' => 'ip_address',
            'value' => $search,
            'type' => 'like'
        ];
        $filters[] = [
            'column' => 'activity_details',
            'value' => $search,
            'type' => 'like'
        ];
    }
    
    // Add activity type filter
    if (!empty($activityType)) {
        $filters[] = [
            'column' => 'activity_type',
            'value' => $activityType
        ];
    }
    
    // Add status filter
    if (!empty($status)) {
        $filters[] = [
            'column' => 'activity_status',
            'value' => $status
        ];
    }
    
    // Add date filters
    if (!empty($dateFrom)) {
        $filters[] = [
            'column' => 'created_at >=',
            'value' => $dateFrom . ' 00:00:00'
        ];
    }
    
    if (!empty($dateTo)) {
        $filters[] = [
            'column' => 'created_at <=',
            'value' => $dateTo . ' 23:59:59'
        ];
    }
    
    // Order by
    $orderBy = [
        'column' => 'created_at',
        'order' => 'DESC'
    ];
    
    // Get logs with pagination
    $logsData = $commanmodel->getDataFromTable('activity_logs', $filters, $orderBy, $limit, $offset);
    
    // Get distinct activity types for filter
    $allLogs = $commanmodel->getDataFromTable('activity_logs', [], null, null, 0);
    $distinctTypes = [];
    foreach ($allLogs['filteredRecords'] ?? [] as $log) {
        if (!in_array($log->activity_type, $distinctTypes)) {
            $distinctTypes[] = $log->activity_type;
        }
    }
    
    // Get total records count
    $totalRecords = $logsData['totalRecords'] ?? 0;
    $totalPages = ceil($totalRecords / $limit);
    
    $data = [
        'title' => 'Activity Logs',
        'logs' => $logsData['filteredRecords'] ?? [],
        'total_records' => $totalRecords,
        'filtered_record_count' => $logsData['filteredRecordCount'] ?? 0,
        'total_pages' => $totalPages,
        'current_page' => $page,
        'limit' => $limit,
        'search' => $search,
        'activity_type' => $activityType,
        'status' => $status,
        'date_from' => $dateFrom,
        'date_to' => $dateTo,
        'activity_types' => $distinctTypes,
        'statuses' => ['success', 'failed', 'pending', 'warning', 'info']
    ];
    
    return view('admin/head', $data)
    .view('admin/sidebar')
        . view('admin/activity_logs', $data)
        . view('admin/footer');
}

public function view_log_detail($log_id)
{
    $commanmodel = new Commanmodel();
    $session = session();
    
 
    
    // Get single log using existing method
    $log = $commanmodel->get_single_query('activity_logs', ['log_id' => $log_id]);
    
    if (!$log) {
        return redirect()->to('/admin/activity-logs')->with('error', 'Log not found.');
    }
    
    $data = [
        'title' => 'Log Detail',
        'log' => $log
    ];
    
    return view('admin/head', $data)
       .view('admin/sidebar')
        . view('admin/log_detail', $data)
        . view('admin/footer');
}

public function delete_log($log_id)
{
    $commanmodel = new Commanmodel();
    $session = session();
    
 
    
    // Delete using existing method
    $commanmodel->delete_query('activity_logs', ['log_id' => $log_id]);
    
    return redirect()->to('/admin/activity-logs')->with('success', 'Log deleted successfully.');
}

public function clear_all_logs()
{
    $commanmodel = new Commanmodel();
    $session = session();
    
  
    
    // Clear all logs
    $db = \Config\Database::connect();
    $db->table('activity_logs')->truncate();
    
    return redirect()->to('/admin/activity-logs')->with('success', 'All logs cleared successfully.');
}

public function export_logs()
{
    $commanmodel = new Commanmodel();
    $session = session();
    
  
    // Get all logs
    $logsData = $commanmodel->getDataFromTable('activity_logs', [], ['column' => 'created_at', 'order' => 'DESC'], 10000, 0);
    $logs = $logsData['filteredRecords'] ?? [];
    
    // Set CSV headers
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="activity_logs_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    // Add CSV headers
    fputcsv($output, [
        'Log ID', 'User ID', 'User Email', 'User Name', 'Activity Type', 
        'Status', 'IP Address', 'Browser', 'OS', 'Device Type', 
        'Country', 'City', 'Location', 'Latitude', 'Longitude',
        'Page URL', 'Referrer URL', 'Request Method', 'Details', 'Session ID', 'Created At'
    ]);
    
    // Add data rows
    foreach ($logs as $log) {
        fputcsv($output, [
            $log->log_id ?? '',
            $log->user_id ?? '',
            $log->user_email ?? '',
            $log->user_name ?? '',
            $log->activity_type ?? '',
            $log->activity_status ?? '',
            $log->ip_address ?? '',
            $log->browser ?? '',
            $log->os ?? '',
            $log->device_type ?? '',
            $log->country ?? '',
            $log->city ?? '',
            $log->location ?? '',
            $log->latitude ?? '',
            $log->longitude ?? '',
            $log->page_url ?? '',
            $log->referrer_url ?? '',
            $log->request_method ?? '',
            $log->activity_details ?? '',
            $log->session_id ?? '',
            $log->created_at ?? ''
        ]);
    }
    
    fclose($output);
    exit;
}


}