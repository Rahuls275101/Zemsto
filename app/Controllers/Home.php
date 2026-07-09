<?php

namespace App\Controllers;
require_once(APPPATH . "Libraries/config.php");
require_once(APPPATH . "Libraries/razorpay-php/Razorpay.php");


use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use App\Models\Commanmodel;
use App\Models\Blogmodel;
use App\Models\Ajaxlist;
use App\Libraries\Cart;
use CodeIgniter\Email\Email;
use CodeIgniter\I18n\Time;
use Config\Services;

class Home extends BaseController
{
    public function index()
    { 
    /*   $cart = new \App\Libraries\Cart();
        
       $datcart = $cart->contents();
       Uttar Pradesh
       print_r($datcart);
       */
        $commanmodel = new Commanmodel();
        $newblog = $commanmodel->all_multiple_query_order_by_limit('blogs',array('blog_status' => 'Active'),'blog_id','ASC',4); 
         $productfirst = $commanmodel->all_multiple_query_order_by_limit('product',array('product_status' => 'Active'),'product_id','DESC',10); 
         
      
         
        
         $data = array(
         
            'search' => '',
           'product' => $productfirst,
        
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 1));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
               
             $allData = $commanmodel->getDataFromTable(
            'syllabus', 
            [['column' => 'status', 'value' => 'Active', 'type' => 'where']],
            ['column' => 'class_name', 'order' => 'ASC']
        );
        
        // Check if data exists
        if (isset($allData['filteredRecords']) && !empty($allData['filteredRecords'])) {
            $data['classes'] = $allData['filteredRecords'];
        } else {
            $data['classes'] = [];
        }
            
             $data['bannerView'] = $commanmodel->get_multiple_query_order_by('home_banner','banner_id','DESC'); 
         return view('frontend/header',$data).view('frontend/index').view('frontend/footer');
    }
    
    
    
     public function questions($syllabusId)
    {
        $commanmodel = new Commanmodel();
        
        
         $data = array(
         
            'search' => '',
         
        
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
        // Get syllabus details
        $syllabusData = $commanmodel->getDataFromTable(
            'syllabus',
            [['column' => 'id', 'value' => $syllabusId, 'type' => 'where']]
        );
        
        if (isset($syllabusData['filteredRecords']) && !empty($syllabusData['filteredRecords'])) {
            $data['syllabus'] = $syllabusData['filteredRecords'][0];
        } else {
            return redirect()->to('/practice')->with('error', 'Syllabus not found');
        }
        
        // Get questions for this syllabus
        $questionsData = $commanmodel->getDataFromTable(
            'syllabus_questions',
            [
                ['column' => 'syllabus_id', 'value' => $syllabusId, 'type' => 'where'],
                ['column' => 'status', 'value' => 'Active', 'type' => 'where']
            ],
            ['column' => 'id', 'order' => 'RANDOM']
        );
        
        if (isset($questionsData['filteredRecords']) && !empty($questionsData['filteredRecords'])) {
            $data['questions'] = $questionsData['filteredRecords'];
        } else {
            $data['questions'] = [];
        }
        
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 1));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
               
         return view('frontend/header',$data).view('frontend/questions').view('frontend/footer');
    }
    
    
       public function gallery()
    { 
  
        $commanmodel = new Commanmodel();
       
        
         $data = array(
         
            'search' => '',
  
        
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 4));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
          
         return view('frontend/header',$data).view('frontend/gallery').view('frontend/footer');
    }
    
         public function olympiads()
    { 
  
        $commanmodel = new Commanmodel();
       
        
         $data = array(
         
            'search' => '',
  
        
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
                    $filters = [
            ['column' => 'exotic_status', 'value' => 'Active', 'type' => 'where'],
             ['column' => 'type', 'value' => '1', 'type' => 'where']
        ];
        $order = ['column' => 'display_order', 'order' => 'ASC'];
        
        $result = $commanmodel->getExoticData('exotic_collection', $filters, $order);
        $data['collections'] = $result['records'];
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 12));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
          
         return view('frontend/header',$data).view('frontend/olympiads').view('frontend/footer');
    }
    
    
    
       public function competitions()
    { 
  
        $commanmodel = new Commanmodel();
       
        
         $data = array(
         
            'search' => '',
  
        
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
                    $filters = [
            ['column' => 'exotic_status', 'value' => 'Active', 'type' => 'where'],
             ['column' => 'type', 'value' => '1', 'type' => 'where']
        ];
        $order = ['column' => 'display_order', 'order' => 'ASC'];
        
        $result = $commanmodel->getExoticData('exotic_collection', $filters, $order);
        $data['collections'] = $result['records'];
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 12));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
          
         return view('frontend/header',$data).view('frontend/competitions').view('frontend/footer');
    }
    
    
    
   public function competition_details($id = null)
{
    $commanmodel = new Commanmodel();

    // Competition Fetch
    if (empty($id)) {
        $competition = $commanmodel->get_single_query(
            'competitions',
            ['status' => 'Active']
        );
    } else {
        $competition = $commanmodel->get_single_query(
            'competitions',
            ['id' => $id]
        );
    }

    if (!$competition) {
        return view('frontend/competition_not_found');
    }

    // Decode JSON Fields
    $json_fields = [
        'counter_data',
        'features',
        'categories',
        'submission_requirements',
        'prizes',
        'faqs',
        'how_to_participate'
    ];

    foreach ($json_fields as $field) {

        if (!empty($competition->$field)) {
            $competition->$field = json_decode($competition->$field, true);
        } else {
            $competition->$field = [];
        }
    }

    // Meta Data
    $meta = $commanmodel->get_single_query(
        'meta',
        ['meta_id' => 13]
    );

    $data = [];

    $data['title'] = $meta->meta_title ?? '';
        $data['keyword'] = $meta->meta_keyword;
    $data['pageimage'] = !empty($meta->meta_image)
        ? base_url('assets/meta/' . $meta->meta_image)
        : '';

    $data['competition'] = $competition;

    $data['title'] = !empty($competition->meta_title)
        ? $competition->meta_title
        : ($competition->title ?? '');

    $data['description'] = !empty($competition->meta_description)
        ? $competition->meta_description
        : ($competition->description ?? '');

    $data['search'] = '';
    $data['searchcategory'] = 'all';
    $data['pageurl'] = current_url();

    return view('frontend/header', $data)
        . view('frontend/competition_details', $data)
        . view('frontend/footer', $data);
}
    
            public function timber_trees()
    { 
  
        $commanmodel = new Commanmodel();
       
        
         $data = array(
         
            'search' => '',
  
        
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
                    $filters = [
            ['column' => 'exotic_status', 'value' => 'Active', 'type' => 'where'],
             ['column' => 'type', 'value' => '2', 'type' => 'where']
        ];
        $order = ['column' => 'display_order', 'order' => 'ASC'];
        
        $result = $commanmodel->getExoticData('exotic_collection', $filters, $order);
        $data['collections'] = $result['records'];
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 13));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
          
         return view('frontend/header',$data).view('frontend/timber_trees').view('frontend/footer');
    }
    
    
    
          public function fruit_plants()
    { 
  
        $commanmodel = new Commanmodel();
       
        
         $data = array(
         
            'search' => '',
  
        
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
                    $filters = [
            ['column' => 'exotic_status', 'value' => 'Active', 'type' => 'where'],
             ['column' => 'type', 'value' => '3', 'type' => 'where']
        ];
        $order = ['column' => 'display_order', 'order' => 'ASC'];
        
        $result = $commanmodel->getExoticData('exotic_collection', $filters, $order);
        $data['collections'] = $result['records'];
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 14));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
          
         return view('frontend/header',$data).view('frontend/fruit_plants').view('frontend/footer');
    }
    
        public function indoor_plants()
    { 
  
        $commanmodel = new Commanmodel();
       
        
         $data = array(
         
            'search' => '',
  
        
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
                    $filters = [
            ['column' => 'exotic_status', 'value' => 'Active', 'type' => 'where'],
             ['column' => 'type', 'value' => '4', 'type' => 'where']
        ];
        $order = ['column' => 'display_order', 'order' => 'ASC'];
        
        $result = $commanmodel->getExoticData('exotic_collection', $filters, $order);
        $data['collections'] = $result['records'];
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 15));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
          
         return view('frontend/header',$data).view('frontend/indoor_plants').view('frontend/footer');
    }

 public function landscaping_plants()
    { 
  
        $commanmodel = new Commanmodel();
       
        
         $data = array(
         
            'search' => '',
  
        
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
                    $filters = [
            ['column' => 'exotic_status', 'value' => 'Active', 'type' => 'where'],
             ['column' => 'type', 'value' => '5', 'type' => 'where']
        ];
        $order = ['column' => 'display_order', 'order' => 'ASC'];
        
        $result = $commanmodel->getExoticData('exotic_collection', $filters, $order);
        $data['collections'] = $result['records'];
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 16));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
          
         return view('frontend/header',$data).view('frontend/landscaping_plants').view('frontend/footer');
    }
    
    
     public function landscape_design()
    { 
  
    $this->db = \Config\Database::connect();
        $commanmodel = new Commanmodel();
       
        
         $data = array(
         
            'search' => '',
  
        
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
                    $filters = [
            ['column' => 'exotic_status', 'value' => 'Active', 'type' => 'where'],
             ['column' => 'type', 'value' => '6', 'type' => 'where']
        ];
        $order = ['column' => 'display_order', 'order' => 'ASC'];
        
        $result = $commanmodel->getExoticData('exotic_collection', $filters, $order);
        $data['collections'] = $result['records'];
        
        
            if (!empty($data['collections'])) {
        $exotic_id = $data['collections'][0]->exotic_id;
        $galleryBuilder = $this->db->table('exotic_gallery');
        $galleryBuilder->where('exotic_id', $exotic_id);
        $galleryBuilder->orderBy('display_order', 'ASC');
        $data['gallery_images'] = $galleryBuilder->get()->getResult();
    } else {
        $data['gallery_images'] = [];
    }
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 17));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
          
         return view('frontend/header',$data).view('frontend/landscape-design').view('frontend/footer');
    }
    
     public function farmhouses_resorts()
    { 
      $this->db = \Config\Database::connect();
        $commanmodel = new Commanmodel();
       
        
         $data = array(
         
            'search' => '',
  
        
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
                    $filters = [
            ['column' => 'exotic_status', 'value' => 'Active', 'type' => 'where'],
             ['column' => 'type', 'value' => '7', 'type' => 'where']
        ];
        $order = ['column' => 'display_order', 'order' => 'ASC'];
        
        $result = $commanmodel->getExoticData('exotic_collection', $filters, $order);
        $data['collections'] = $result['records'];
        
         if (!empty($data['collections'])) {
        $exotic_id = $data['collections'][0]->exotic_id;
        $galleryBuilder = $this->db->table('exotic_gallery');
        $galleryBuilder->where('exotic_id', $exotic_id);
        $galleryBuilder->orderBy('display_order', 'ASC');
        $data['gallery_images'] = $galleryBuilder->get()->getResult();
    } else {
        $data['gallery_images'] = [];
    }
    
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 18));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
          
         return view('frontend/header',$data).view('frontend/farmhouses_resorts').view('frontend/footer');
    }
      public function maintenance()
    { 
      $this->db = \Config\Database::connect();
        $commanmodel = new Commanmodel();
       
        
         $data = array(
         
            'search' => '',
  
        
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
                    $filters = [
            ['column' => 'exotic_status', 'value' => 'Active', 'type' => 'where'],
             ['column' => 'type', 'value' => '8', 'type' => 'where']
        ];
        $order = ['column' => 'display_order', 'order' => 'ASC'];
        
        $result = $commanmodel->getExoticData('exotic_collection', $filters, $order);
        $data['collections'] = $result['records'];
        
         if (!empty($data['collections'])) {
        $exotic_id = $data['collections'][0]->exotic_id;
        $galleryBuilder = $this->db->table('exotic_gallery');
        $galleryBuilder->where('exotic_id', $exotic_id);
        $galleryBuilder->orderBy('display_order', 'ASC');
        $data['gallery_images'] = $galleryBuilder->get()->getResult();
    } else {
        $data['gallery_images'] = [];
    }
    
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 19));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
          
         return view('frontend/header',$data).view('frontend/maintenance').view('frontend/footer');
    }
    
    
    
        public function list_of_workshops()
    { 
    /*   $cart = new \App\Libraries\Cart();
        
       $datcart = $cart->contents();
       
       print_r($datcart);
       */
        $commanmodel = new Commanmodel();
        $newblog = $commanmodel->all_multiple_query_order_by_limit('blogs',array('blog_status' => 'Active'),'blog_id','ASC',4); 
         $productfirst = $commanmodel->all_multiple_query_order_by_limit('product',array('product_status' => 'Active'),'product_id','DESC',10); 
         
      
         
        
         $data = array(
         
            'search' => '',
           'product' => $productfirst,
        
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 1));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
             $data['bannerView'] = $commanmodel->get_multiple_query_order_by('home_banner','banner_id','DESC'); 
         return view('frontend/header',$data).view('frontend/list_of_workshops').view('frontend/footer');
    }
      public function post()
    { 
   
        $commanmodel = new Commanmodel();
      

         $data = array(
         
            'search' => '',
          
   
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 1));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
           
         return view('frontend/header',$data).view('frontend/post').view('frontend/footer');
    }
    
         public function faq()
    { 
   
        $commanmodel = new Commanmodel();
      

         $data = array(
         
            'search' => '',
          
   
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 1));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
           
         return view('frontend/header',$data).view('frontend/faq').view('frontend/footer');
    }
    
     public function journey()
    { 
    /*   $cart = new \App\Libraries\Cart();
        
       $datcart = $cart->contents();
       
       print_r($datcart);
       */
        $commanmodel = new Commanmodel();
      

         $data = array(
         
            'search' => '',
          
   
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 1));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
           
         return view('frontend/header',$data).view('frontend/journey').view('frontend/footer');
    }
    

    
       public function resources()
    { 
   
        $commanmodel = new Commanmodel();
      

         $data = array(
         
            'search' => '',
          
   
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 1));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
           
         return view('frontend/header',$data).view('frontend/resources').view('frontend/footer');
    }
         public function medical_leadership_workshops()
    { 
   
        $commanmodel = new Commanmodel();
      

         $data = array(
         
            'search' => '',
          
   
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 1));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
            
           
         return view('frontend/header',$data).view('frontend/medical_leadership_workshops').view('frontend/footer');
    }
    
  
       public function book()
    {
        $commanmodel = new Commanmodel();
        $db = \Config\Database::connect();

        // ============================================
        // GET FILTER VALUES
        // ============================================
        $class = $this->request->getGet('class');
        $subject = $this->request->getGet('subject');
        $book_type = $this->request->getGet('book_type');
        $country = $this->request->getGet('country');
        $page = $this->request->getGet('page') ?? 1;

        // ============================================
        // BUILD QUERY
        // ============================================
        $builder = $db->table('books');
        $builder->where('book_status', 'Active');

        if (!empty($class) && $class != 'Class' && $class != '') {
            $builder->where('book_class', $class);
        }

        if (!empty($subject) && $subject != 'Subject' && $subject != '') {
            $builder->where('book_subject', $subject);
        }

        if (!empty($book_type) && $book_type != 'Physical Book' && $book_type != 'E-Book' && $book_type != 'Audio Book' && $book_type != '') {
            $builder->where('book_type', $book_type);
        }

        // ============================================
        // COUNT TOTAL RECORDS
        // ============================================
        $totalRecords = $builder->countAllResults(false);

        // ============================================
        // PAGINATION
        // ============================================
        $perPage = 8;
        $totalPages = ceil($totalRecords / $perPage);
        $currentPage = ($page > $totalPages) ? $totalPages : $page;
        $currentPage = ($currentPage < 1) ? 1 : $currentPage;
        $offset = ($currentPage - 1) * $perPage;

        // ============================================
        // GET BOOKS
        // ============================================
        $builder->limit($perPage, $offset);
        $builder->orderBy('book_id', 'DESC');
        $query = $builder->get();
        
        if ($query && is_object($query)) {
            $books = $query->getResult();
        } else {
            $books = [];
        }

        // ============================================
        // GET CLASSES
        // ============================================
   $classBuilder = $db->table('books');
$classBuilder->distinct();
$classBuilder->select('book_class');
$classBuilder->where('book_status', 'Active');
$classBuilder->orderBy('book_class', 'ASC');

$classQuery = $classBuilder->get();

$classes = $classQuery->getResult();

        // ============================================
        // âœ… PASS ALL DATA TO VIEW
        // ============================================
        $data = array(
            'books' => $books,
            'classes' => $classes,
            'selected_class' => $class,
            'selected_subject' => $subject,
            'selected_type' => $book_type,
            'selected_country' => $country,
            'current_page' => $currentPage,
            'total_pages' => $totalPages,
            'total_records' => $totalRecords,
            'per_page' => $perPage,
            'base_url' => base_url('books'),
            'query_params' => $_GET,
            'pageurl' => base_url(),
        );

        // Meta Data
        $meta = $commanmodel->get_single_query('meta', array('meta_id' => 1));
        if ($meta) {
            $data['title'] = $meta->meta_title ?? 'Find Your Books';
            $data['keyword'] = $meta->meta_keyword ?? '';
            $data['description'] = $meta->meta_description ?? '';
            $data['pageimage'] = base_url('assets/meta/' . ($meta->meta_image ?? ''));
        } else {
            $data['title'] = 'Find Your Books';
            $data['keyword'] = '';
            $data['description'] = '';
            $data['pageimage'] = '';
        }

        return view('frontend/header', $data) 
             . view('frontend/book', $data) 
             . view('frontend/footer');
    }
    
    
        public function book_details($slug)
    {
        $commanmodel = new Commanmodel();
        $db = \Config\Database::connect();

        // ============================================
        // GET BOOK BY SLUG
        // ============================================
        $builder = $db->table('books');
        $builder->where('url_slug', $slug);
        $builder->where('book_status', 'Active');
        $query = $builder->get();
        
        if ($query && is_object($query)) {
            $book = $query->getRow();
        } else {
            $book = null;
        }

        // If book not found, show 404
        if (!$book) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // ============================================
        // GET RELATED BOOKS (Same Class)
        // ============================================
        $relatedBuilder = $db->table('books');
        $relatedBuilder->where('book_status', 'Active');
        $relatedBuilder->where('book_class', $book->book_class);
        $relatedBuilder->where('book_id !=', $book->book_id);
        $relatedBuilder->limit(4);
        $relatedBuilder->orderBy('book_id', 'RANDOM');
        $relatedQuery = $relatedBuilder->get();
        
        if ($relatedQuery && is_object($relatedQuery)) {
            $related_books = $relatedQuery->getResult();
        } else {
            $related_books = [];
        }

        // ============================================
        // IMAGES (Support multiple or single)
        // ============================================
        $images = [];
        if (!empty($book->book_images)) {
            // Multiple images (comma separated)
            $images = explode(',', $book->book_images);
        } elseif (!empty($book->book_image)) {
            // Single image
            $images = [$book->book_image];
        } else {
            $images = ['default.jpg'];
        }

        // ============================================
        // PASS DATA TO VIEW
        // ============================================
        $data = array(
            'book' => $book,
            'images' => $images,
            'related_books' => $related_books,
            'pageurl' => base_url(),
        );

        // Meta Data
        $data['title'] = $book->book_name ?? 'Book Details';
        $data['keyword'] = $book->book_name ?? '';
        $data['description'] = $book->book_description ?? '';
        $data['pageimage'] = base_url('assets/books/' . ($book->book_image ?? 'default.jpg'));

        return view('frontend/header', $data) 
             . view('frontend/book_details', $data) 
             . view('frontend/footer');
    }
    
    
     public function save_enquiry()
    {
        $commanmodel = new Commanmodel();
        $db = \Config\Database::connect();

        // ============================================
        // VALIDATION
        // ============================================
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[10]|max_length[15]',
            'message' => 'permit_empty|max_length[500]',
            'book_id' => 'required|numeric',
            'book_name' => 'required|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // ============================================
        // PREPARE DATA
        // ============================================
        $data = [
            'book_id' => $this->request->getPost('book_id'),
            'book_name' => $this->request->getPost('book_name'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'message' => $this->request->getPost('message'),
            'status' => 'Pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        // ============================================
        // INSERT INTO DATABASE
        // ============================================
        try {
            $insertId = $commanmodel->insert_query('enquiries', $data);
            
            if ($insertId) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Enquiry sent successfully! We will contact you soon.',
                    'id' => $insertId
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Failed to send enquiry. Please try again.'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    
    
    public function winners_member()
    {
        $commanmodel = new Commanmodel();
        $db = \Config\Database::connect();

        // Get all active winners
        $builder = $db->table('winners_member');
        $builder->where('status', 'Active');
        $builder->orderBy('winner_id', 'DESC');
        $query = $builder->get();
        
        if ($query && is_object($query)) {
            $winners = $query->getResult();
        } else {
            $winners = [];
        }

        $data['winners'] = $winners;
        $data['title'] = 'Hall of Frame';
        $data['pageurl'] = base_url();
        
                $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 1));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);

        return view('frontend/header', $data) 
             . view('frontend/winners_member', $data) 
             . view('frontend/footer');
    }
    
    
public function talent_winners()
{
    $commanmodel = new Commanmodel();
    $db = \Config\Database::connect();

    // Get filter parameters
    $year     = $this->request->getGet('year') ?? '';
    $state    = $this->request->getGet('state') ?? '';
    $category = $this->request->getGet('category') ?? '';
    $search   = $this->request->getGet('search') ?? '';

    // Main Query
    $builder = $db->table('talent_winners');
    $builder->where('status', 'Active');

    if (!empty($year)) {
        $builder->where('year', $year);
    }

    if (!empty($state)) {
        $builder->where('state', $state);
    }

    if (!empty($category)) {
        $builder->where('category', $category);
    }

    if (!empty($search)) {
        $builder->groupStart()
                ->like('name', $search)
                ->orLike('school', $search)
                ->orLike('city', $search)
                ->orLike('state', $search)
                ->groupEnd();
    }

    $builder->orderBy('rank', 'ASC');

    $query = $builder->get();

    if ($query !== false) {
        $allWinners = $query->getResult();
    } else {
        $allWinners = [];
        // Uncomment for debugging
        // dd($db->error());
    }

    // Group by Category
    $winnersByCategory = [];

    foreach ($allWinners as $winner) {
        $winnersByCategory[$winner->category][] = $winner;
    }

    // Years
    $yearQuery = $db->table('talent_winners')
        ->distinct()
        ->select('year')
        ->where('status', 'Active')
        ->orderBy('year', 'DESC')
        ->get();

    $years = ($yearQuery !== false) ? $yearQuery->getResult() : [];

    // States
    $stateQuery = $db->table('talent_winners')
        ->distinct()
        ->select('state')
        ->where('status', 'Active')
        ->where('state !=', '')
        ->orderBy('state', 'ASC')
        ->get();

    $states = ($stateQuery !== false) ? $stateQuery->getResult() : [];

    // Categories
    $categoryQuery = $db->table('talent_winners')
        ->distinct()
        ->select('category')
        ->where('status', 'Active')
        ->where('category !=', '')
        ->orderBy('category', 'ASC')
        ->get();

    $categories = ($categoryQuery !== false) ? $categoryQuery->getResult() : [];

    // Meta
    $meta = $commanmodel->get_single_query('meta', ['meta_id' => 1]);

    $data = [];
    $data['winnersByCategory'] = $winnersByCategory;
    $data['years'] = $years;
    $data['states'] = $states;
    $data['categories'] = $categories;
    $data['selected_year'] = $year;
    $data['selected_state'] = $state;
    $data['selected_category'] = $category;
    $data['search_term'] = $search;
    $data['pageurl'] = base_url();

    if ($meta) {
        $data['title'] = $meta->meta_title;
        $data['keyword'] = $meta->meta_keyword;
        $data['description'] = $meta->meta_description;
        $data['pageimage'] = base_url('assets/meta/' . $meta->meta_image);
    } else {
        $data['title'] = 'Kids Talent Show Winners';
        $data['keyword'] = '';
        $data['description'] = '';
        $data['pageimage'] = '';
    }

    return view('frontend/header', $data)
        . view('frontend/talent_winners', $data)
        . view('frontend/footer');
}
    
    public function subscribe()
    {
        $email = trim($this->request->getPost('email'));
$commanmodel = new Commanmodel();
        // Validation
        if (empty($email)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Please enter your email address.'
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Please enter a valid email address.'
            ]);
        }

        // Check if email already exists
        $existing = $commanmodel->get_single_query('newsletter_subscription', ['newsletter_email' => $email]);

        if ($existing) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'This email is already subscribed!'
            ]);
        }

        // Prepare data
        $data = [
            'newsletter_email' => $email,
            'newsletter_date' => date('Y-m-d H:i:s'),
            'newsletter_ip' => $this->request->getIPAddress(),
            'newsletter_status' => 'Active'
        ];

        // Insert
        try {
            $insertId = $commanmodel->insert_query('newsletter_subscription', $data);
            
            if ($insertId) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Thank you for subscribing!'  
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Failed to subscribe. Please try again.'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
      public function about_us()
    {
        
         $commanmodel = new Commanmodel();
         $data = array(
           
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
           
            );
            
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 2));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
         return view('frontend/header',$data).view('frontend/about_us').view('frontend/footer');
    }
    
       public function blog()
    { $commanmodel = new Commanmodel();
        $newblog = $commanmodel->all_multiple_query_order_by_limit('blogs',array('blog_status' => 'Active'),'blog_id','ASC',4); 
         $data = array(
          
            'search' => '',
          'newblog' => $newblog,
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
           
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 4));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
         return view('frontend/header',$data).view('frontend/blog').view('frontend/footer');
    }
    
      public function blog_detail($slug)
    {
        $commanmodel = new Commanmodel();
        $blogs = $commanmodel->get_single_query('blogs',array('url_slug'=> $slug));
     $newblog = $commanmodel->all_multiple_query_order_by_limit('blogs',array('blog_status' => 'Active'),'blog_id','ASC',4); 
         $data = array(
             'blogs' => $blogs, 
            'newblog' => $newblog,
            'title' => $blogs->meta_title." : Rent House", 
            'keyword' =>  $blogs->meta_keyword,
            'description' =>  $blogs->meta_description,
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
         return view('frontend/header',$data).view('frontend/blog_detail').view('frontend/footer');
    } 
    
       public function contact_us()
    {
         $commanmodel = new Commanmodel();
         $data = array(
           
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
           
            );
            
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 3));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
               
         return view('frontend/header',$data).view('frontend/contact_us').view('frontend/footer');
    }
    
      public function catalog($slug = null)
    {
        $commanmodel = new Commanmodel();
        
        
        
        $category = $commanmodel->get_single_query('category',array('url_slug'=> $slug));
        $catname = '';
        $mainid = '';
        
        if($slug == 'all') {
          $catname =  'Life Lessons';
        }
        
        
        if($category) {
          
            $parent_id =  $category->parent_id; 
            
            if($parent_id == 0) {
                $mainid =  $category->category_id; 
                 $catname = $category->category_name; 
                $id = '';
            } else {
                 $mainid = '';
                $id = $category->category_id; 
                $catname = $category->category_name; 
            }
            
            
        } else {
            $id = '';
        }
        
           $session = session();
        $commanmodel = new Commanmodel();
         $data = array(
          
            'search' => '',
             'collection' => '',
             'mainid' => $mainid,
              'catname' => $catname,
           'id' => $id,
            'url' => $slug,
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            
            );
            
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 5));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
             
         return view('frontend/header',$data).view('frontend/catalog',$data).view('frontend/footer');
    }
    
        public function search()
    {
        $commanmodel = new Commanmodel();
        
           $session = session();
        $commanmodel = new Commanmodel();
        
      $categoryget =  $this->request->getVar('category');
            $category = $commanmodel->get_single_query('category',array('url_slug'=> $categoryget));
        
        
        if($category) {
          
            $parent_id =  $category->parent_id; 
            
            if($parent_id == 0) {
                $mainid =  $category->category_id; 
                $id = '';
            } else {
                 $mainid = '';
                $id = $category->category_id; 
            }
            
            
        } else {
            $id = '';
            $mainid = '';
        }
        
        
        
        
         $data = array(
           
            'search' => $this->request->getVar('search'),
              'mainid' => '',
           'id' => '',
            'url' => 'search',
             'collection' => '',
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
           
            );
            
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 6));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
             
         return view('frontend/header',$data).view('frontend/catalog',$data).view('frontend/footer');
    }
    
      public function collection($slug)
    {
        $commanmodel = new Commanmodel();
        
       $collections = $commanmodel->get_single_query('collections',array('url_slug'=> $slug));
        
           $session = session();
        $commanmodel = new Commanmodel();
         $data = array(
           
            'search' => '',
           'id' => '',
           'collection' => $collections->collections_id,
            'url' => 'search',
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
          
            );
            
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 5));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
             
         return view('frontend/header',$data).view('frontend/catalog',$data).view('frontend/footer');
    }
     public function ajax_list($page)
{
    
 $commanmodel = new Commanmodel();
 $mainid=  $this->request->getVar('mainid');
    $id=  $this->request->getVar('id');
 $url=  $this->request->getVar('list');
$search=  $this->request->getVar('search');
$collection=  $this->request->getVar('collection');
$minprice=  $this->request->getVar('minprice');
$maxprice=  $this->request->getVar('maxprice');
$shortby=  $this->request->getVar('shortby');
   
$Travellmodel = new Ajaxlist($id);

 $pager = service('pager');
 
 
   $allid = array_column(
        $commanmodel->all_multiple_query_order_by('category', ['parent_id' => $mainid], 'category_id', 'ASC'),
        'category_id'
    );

$perPage = 12;
$total = $Travellmodel->count_all_frontend($mainid,$id,$search,$collection,$minprice,$maxprice,$shortby,$allid);
$segment = $this->request->uri->getSegment(2);

// Set the base URL and segment for pagination links.
$pager->setPath(base_url($url), $segment);

// Generate pagination links using the makeLinks() method.
$pager_links = $pager->makeLinks($page, $perPage, $total, 'foundation_full');

$start = ($page - 1) * $perPage;

$output = [
    'item_total' => 'Showing '.$total.' total results',
    'pagination_link' => $pager_links,
    'product_list' => $Travellmodel->fetch_data($perPage, $start,$mainid,$id,$search,$collection,$minprice,$maxprice,$shortby,$allid)['output'],
     'headoutput' => $Travellmodel->fetch_data($perPage, $start,$mainid,$id,$search,$collection,$minprice,$maxprice,$shortby,$allid)['headoutput']
];

echo json_encode($output);


}
     public function product_details($slug)
    {
        $commanmodel = new Commanmodel();
        $product = $commanmodel->get_single_query('product',array('slug'=> $slug));
        
         $data = array(
             'product' => $product, 
             
            'title' => $product->product_meta_title, 
            'keyword' =>  $product->product_meta_keyword,
            'description' =>  $product->product_meta_description,
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
         return view('frontend/header',$data).view('frontend/product_details').view('frontend/footer');
    } 
    
       public function login()
    {
        $commanmodel = new Commanmodel();
       
        
         $data = array(
         
             
          
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            
            );
            
               $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 1));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
               
         return view('frontend/header',$data).view('frontend/login').view('frontend/footer');
    }

public function register()
{
    $commanmodel = new Commanmodel();
    
    // Get competitions from existing competitions table
    $competitionsData = $commanmodel->getDataFromTable('competitions', ['status' => 'Active']);
    $activeCompetitions = $competitionsData['filteredRecords'] ?? [];
    
    $data = array(
        'search' => '',
        'searchcategory' => 'all',
        'pageurl' => base_url(),
        'competitions' => $activeCompetitions
    );
    
    $meta = $commanmodel->get_single_query('meta', array('meta_id' => 1));
    $data['title'] = $meta->meta_title ?? 'Register';
    $data['keyword'] = $meta->meta_keyword ?? '';
    $data['description'] = $meta->meta_description ?? '';
    $data['pageimage'] = base_url('assets/meta/' . ($meta->meta_image ?? ''));
    
    return view('frontend/header', $data)
        . view('frontend/register', $data)
        . view('frontend/footer');
}

public function registration_success()
{
    $commanmodel = new Commanmodel();
    
    $data = array(
        'search' => '',
        'searchcategory' => 'all',
        'pageurl' => base_url(),
    );
    
    $meta = $commanmodel->get_single_query('meta', array('meta_id' => 1));
    $data['title'] = $meta->meta_title ?? 'Registration Success';
    $data['keyword'] = $meta->meta_keyword ?? '';
    $data['description'] = $meta->meta_description ?? '';
    $data['pageimage'] = base_url('assets/meta/' . ($meta->meta_image ?? ''));
    
    return view('frontend/header', $data)
        . view('frontend/registration_success')
        . view('frontend/footer');
}

public function register_process()
{
    try {
        $session = session();
        $commanmodel = new Commanmodel();
        helper(['form', 'url', 'log_helper']); // Added log_helper here
        $validation = \Config\Services::validation();

        // Get form data
        $competitionType = $this->request->getVar('competition_type');
        $selectedCompetitions = $this->request->getVar('competitions');
        $registrationType = $this->request->getVar('registration_type');
        $totalAmount = $this->request->getVar('total_amount');
        $password = $this->request->getVar('password');
        $confirmPassword = $this->request->getVar('confirm_password');
        $email = $this->request->getVar('email_register'); // Store email for later use

        // ============================================
        // Validate Password
        // ============================================
        if (empty($password)) {
            $array = [
                'success' => false,
                'errors' => ['password' => 'Password is required.']
            ];
            echo json_encode($array);
            return;
        }

        if (strlen($password) < 6) {
            $array = [
                'success' => false,
                'errors' => ['password' => 'Password must be at least 6 characters.']
            ];
            echo json_encode($array);
            return;
        }

        if ($password !== $confirmPassword) {
            $array = [
                'success' => false,
                'errors' => ['confirm_password' => 'Passwords do not match.']
            ];
            echo json_encode($array);
            return;
        }

        // ============================================
        // Validate Required Fields
        // ============================================
        $rules = [
            'student_name' => 'required|min_length[2]|max_length[100]',
            'class_grade' => 'required|min_length[1]|max_length[50]',
            'parent_name' => 'required|min_length[2]|max_length[100]',
            'phone_register' => 'required|min_length[10]|max_length[15]',
            'email_register' => 'required|valid_email',
            'address' => 'required|min_length[5]',
            'city' => 'required|min_length[2]|max_length[100]',
            'state' => 'required|min_length[2]|max_length[100]',
            'date_of_birth' => 'required|valid_date',
            'school_name' => 'required',
            'school_branch' => 'required|min_length[2]|max_length[200]',
            'terms' => 'required'
        ];

        if ($competitionType == 'international') {
            $rules['country'] = 'required|min_length[2]|max_length[100]';
        }

        // ============================================
        // Validate Selected Competitions
        // ============================================
        if ($registrationType == 'with_competition') {
            if (empty($selectedCompetitions) || !is_array($selectedCompetitions)) {
                $array = [
                    'success' => false,
                    'message' => 'Please select at least one competition.'
                ];
                echo json_encode($array);
                return;
            }
        }

        // ============================================
        // Validate Form
        // ============================================
        if ($this->validate($rules)) {
            
            // Start transaction
            $db = \Config\Database::connect();
            $db->transBegin();

            try {
                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // ============================================
                // Prepare Registration Data
                // ============================================
                $registrationData = [
                    'student_name' => $this->request->getVar('student_name'),
                    'user_name' => $this->request->getVar('student_name'),
                    'class_grade' => $this->request->getVar('class_grade'),
                    'parent_name' => $this->request->getVar('parent_name'),
                    'user_phone' => $this->request->getVar('phone_register'),
                    'user_email' => $email,
                    'user_address' => $this->request->getVar('address'),
                    'city' => $this->request->getVar('city'),
                    'state' => $this->request->getVar('state'),
                    'zip_code' => $this->request->getVar('zip_code'),
                    'date_of_birth' => $this->request->getVar('date_of_birth'),
                    'school_name' => $this->request->getVar('school_name'),
                    'school_branch' => $this->request->getVar('school_branch'),
                    'competition_type' => $competitionType,
                    'registration_type' => $registrationType,
                    'total_amount' => $totalAmount ?? 0,
                    'user_type' => 1,
                    'payment_status' => ($totalAmount > 0) ? 'pending' : 'completed',
                    'user_password' => $hashedPassword,
                    'I_accept_terms_and_conditions' => 'yes',
                    'register_date' => date('Y-m-d H:i:s')
                ];

                if ($competitionType == 'international') {
                    $registrationData['country'] = $this->request->getVar('country');
                }

                // ============================================
                // Check if User Already Exists
                // ============================================
                $existingUser = $commanmodel->get_single_query('user_account', ['user_email' => $email]);

                if ($existingUser) {
                    $userId = $existingUser->account_id;
                    // Update existing user
                    $commanmodel->update_query('user_account', $registrationData, ['account_id' => $userId]);
                    
                    // ============================================
                    // LOG - User Updated
                    // ============================================
                    logActivity([
                        'user_id' => $userId,
                        'user_email' => $email,
                        'user_name' => $registrationData['student_name'],
                        'activity_type' => 'registration',
                        'activity_status' => 'success',
                        'details' => 'User profile updated - Registration type: ' . $registrationType
                    ]);
                } else {
                    // Insert new user
                    $userId = $commanmodel->insert_query_get_inserid('user_account', $registrationData);
                    
                    // ============================================
                    // LOG - New User Registration
                    // ============================================
                    logActivity([
                        'user_id' => $userId,
                        'user_email' => $email,
                        'user_name' => $registrationData['student_name'],
                        'activity_type' => 'registration',
                        'activity_status' => 'success',
                        'details' => 'New user registered - Registration type: ' . $registrationType . ', Competition type: ' . $competitionType
                    ]);
                }

                if ($userId) {
                    
                    // ============================================
                    // Save Competition Registrations
                    // ============================================
                    $competitionIds = [];
                    $selectedCompetitionsArray = [];
                    
                    if ($registrationType == 'with_competition') {
                        // Ensure selectedCompetitions is an array
                        if (is_string($selectedCompetitions)) {
                            $selectedCompetitionsArray = explode(',', $selectedCompetitions);
                        } else {
                            $selectedCompetitionsArray = $selectedCompetitions;
                        }
                        
                        // Debug: Log the competitions
                        log_message('debug', 'Selected Competitions: ' . print_r($selectedCompetitionsArray, true));
                        
                        foreach ($selectedCompetitionsArray as $competition) {
                            // Parse competition name and price
                            preg_match('/^(.*?)\s*[-:]\s*([\d.]+)$/', $competition, $matches);
                            $competitionName = trim($matches[1] ?? $competition);
                            $competitionPrice = floatval($matches[2] ?? 0);
                            
                            // Get competition ID from competitions table
                            $competitionRecord = $commanmodel->get_single_query(
                                'competitions', 
                                ['title' => $competitionName]
                            );
                            
                            $competitionId = $competitionRecord ? $competitionRecord->id : null;
                            
                            // Insert into competition_registrations
                            $compRegData = [
                                'account_id' => $userId,
                                'competition_id' => $competitionId,
                                'competition_name' => $competitionName,
                                'competition_price' => $totalAmount ?? 0,
                                'competition_type' => $competitionType,
                                'registration_status' => 'pending',
                                'competition_school_id' => $this->request->getVar('school_name'),
                                'payment_status' => ($totalAmount > 0) ? 'pending' : 'completed',
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ];
                            
                            $compRegId = $commanmodel->insert_query_get_inserid('competition_registrations', $compRegData);
                            $competitionIds[] = $compRegId;
                            
                            // ============================================
                            // LOG - Competition Registration
                            // ============================================
                            logActivity([
                                'user_id' => $userId,
                                'user_email' => $email,
                                'user_name' => $registrationData['student_name'],
                                'activity_type' => 'competition_registration',
                                'activity_status' => 'pending',
                                'details' => 'Competition registered: ' . $competitionName . ' - Price: ' . $competitionPrice
                            ]);
                        }
                    }

                    // ============================================
                    // Commit Transaction
                    // ============================================
                    $db->transCommit();

                    // ============================================
                    // Store User Data in Session
                    // ============================================
                    $session->set('loggedin', [
                        'user_id' => $userId,
                        'user_name' => $registrationData['student_name'],
                        'user_email' => $registrationData['user_email'],
                        'user_phone' => $registrationData['user_phone'],
                        'user_type' => 1,
                    ]);

                    // ============================================
                    // Send Email Notification
                    // ============================================
                    try {
                        if ($registrationType == 'with_competition') {
                            $this->sendRegistrationEmail($registrationData, $selectedCompetitionsArray);
                        } else {
                            $this->sendSimpleRegistrationEmail($registrationData);
                        }
                    } catch (\Exception $e) {
                        log_message('error', 'Email sending failed: ' . $e->getMessage());
                        
                        // LOG - Email Failed
                        logActivity([
                            'user_id' => $userId,
                            'user_email' => $email,
                            'activity_type' => 'email',
                            'activity_status' => 'failed',
                            'details' => 'Email sending failed: ' . $e->getMessage()
                        ]);
                    }

                    // ============================================
                    // Create Razorpay Order if Amount > 0
                    // ============================================
                    if ($totalAmount > 0) {
                        $razorpayData = $this->createRazorpayOrder($userId, $totalAmount, $competitionType);

                        if ($razorpayData['success']) {
                            $array = [
                                'success' => true,
                                'razorpay_order_id' => $razorpayData['order_id'],
                                'razorpay_key_id' => $razorpayData['key_id'],
                                'amount' => $razorpayData['amount'] * 100,
                                'currency' => $razorpayData['currency'],
                                'user_id' => $userId,
                                'student_name' => $registrationData['student_name'],
                                'email_register' => $registrationData['user_email'],
                                'phone_register' => $registrationData['user_phone'],
                                'message' => 'Registration created. Please complete payment.'
                            ];
                        } else {
                            // LOG - Razorpay Error
                            logActivity([
                                'user_id' => $userId,
                                'user_email' => $email,
                                'activity_type' => 'payment',
                                'activity_status' => 'failed',
                                'details' => 'Razorpay order creation failed: ' . $razorpayData['message']
                            ]);
                            
                            $array = [
                                'success' => false,
                                'message' => 'Registration created but payment gateway error: ' . $razorpayData['message']
                            ];
                        }
                    } else {
                        // ============================================
                        // Free Registration - Update Status
                        // ============================================
                        if ($registrationType == 'with_competition') {
                            $commanmodel->update_query(
                                'competition_registrations', 
                                ['registration_status' => 'confirmed', 'payment_status' => 'completed'], 
                                ['account_id' => $userId]
                            );
                        }
                        $commanmodel->update_query('user_account', ['payment_status' => 'completed'], ['account_id' => $userId]);

                        $array = [
                            'success' => true,
                            'message' => 'Registration successful! No payment required.'
                        ];
                    }
                } else {
                    // ============================================
                    // Rollback if User Not Created
                    // ============================================
                    $db->transRollback();
                    
                    // LOG - Registration Failed
                    logActivity([
                        'user_email' => $email,
                        'activity_type' => 'registration',
                        'activity_status' => 'failed',
                        'details' => 'Failed to create user account'
                    ]);
                    
                    $array = [
                        'success' => false,
                        'message' => 'Failed to save registration data.'
                    ];
                }
            } catch (\Exception $e) {
                // ============================================
                // Rollback on Error
                // ============================================
                $db->transRollback();
                log_message('error', 'Registration Error: ' . $e->getMessage());
                log_message('error', 'Stack Trace: ' . $e->getTraceAsString());
                
                // LOG - Registration Error
                logActivity([
                    'user_email' => $email,
                    'activity_type' => 'registration',
                    'activity_status' => 'failed',
                    'details' => 'Registration error: ' . $e->getMessage()
                ]);
                
                $array = [
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ];
            }
        } else {
            // ============================================
            // Validation Errors
            // ============================================
            // LOG - Validation Failed
            logActivity([
                'user_email' => $email,
                'activity_type' => 'registration',
                'activity_status' => 'failed',
                'details' => 'Validation failed: ' . json_encode($validation->getErrors())
            ]);
            
            $array = [
                'success' => false,
                'errors' => $validation->getErrors()
            ];
        }

        echo json_encode($array);
        
    } catch (\Exception $e) {
        log_message('error', 'Fatal Registration Error: ' . $e->getMessage());
        log_message('error', 'Stack Trace: ' . $e->getTraceAsString());
        
        $array = [
            'success' => false,
            'message' => 'System error: ' . $e->getMessage()
        ];
        echo json_encode($array);
    }
}

// ============================================
// Send Simple Registration Email (No Competition)
// ============================================
private function sendSimpleRegistrationEmail($data)
{
    try {
        $to = $data['user_email'];
        $subject = 'Registration Confirmation - Zemsto';
        $from = 'info@yourdomain.com';

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: ' . $from . "\r\n";

        $htmldata = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #4CAF50; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                .footer { background: #f4f4f4; padding: 10px; text-align: center; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Registration Confirmation</h2>
                </div>
                <div class='content'>
                    <p>Dear " . $data['student_name'] . ",</p>
                    <p>Thank you for registering with Zemsto!</p>
                    <p><strong>Registration Details:</strong></p>
                    <ul>
                        <li><strong>Student:</strong> " . $data['student_name'] . "</li>
                        <li><strong>Class:</strong> " . $data['class_grade'] . "</li>
                        <li><strong>School:</strong> " . $data['school_name'] . "</li>
                        <li><strong>Registration Type:</strong> " . ucfirst($data['registration_type']) . "</li>
                    </ul>
                    <p>We will contact you soon with further details.</p>
                    <p>Best Regards,<br>Team Zemsto</p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " Zemsto. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";

        return mail($to, $subject, $htmldata, $headers);
    } catch (\Exception $e) {
        log_message('error', 'Email Error: ' . $e->getMessage());
        return false;
    }
}

// ============================================
// Send Registration Email (With Competition)
// ============================================
private function sendRegistrationEmail($data, $competitions)
{
    try {
        $to = $data['user_email'];
        $subject = 'Registration Confirmation - Competition';
        $from = 'info@yourdomain.com';

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: ' . $from . "\r\n";

        $competitionList = '';
        if (is_array($competitions)) {
            foreach ($competitions as $comp) {
                $competitionList .= "<li>" . htmlspecialchars($comp) . "</li>";
            }
        }

        $currency = ($data['competition_type'] == 'india') ? '₹' : '$';

        $htmldata = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #4CAF50; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                .footer { background: #f4f4f4; padding: 10px; text-align: center; }
                .competition-list { list-style: none; padding: 0; }
                .competition-list li { padding: 8px 12px; background: #f8f9fa; margin-bottom: 5px; border-radius: 5px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Registration Confirmation</h2>
                </div>
                <div class='content'>
                    <p>Dear " . $data['student_name'] . ",</p>
                    <p>Thank you for registering for the competition!</p>
                    <p><strong>Registration Details:</strong></p>
                    <ul>
                        <li><strong>Student:</strong> " . $data['student_name'] . "</li>
                        <li><strong>Class:</strong> " . $data['class_grade'] . "</li>
                        <li><strong>School:</strong> " . $data['school_name'] . "</li>
                        <li><strong>Competition Type:</strong> " . ucfirst($data['competition_type']) . "</li>
                        <li><strong>Total Amount:</strong> " . $currency . $data['total_amount'] . "</li>
                    </ul>
                    <p><strong>Selected Competitions:</strong></p>
                    <ul class='competition-list'>
                        " . $competitionList . "
                    </ul>
                    <p>We will contact you soon with further details.</p>
                    <p>Best Regards,<br>Team Zemsto</p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " Zemsto. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";

        return mail($to, $subject, $htmldata, $headers);
    } catch (\Exception $e) {
        log_message('error', 'Email Error: ' . $e->getMessage());
        return false;
    }
}

// ============================================
// Create Razorpay Order
// ============================================
private function createRazorpayOrder($userId, $amount, $competitionType)
{
    try {
        $currency = ($competitionType == 'india') ? 'INR' : 'USD';
        
        // Razorpay API Keys
        $keyId = getenv('RAZORPAY_KEY_ID') ?: 'rzp_test_qThjo54DWyFKHa';
        $keySecret = getenv('RAZORPAY_KEY_SECRET') ?: 'zRAGwRhizipHqH6wDpeSvNCU';

        // Check if Razorpay API class exists
        if (!class_exists('Razorpay\Api\Api')) {
            throw new \Exception('Razorpay API class not found. Please install Razorpay SDK.');
        }

        // Initialize Razorpay API
        $api = new Api($keyId, $keySecret);

        $orderData = [
            'receipt' => 'reg_' . $userId . '_' . time(),
            'amount' => $amount * 100,
            'currency' => $currency,
            'payment_capture' => 1,
            'notes' => [
                'user_id' => $userId,
                'competition_type' => $competitionType
            ]
        ];

        $razorpayOrder = $api->order->create($orderData);

        // Save order ID in user_account
        $commanmodel = new Commanmodel();
        $commanmodel->update_query('user_account', 
            ['razorpay_order_id' => $razorpayOrder['id']], 
            ['account_id' => $userId]
        );

        return [
            'success' => true,
            'order_id' => $razorpayOrder['id'],
            'key_id' => $keyId,
            'amount' => $amount,
            'currency' => $currency
        ];
    } catch (\Exception $e) {
        log_message('error', 'Razorpay Error: ' . $e->getMessage());
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

// ============================================
// Verify Payment
// ============================================
public function verify_payment()
{
    try {
        $commanmodel = new Commanmodel();
        $paymentId = $this->request->getVar('razorpay_payment_id');
        $orderId = $this->request->getVar('razorpay_order_id');
        $signature = $this->request->getVar('razorpay_signature');
        $userId = $this->request->getVar('user_id');

        $keyId = getenv('RAZORPAY_KEY_ID') ?: 'rzp_test_qThjo54DWyFKHa';
        $keySecret = getenv('RAZORPAY_KEY_SECRET') ?: 'zRAGwRhizipHqH6wDpeSvNCU';

        // Check if Razorpay API class exists
        if (!class_exists('Razorpay\Api\Api')) {
            throw new \Exception('Razorpay API class not found. Please install Razorpay SDK.');
        }

        $api = new Api($keyId, $keySecret);

        // Verify signature
        $attributes = [
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => $orderId,
            'razorpay_signature' => $signature
        ];

        $api->utility->verifyPaymentSignature($attributes);

        // Start transaction
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Update user payment status
            $commanmodel->update_query('user_account', [
                'payment_status' => 'completed',
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
                'updated_at' => date('Y-m-d H:i:s')
            ], ['account_id' => $userId]);

            // Update all competition registrations for this user
            $commanmodel->update_query('competition_registrations', [
                'registration_status' => 'confirmed',
                'payment_status' => 'completed',
                'razorpay_payment_id' => $paymentId,
                'updated_at' => date('Y-m-d H:i:s')
            ], ['account_id' => $userId]);

            $db->transCommit();

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Payment verified successfully'
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Payment Verification DB Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    } catch (\Exception $e) {
        log_message('error', 'Payment Verification Error: ' . $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}


   public function login_process()
{
    $session = session();
    $commanmodel = new Commanmodel();
    helper(['form', 'url', 'log_helper']);
    $validation = \Config\Services::validation();

    if ($this->request->getVar('user_login') == "Login") {
        $rules = [
            'login_email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Please enter email',
                    'valid_email' => 'Please enter a valid email address'
                ],
            ],
            'login_password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[16]',
                'errors' => [
                    'required' => 'Please enter password',
                    'min_length' => 'Password min length 6!',
                    'max_length' => 'Password max length 16!',
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $email = $this->request->getVar('login_email');
            $password = $this->request->getVar('login_password');

            // Get user by email
            $checknumber = $commanmodel->get_single_query('user_account', ['user_email' => $email]);

            if ($checknumber) {
                $pass = $checknumber->user_password;
                $authenticatePassword = password_verify($password, $pass);

                if ($authenticatePassword) {
                    // Login successful
                    $loginData = [
                        'user_id' => $checknumber->account_id,
                        'user_name' => $checknumber->user_name,
                        'user_phone' => $checknumber->user_phone,
                        'user_email' => $checknumber->user_email,
                        'user_type' => $checknumber->user_type,
                    ];

                    $session->set('loggedin', $loginData);

                    // ============================================
                    // LOG SUCCESSFUL LOGIN
                    // ============================================
                    logActivity([
                        'user_id' => $checknumber->account_id,
                        'user_email' => $checknumber->user_email,
                        'user_name' => $checknumber->user_name,
                        'activity_type' => 'login',
                        'activity_status' => 'success',
                        'details' => 'User logged in successfully from ' . get_ip_address()
                    ]);

                    $array = [
                        'success' => true,
                        "title" => 'Success',
                        "class" => 'success',
                        "message" => 'Welcome back! You\'re now logged in. Enjoy your experience!'
                    ];
                } else {
                    // ============================================
                    // LOG FAILED LOGIN - Wrong Password
                    // ============================================
                    logActivity([
                        'user_email' => $email,
                        'user_name' => $checknumber->user_name ?? 'Unknown',
                        'activity_type' => 'login',
                        'activity_status' => 'failed',
                        'details' => 'Login failed - Incorrect password for email: ' . $email . ' from IP: ' . get_ip_address()
                    ]);

                    $array = [
                        'success' => false,
                        "title" => 'Warning',
                        "class" => 'warning',
                        "message" => 'The username and password do not match'
                    ];
                }
            } else {
                // ============================================
                // LOG FAILED LOGIN - User Not Found
                // ============================================
                logActivity([
                    'user_email' => $email,
                    'activity_type' => 'login',
                    'activity_status' => 'failed',
                    'details' => 'Login failed - User not found with email: ' . $email . ' from IP: ' . get_ip_address()
                ]);

                $array = [
                    'success' => false,
                    "title" => 'Warning',
                    "class" => 'warning',
                    "message" => 'The username and password do not match'
                ];
            }
        } else {
            // Validation errors
            $array = [
                'error_user' => true,
                'login_email_error' => $validation->getError('login_email'),
                'login_password_error' => $validation->getError('login_password'),
            ];
        }
    } else {
        $array = [
            'success' => false,
            "title" => 'Warning',
            "class" => 'warning',
            "message" => 'Please fill all mandatory fields'
        ];
    }

    echo json_encode($array);
}
    
      public function chack_sing_in()
    {
         $session = session();
        if ($session->has('loggedin')) {
            
               
                    
                     $redirectUrl = session()->get('redirect_url');
        
        if ($redirectUrl) {
            $url = $redirectUrl;
        } else {
           $url = base_url('dashboard');
        }
            
               $array = array(
            
         
             'success' => true,
              'url' => $url,
            );
        } else {
                $array = array(
            
         
             'success' => false,
            );
        }
        echo json_encode($array); 
    }
    
public function logout()
{
    try {
        $session = session();
        helper(['log_helper']); // Load log helper
        
        // Get user data before destroying session
        $userData = $session->get('loggedin');
        
        // ============================================
        // LOG - User Logout
        // ============================================
        if ($userData && is_array($userData)) {
            logActivity([
                'user_id' => $userData['user_id'] ?? null,
                'user_email' => $userData['user_email'] ?? null,
                'user_name' => $userData['user_name'] ?? null,
                'activity_type' => 'logout',
                'activity_status' => 'success',
                'details' => 'User logged out successfully from IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown')
            ]);
        }
        
        // Clear all session data
        $session->destroy();
        
        // Set flash message
        $session->setFlashdata('success', 'You have been logged out successfully.');
        
        // Redirect to home page with message
        return redirect()->to('/')->with('message', 'Logged out successfully');
        
    } catch (\Exception $e) {
        // Log error
        log_message('error', 'Logout Error: ' . $e->getMessage());
        
        // Destroy session anyway
        $session = session();
        $session->destroy();
        
        // Redirect to home
        return redirect()->to('/');
    }
}
        public function blog_list($page)
{
    

    
 

   
    $Blogmodel = new Blogmodel();
    
     $pager = service('pager');
    
    $perPage = 10;
    $total = $Blogmodel->count_all_frontend();
    $segment = $this->request->uri->getSegment(2);
    
    // Set the base URL and segment for pagination links.
    $pager->setPath(base_url('blog'), $segment);
   
    // Generate pagination links using the makeLinks() method.
    $pager_links = $pager->makeLinks($page, $perPage, $total, 'foundation_full');

    $start = ($page - 1) * $perPage;
    
    $output = [
        'item_total' =>$total.' tours found',
        'pagination_link' => $pager_links,
        'product_list' => $Blogmodel->fetch_data($perPage, $start)
    ];
    
    echo json_encode($output);


}

public function cart()
    {
         $commanmodel = new Commanmodel();
         $data = array(
           
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
           
            );
            
            
               $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 9));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
         return view('frontend/header',$data).view('frontend/cart').view('frontend/footer');
    }
    
    public function checkout()
    {
         $commanmodel = new Commanmodel();
         $data = array(
            'title' => "contact us : Rent House", 
            'keyword' => "Home : Rent House",
            'description' => "Home : Rent House",
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 10));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
         return view('frontend/header',$data).view('frontend/checkout').view('frontend/footer');
    }
    
    
     public function wishlist()
    {   $session = session();
          $commanmodel = new Commanmodel();
           $usersession = $session->get('loggedin');
                        $userId = $usersession['user_id'];
              
        $wishlist = $commanmodel->all_multiple_query_order_by('wishlist',array('wishlist_user_id' =>$userId),'wishlist_id','ASC'); 
         $data = array(
        
            'search' => '',
             'wishlist' => $wishlist,
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 11));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_image);
            
         return view('frontend/header',$data).view('frontend/wishlist').view('frontend/footer');
    }
    
     public function send()
    {
        $request = service('request');
        $email = \Config\Services::email();

        $fullname = $request->getPost('fullname');
        $phone = $request->getPost('phone');
        $userEmail = $request->getPost('email');
        $sabject = $request->getPost('sabject');
        $message = $request->getPost('message');

        // Email
        $email->setTo("r.sharma@starwebmaker.com");
        $email->setFrom("no-reply@ase-electrical.co.uk", "Website Contact");
        $email->setSubject("New Contact Form Submission");

        $htmlMessage = "
        <h2>New Contact Form Submission</h2>
        <p><strong>Name:</strong> {$fullname}</p>
        <p><strong>Email:</strong> {$userEmail}</p>
        <p><strong>Phone:</strong> {$phone}</p>
          <p><strong>sabject:</strong> {$sabject}</p>
        <p><strong>Message:</strong><br>" . nl2br($message) . "</p>
        ";

        $email->setMailType("html");
        $email->setMessage($htmlMessage);

        if($email->send()){
            return $this->response->setJSON(['status'=>'success']);
        } else {
            return $this->response->setJSON(['status'=>'error','message'=>$email->printDebugger(['headers'])]);
        }
    }
function enquirysend(){
       $session = session();
  
         $commanmodel = new Commanmodel();
         $request = service('request');
     

 
    $data = array( 
    'enquiry_name' => $this->request->getVar('name'),
    'enquiry_phone' => $this->request->getVar('phone'),
     'enquiry_email' => $this->request->getVar('email'),
      'enquiry_pro_id' => $this->request->getVar('pro_id'),
        'enquiry_vender' => $this->request->getVar('vender'),
    'enquiry_message' => $this->request->getVar('message')

    
    
  
        );
    $Inserted=$commanmodel->insert_query('enquiry',$data);
        $response = [
"title" => 'Enquiry Sent',
"class" => 'success',
"message" => 'Your enquiry has been Sent successfully'

];
    
    echo json_encode($response);
  
   }
   
   
   public function pages($sulg)
    {
         $commanmodel = new Commanmodel();
         $pages =$commanmodel->get_single_query('cms_pages',array('cms_slug'=> $sulg));
         $data = array(
            'title' => $pages->cms_page_name, 
            'keyword' => "",
            'description' => "",
            'search' => '',
          'pages' => $pages,
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
         return view('frontend/header',$data).view('frontend/pages').view('frontend/footer');
    }
    
 
 public function forgotPassword()
    { $data = array(
            'title' => "contact us : Rent House", 
            'keyword' => "Home : Rent House",
            'description' => "Home : Rent House",
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
      
         return view('frontend/header',$data).view('frontend/forgot_password').view('frontend/footer');
    }

    public function sendResetLink()
    {
        
         $commanmodel = new Commanmodel();
        // Form se email address lene ka process
        $email = $this->request->getPost('email');
        
        // Validate email address
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Invalid email address!');
        }
        
       
     
$user = $commanmodel->get_single_query('user_account',array('user_email'=> $email));
        if ($user) {
            // Token generate karein
            $token = bin2hex(random_bytes(50));
            
            // User record mein token aur expiry time save karein
            $expiryTime = new Time('now');
            $expiryTime = $expiryTime->addHours(1); // Token 1 ghante ke liye valid hoga
            
       
$updated=$commanmodel->update_query('user_account',[
                'reset_token' => $token,
                'reset_token_expiry' => $expiryTime->toDateTimeString()
            ],array('account_id'=>$user->account_id));
            // Reset link create karein
            $resetLink = site_url('auth/resetPassword/' . $token);

            // Email send karein
            $emailService = \Config\Services::email();
               $emailService->setFrom('no-reply@ase-electrical.co.uk', 'CallLouder');
   
            $emailService->setTo($email);
            $emailService->setSubject('Password Reset Link');
            $emailService->setMessage('Click on this link to reset your password: ' . $resetLink);
            $emailService->send();

            return redirect()->back()->with('message', 'Password reset link sent to your email.');
        } else {
            return redirect()->back()->with('error', 'No user found with that email.');
        }
    }

    public function resetPassword($token)
    {
          $commanmodel = new Commanmodel();
        $data = array(
            'title' => "contact us : Rent House", 
            'keyword' => "Home : Rent House",
            'description' => "Home : Rent House",
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
        // Token ko validate karein
   

        
        $user = $commanmodel->get_single_query('user_account',array('reset_token'=> $token));

        if ($user && new Time('now') < new Time($user->reset_token_expiry)) {
      
             return view('frontend/header',$data).view('frontend/reset_password', ['token' => $token]).view('frontend/footer');
        } else {
            return redirect()->to('/login')->with('error', 'Invalid or expired token.');
        }
    }

    public function updatePassword()
    {
          $commanmodel = new Commanmodel();
        $token = $this->request->getPost('token');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Passwords do not match.');
        }

        $user = $commanmodel->get_single_query('user_account',array('reset_token'=> $token));

        if ($user && new Time('now') < new Time($user->reset_token_expiry)) {
            // Password update karein
        
            $updated=$commanmodel->update_query('user_account',[
                'user_password' => password_hash($newPassword, PASSWORD_BCRYPT),
                'reset_token' => null,
                'reset_token_expiry' => null
            ],array('account_id'=>$user->account_id));

            return redirect()->to('/login')->with('message', 'Password successfully updated.');
        } else {
            return redirect()->to('/login')->with('error', 'Invalid or expired token.');
        }
    }
   
}
