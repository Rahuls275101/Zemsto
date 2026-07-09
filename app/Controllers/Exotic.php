<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Exotic extends BaseController
{
    public function index()
    {
        $commanmodel = new \App\Models\Commanmodel();
        $session = session();
        
        if(session()->get('admin_type') == 'Supar Admin') {
            $data['table_name'] = '';
            
            $table_header = [
                ['data' => 'id'],
                ['data' => 'images'],
                ['data' => 'title'],
                ['data' => 'category'],
                ['data' => 'status'],
                ['data' => 'action'],
            ];
            
            $data['table_column'] = json_encode($table_header);
            
            return view('admin/head').view('admin/sidebar').view('admin/exotic',$data).view('admin/footer');
        } else {
            return redirect()->back()->withInput();
        }
    }
    
    public function exotic_list()
    {
        $session = session();
        $commanmodel = new \App\Models\Commanmodel();
        
        $draw = $_POST['draw'] ?? 0;
        $start = $_POST['start'] ?? 0;
        $length = $_POST['length'] ?? 10;
        $searchname = $_POST['searchname'] ?? '';
        
        $filters = [];
        
        if (!empty($searchname)) {
            $filters[] = [
                'column' => 'title',
                'value' => $searchname,
                'type' => 'like',
            ];
        }
        
        $order = null;
        if (!empty($_POST['order'])) {
            $orderColumn = $_POST['order'][0]['column'];
            $orderDirection = $_POST['order'][0]['dir'];
            $order = [
                'column' => 'exotic_id',
                'order' => 'DESC',
            ];
        }
        
        // Get data from table
        $result = $commanmodel->getDataFromTable('exotic_collection', $filters, $order, $length, $start);
        
        $alldata = $result['filteredRecords'];
        $data = [];
        $no = $start + 1;
        $sn = 1;
        
        foreach ($alldata as $alldata_view) {
            $title = '<a href="'.base_url('exotic/'.$alldata_view->url_slug).'" target="_blank">'.$alldata_view->title.'</a>';
            
            $images = '<img class="cat-thumb" src="'.base_url().'/assets/exotic/'.$alldata_view->exotic_image.'" style="width:60px;height:60px;object-fit:cover;">';
            
            $status = '<span class="badge badge-'.$alldata_view->exotic_status_color.'">'.$alldata_view->exotic_status.'</span>';
            
            $action = '<div class="btn-group">
                <button type="button" class="btn btn-outline-'.$alldata_view->exotic_status_color.'">'.$alldata_view->exotic_status.'</button>
                <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                    <span class="sr-only">Info</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item editRecordexotic" href="javascript:void(0);" 
                       data-exotic_id="'.$alldata_view->exotic_id.'" 
                       data-exotic_image="'.$alldata_view->exotic_image.'" 
                       data-title="'.$alldata_view->title.'" 
                       data-category_name="'.$alldata_view->category_name.'" 
                       data-description="'.$alldata_view->description.'" 
                       data-exotic_status="'.$alldata_view->exotic_status.'" 
                       data-is_hero_card="'.$alldata_view->is_hero_card.'" 
                       data-is_wide_card="'.$alldata_view->is_wide_card.'" 
                       data-layout_type="'.$alldata_view->layout_type.'" 
                       data-display_order="'.$alldata_view->display_order.'">
                       Edit
                    </a>
                    <a class="dropdown-item deleteRecordexotic" href="javascript:void(0);" data-exotic_id="'.$alldata_view->exotic_id.'">Delete</a>
                </div>
            </div>';
            
            $data[] = [
                "id" => $sn,
                "images" => $images,
                "title" => $title,
                "category" => $alldata_view->category_name,
                "status" => $status,
                "action" => $action
            ];
            
            $no++;
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
    
    public function exotic_save()
    {
        try {
            $session = session();
            $commanmodel = new \App\Models\Commanmodel();
            
            $status = $this->request->getVar('exotic_status');
            if ($status == 'Active') {
                $status_color = 'success';
            } else {
                $status_color = 'danger';
            }
            
            // Validate main image
            $validated = $this->validate([
                'exotic_image' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[exotic_image]'
                        . '|is_image[exotic_image]'
                        . '|mime_in[exotic_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                ],
            ]);
            
            if ($validated) {
                $file = $this->request->getFile('exotic_image');
                if ($file->isValid() && !$file->hasMoved()) {
                    $exotic_image = $file->getRandomName();
                    $file->move('assets/exotic', $exotic_image);
                } else {
                    $exotic_image = '';
                }
            } else {
                $exotic_image = '';
            }
            
            $title = strip_tags($this->request->getVar('title'));
            $titleURL = strtolower(url_title($title));
            
            // Check if slug exists
            if ($commanmodel->get_url_slug_update('exotic_collection', $titleURL, [])) {
                $titleURL = $titleURL . '-' . time();
            }
            
            $data = [
                'category_name' => $this->request->getVar('category_name'),
                'title' => $title,
                'description' => $this->request->getVar('description'),
                'url_slug' => $titleURL,
                'exotic_image' => $exotic_image,
                'is_hero_card' => $this->request->getVar('is_hero_card') ? 1 : 0,
                'is_wide_card' => $this->request->getVar('is_wide_card') ? 1 : 0,
                'layout_type' => $this->request->getVar('layout_type'),
                'display_order' => $this->request->getVar('display_order') ?: 0,
                'exotic_status' => $status,
                'exotic_status_color' => $status_color,
            ];
            
            $inserted = $commanmodel->insert_query('exotic_collection', $data);
            
            // Handle gallery images
            if ($inserted) {
                $exotic_id = $commanmodel->insertID();
                $gallery_images = $this->request->getFiles('gallery_images');
                
                if (!empty($gallery_images) && isset($gallery_images['gallery_images'])) {
                    $files = $gallery_images['gallery_images'];
                    if (is_array($files)) {
                        foreach ($files as $index => $file) {
                            if ($file->isValid() && !$file->hasMoved()) {
                                $newName = $file->getRandomName();
                                $file->move('assets/exotic/gallery', $newName);
                                $galleryData = [
                                    'exotic_id' => $exotic_id,
                                    'image_path' => 'assets/exotic/gallery/' . $newName,
                                    'display_order' => $index
                                ];
                                $commanmodel->insert_query('exotic_gallery', $galleryData);
                            }
                        }
                    }
                }
            }
            
            echo json_encode(['success' => true, 'message' => 'Collection added successfully']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function exotic_update()
    {
        try {
            $session = session();
            helper(['form', 'url']);
            $commanmodel = new \App\Models\Commanmodel();
            
            $status = $this->request->getVar('edit_exotic_status');
            if ($status == 'Active') {
                $status_color = 'success';
            } else {
                $status_color = 'danger';
            }
            
            // Check if new image is uploaded
            $exotic_image = $this->request->getVar('edit_exotic_image_old');
            $file = $this->request->getFile('edit_exotic_image');
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $validated = $this->validate([
                    'edit_exotic_image' => [
                        'label' => 'Image File',
                        'rules' => 'is_image[edit_exotic_image]'
                            . '|mime_in[edit_exotic_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    ],
                ]);
                
                if ($validated) {
                    // Delete old image if exists
                    if (!empty($exotic_image) && file_exists(FCPATH . 'assets/exotic/' . $exotic_image)) {
                        unlink(FCPATH . 'assets/exotic/' . $exotic_image);
                    }
                    
                    $newImage = $file->getRandomName();
                    $file->move('assets/exotic', $newImage);
                    $exotic_image = $newImage;
                }
            }
            
            $title = strip_tags($this->request->getVar('edit_title'));
            $titleURL = strtolower(url_title($title));
            
            // Check if slug exists (excluding current record)
            if ($commanmodel->get_url_slug_update('exotic_collection', $titleURL, ['exotic_id !=' => $this->request->getVar('edit_exotic_id')])) {
                $titleURL = $titleURL . '-' . time();
            }
            
            $data = [
                'category_name' => $this->request->getVar('edit_category_name'),
                'title' => $title,
                'description' => $this->request->getVar('edit_description'),
                'url_slug' => $titleURL,
                'exotic_image' => $exotic_image,
                'is_hero_card' => $this->request->getVar('edit_is_hero_card') ? 1 : 0,
                'is_wide_card' => $this->request->getVar('edit_is_wide_card') ? 1 : 0,
                'layout_type' => $this->request->getVar('edit_layout_type'),
                'display_order' => $this->request->getVar('edit_display_order') ?: 0,
                'exotic_status' => $status,
                'exotic_status_color' => $status_color,
            ];
            
            $where = ['exotic_id' => $this->request->getVar('edit_exotic_id')];
            $updated = $commanmodel->update_query('exotic_collection', $data, $where);
            
            // Handle gallery images update
            $exotic_id = $this->request->getVar('edit_exotic_id');
            $gallery_images = $this->request->getFiles('edit_gallery_images');
            
            if (!empty($gallery_images) && isset($gallery_images['edit_gallery_images'])) {
                $files = $gallery_images['edit_gallery_images'];
                if (is_array($files) && count($files) > 0 && $files[0]->isValid()) {
                    // Delete existing gallery images from filesystem
        $existingGallery = $commanmodel->all_multiple_query_order_by(
    'exotic_gallery',
    ['exotic_id' => $exotic_id],
    'gallery_id',
    'ASC'
);

if (!empty($existingGallery)) {
    foreach ($existingGallery as $img) {

        if (!empty($img->image_path)) {

            $filePath = FCPATH . ltrim($img->image_path, '/');

            if (is_file($filePath)) {
                unlink($filePath);
            }
        }
    }
}
                    // Delete from database
                    $commanmodel->delete_query('exotic_gallery', ['exotic_id' => $exotic_id]);
                    
                    // Insert new gallery images
                    foreach ($files as $index => $file) {
                        if ($file->isValid() && !$file->hasMoved()) {
                            $newName = $file->getRandomName();
                            $file->move('assets/exotic/gallery', $newName);
                            $galleryData = [
                                'exotic_id' => $exotic_id,
                                'image_path' => 'assets/exotic/gallery/' . $newName,
                                'display_order' => $index
                            ];
                            $commanmodel->insert_query('exotic_gallery', $galleryData);
                        }
                    }
                }
            }
            
            echo json_encode(['success' => true, 'message' => 'Collection updated successfully']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function exotic_delete()
    {
        try {
            $commanmodel = new \App\Models\Commanmodel();
            $exotic_id = $this->request->getVar('exotic_id');
            
            // Get gallery images
            $galleryData = $commanmodel->getDataFromTable('exotic_gallery', ['exotic_id' => $exotic_id]);
            if (!empty($galleryData['filteredRecords'])) {
                foreach ($galleryData['filteredRecords'] as $image) {
                    if (file_exists(FCPATH . $image->image_path)) {
                        unlink(FCPATH . $image->image_path);
                    }
                }
            }
            
            // Get main image
            $mainImageData = $commanmodel->getDataFromTable('exotic_collection', ['exotic_id' => $exotic_id]);
            if (!empty($mainImageData['filteredRecords'])) {
                $mainImage = $mainImageData['filteredRecords'][0];
                if (!empty($mainImage->exotic_image)) {
                    if (file_exists(FCPATH . 'assets/exotic/' . $mainImage->exotic_image)) {
                        unlink(FCPATH . 'assets/exotic/' . $mainImage->exotic_image);
                    }
                }
            }
            
            // Delete from database
            $commanmodel->delete_query('exotic_gallery', ['exotic_id' => $exotic_id]);
            $result = $commanmodel->delete_query('exotic_collection', ['exotic_id' => $exotic_id]);
            
            echo json_encode(['success' => true, 'message' => 'Collection deleted successfully']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
public function exotic_get_gallery_images()
{
    try {
        $commanmodel = new \App\Models\Commanmodel();

        $exotic_id = $this->request->getVar('exotic_id');

        if (empty($exotic_id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Exotic ID is required'
            ]);
        }

        $galleryData = $commanmodel->all_multiple_query_order_by(
            'exotic_gallery',
            ['exotic_id' => $exotic_id],
            'gallery_id',
            'ASC'
        );

        return $this->response->setJSON([
            'success' => true,
            'images'  => $galleryData ?? []
        ]);

    } catch (\Exception $e) {

        return $this->response->setJSON([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}
    
    public function exotic_delete_gallery_image()
    {
        try {
            $commanmodel = new \App\Models\Commanmodel();
            $exotic_id = $this->request->getVar('exotic_id');
            $image_path = $this->request->getVar('image_path');
            
            // Delete from filesystem
            if (file_exists(FCPATH . $image_path)) {
                unlink(FCPATH . $image_path);
            }
            
            // Delete from database
            $result = $commanmodel->delete_query('exotic_gallery', [
                'exotic_id' => $exotic_id,
                'image_path' => $image_path
            ]);
            
            echo json_encode(['success' => true, 'message' => 'Image deleted successfully']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}