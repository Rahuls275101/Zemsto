<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Commanmodel;

class Ajaxlist extends Model
{
    protected $table = 'product';
    protected $column_order = array(null); // set column field database for datatable orderable
    protected $column_search = array('product_name'); // set column field database for datatable searchable
    protected $order = array('product_id' => 'DESC'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
          $this->commanmodel = new Commanmodel();
        // OR $this->db = db_connect();
    }
    
  private function getAllCategoryIds($parentId)
    {
        $ids = [$parentId];

        $children = $this->commanmodel->all_multiple_query_order_by(
            'category',
            ['parent_id' => $parentId],
            'category_id',
            'ASC'
        );

        if (!empty($children)) {
            foreach ($children as $child) {
                $childId = is_array($child) ? $child['category_id'] : $child->category_id;
                $ids[] = $childId;
                $ids = array_merge($ids, $this->getAllCategoryIds($childId));
            }
        }

        return array_unique($ids);
    }
    
private function _get_datatables_query($mainid, $id, $search, $collection, $minprice, $maxprice, $shortby,$allid)
{
  
    // Load the model if not already loaded (ideally should be in constructor)
    $commanmodel = new Commanmodel();

    // Get category IDs
  

    $builder = $this->db->table($this->table);
    $builder->where('product_status', 'Active');
   

   // --- Category Filtering ---
        $allids = [];
        if (!empty($mainid)) {
            $allids = array_merge($allids, $this->getAllCategoryIds((int) $mainid));
        }
        if (!empty($id)) {
            $allids = array_merge($allids, $this->getAllCategoryIds((int) $id));
        }

        $allids = array_unique(array_filter($allids));
        
     



        if (!empty($allids)) {
            $builder->groupStart();
            foreach ($allids as $catId) {
                $builder->orWhere("FIND_IN_SET(" . (int)$catId . ", REPLACE(product_category, ' ', ''))");
              
            }
            $builder->groupEnd();
        } 

    // Collection filter
    if (!empty($collection)) {
        $builder->like('product_collections', $collection);
    }

    // Price range filter
    if (!empty($minprice) && !empty($maxprice)) {
        $builder->where('product_price >=', $minprice)
                ->where('product_price <=', $maxprice);
    }

    // Search functionality
    if (!empty($search) && is_array($this->column_search)) {
        $builder->groupStart();
        foreach ($this->column_search as $i => $item) {
            if ($i === 0) {
                $builder->like($item, $search);
            } else {
                $builder->orLike($item, $search);
            }
        }
        $builder->groupEnd();
    }

    // Sorting
    if (!empty($this->order) && is_array($this->order)) {
        $column = key($this->order);
        $direction = ($shortby == 'newness') ? 'DESC' : current($this->order); // Use DESC for "newness"
        $builder->orderBy($column, $direction);
    }

    return $builder;
}



    public function count_all_frontend($mainid,$id, $search, $collection, $minprice, $maxprice,$shortby,$allid)
    {
        $query = $this->_get_datatables_query($mainid, $id, $search, $collection, $minprice, $maxprice,$shortby,$allid);
        $query = $query->get();
        return $query->getNumRows();
    }

    public function fetch_data($limit, $start,$mainid, $id, $search, $collection, $minprice, $maxprice,$shortby,$allid)
    {
        $commanmodel = new Commanmodel();
        $query = $this->_get_datatables_query($mainid, $id, $search, $collection, $minprice, $maxprice,$shortby,$allid);

        if ($limit != -1) {
            $query->limit($limit, $start);
        }
        $query = $query->get();

        $output = '';
        $headoutput = '';
        if ($query->getNumRows() > 0) {
            $sn = 1;
            foreach ($query->getResult() as $resultsrow) {
                 $pro_variant = $commanmodel->all_multiple_query_order_by('pro_variant',array('variant_pro_id' => $resultsrow->product_id),'pro_variant_id','ASC');
                    
                     $variant =  ($pro_variant)?$pro_variant[0]->varian:'';

                 $variant_yes =  ($pro_variant)?'Yes':'No';
            
            
 
                          $output .= '         <div class="col-md-3">
            <div class="product-wrapper" style="margin-bottom:40px">
              <div class="product-img"> <a href="' . base_url('/book-details/') . '/' . $resultsrow->slug . '"> 
              <img src="' . base_url('/assets/images') . '/' . $resultsrow->product_thumbnail . '" alt="' . $resultsrow->product_name . '" class="primary" /> </a>
                <div class="quick-view"> <a class="action-view" href="' . base_url('/book-details/') . '/' . $resultsrow->slug . '" title="Quick View"> <i class="fa fa-search-plus"></i> </a> </div>
           
              </div>
              <div class="product-details text-center">
                <h4><a href="' . base_url('/book-details/') . '/' . $resultsrow->slug . '">' . $resultsrow->product_name . '</a></h4>
                <div class="product-price">
                  <ul>
                    <li>₹ '.$resultsrow->product_price.'</li>
                  </ul>
                </div>
              </div>
              <div class="product-link">
                <div class="product-button"> <a href="#" title="Add to cart" class="AddToCart" data-product-id="'.$resultsrow->product_id.'" data-variant ="'.$variant.'" data-qty="'. $resultsrow->quantity.'" data-variant-yes="'.$variant_yes.'"><i class="fa fa-shopping-cart"></i>Add to cart</a> </div>
                <div class="add-to-link">
                  <ul>
                    <li><a href="' . base_url('/book-details/') . '/' . $resultsrow->slug . '" title="Details"><i class="fa fa-external-link"></i></a></li>
                  </ul>
                </div>
              </div>
            </div></div>     
                     
                ';
            
            
            
            
                
                
            }
        } else {
            $output = '<div class="col-md-12 col-xl-12 mb-3 mb-md-4 pb-1" style="text-align: center;"> <h3>Upcoming book </h3></div>';
        }

        return array( 'output' =>$output,'headoutput' =>'');
    }
}
