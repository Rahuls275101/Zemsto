<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Commanmodel;
class Blogmodel extends Model{




    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
    }
    var $table = 'blogs';
    var $column_order = array(null); //set column field database for datatable orderable
    var $column_search = array(); //set column field database for datatable searchable 
    var $order = array('blog_id' => 'DESC'); // default order 



 function _get_datatables_query()
 {
     
     
       $builder = $this->db->table($this->table);  
  

      
     $commanmodel = new Commanmodel();
    
     
     
     
     
     
      
     $i = 0;
foreach ($this->column_search as $item) // loop column 
{
    if($_POST['search']['value']) // if datatable send POST for search
    {
        if($i===0) // first loop
        {
            $builder->groupStart(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
            $builder->like($item, $_POST['search']['value']);
        }
        else
        {
            $builder->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search) - 1 == $i) //last loop
            $builder->groupEnd(); //close bracket
    }
    $i++;
}

    if(isset($_POST['order'])) // here order processing
    {
        $builder->orderBy($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } 
    else if(isset($this->order))
    {
        $order = $this->order;
        $builder->orderBy(key($order), $order[key($order)]);
    }

       return $builder;

  
 }

 function count_all_frontend()
 {
  
    $query = $this->_get_datatables_query();
        $query = $query->get();
        return $query->getNumRows();
 }

      
 function fetch_data($limit, $start)
 { $commanmodel = new Commanmodel();
       $query = $this->_get_datatables_query();

        if($limit != -1)
        $query->limit($limit, $start);
        $query = $query->get();
        $query->getResult();
     
     

  $output = '';
  if($query->getNumRows() > 0)
  {
   foreach($query->getResult() as $resultsrow)
   {
       
    $commanmodel = new Commanmodel();
  


    $output .= '      <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s">
        <div class="news-card-items mt-0">
          <div class="news-image"> <img src="'.base_url('assets/blog/').'/'.$resultsrow->blog_image.'" alt="'.$resultsrow->blog_name.'">
            <div class="news-layer-wrapper">
              <div class="news-layer-image" style="background-image: url('.base_url('assets/blog/').'/'.$resultsrow->blog_image.');"></div>
              <div class="news-layer-image" style="background-image: url('.base_url('assets/blog/').'/'.$resultsrow->blog_image.');"></div>
              <div class="news-layer-image" style="background-image: url('.base_url('assets/blog/').'/'.$resultsrow->blog_image.');"></div>
              <div class="news-layer-image" style="background-image: url('.base_url('assets/blog/').'/'.$resultsrow->blog_image.');"></div>
            </div>
          </div>
          <div class="news-content"> 
            <h2> <a href="'.base_url('blog-detail/').'/'.$resultsrow->url_slug.'" class="underline">'.$resultsrow->blog_name.'</a> </h2>
            <p>'.$resultsrow->blog_small_description.'</p>
            <ul class="author-items">
              <li><i class="far fa-user"></i> Admin</li>
              <li class="calendar"><i class="far fa-calendar-alt"></i> '. date('Y-m-d', strtotime($resultsrow->date_time)).'</li>
            </ul>
          </div>
        </div>
      </div>
    

     
    
    
 '; 
   }
  }
  else
  {
   $output = '<div class="col-md-12 col-xl-12 mb-3 mb-md-4 pb-1" style="text-align: center;"> <h3>No result found!</h3></div>';
  }

  
  return $output;
 }




}