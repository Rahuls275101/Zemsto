<?php

namespace App\Controllers;

use App\Models\Commanmodel;

class OlympiadController extends BaseController
{
    public function index()
    {
        $session = session();
        if(session()->get('admin_type')=='Supar Admin' or session()->get('admin_type')=='Promoter' or session()->get('admin_type')=='Franchise') {
            
            $data['table_name'] = 'olympiads';
    
            $table_header = [
                ['data' => 'id'],
                ['data' => 'image'],
                ['data' => 'icon'],
                ['data' => 'title'],
                ['data' => 'description'],
                ['data' => 'price_indian'],
                ['data' => 'price_international'],
                ['data' => 'status'],
                ['data' => 'action'],
            ];
            
            $data['table_column'] = json_encode($table_header);
         
            return view('admin/head')
                . view('admin/sidebar')
                . view('admin/olympiads', $data)
                . view('admin/footer');
        } else {
            $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
            return redirect()->back()->withInput();
        }
    }

    public function olympiad_list()
    {
        $session = session();
        $commanmodel = new Commanmodel();

        $draw = $_POST['draw'];
        $start = $_POST['start'];
        $length = $_POST['length'];
        $search = $_POST['search']['value'];
        
        $filters = [];

        if (!empty($search)) {
            $filters[] = [
                'column' => 'title',
                'value' => $search,
                'type' => 'like',
            ];
        }

        $order = ['column' => 'id', 'order' => 'DESC'];

        $result = $commanmodel->getDataFromTable('olympiads', $filters, $order, $length, $start);

        $alldata = $result['filteredRecords'];
        $data = [];
        $sn = $start + 1;

        foreach ($alldata as $olympiad) {
            $image = '<img src="' . base_url('uploads/olympiads/images/' . $olympiad->image) . '" alt="' . $olympiad->title . '" style="width:60px; height:60px; object-fit:cover; border-radius:5px;">';
            $icon = '<img src="' . base_url('uploads/olympiads/icons/' . $olympiad->icon) . '" alt="icon" style="width:40px; height:40px;">';
            
            $priceIndian = '₹' . number_format($olympiad->price_indian, 2);
            $priceInternational = '$' . number_format($olympiad->price_international, 2);
            
            $status_badge = '<span class="badge badge-' . ($olympiad->status == 'Active' ? 'success' : 'danger') . '">' . $olympiad->status . '</span>';
            
            $action = '<button type="button" class="btn btn-primary btn-sm edit-btn" 
                                data-id="' . $olympiad->id . '" 
                                data-title="' . $olympiad->title . '" 
                                data-description="' . htmlspecialchars($olympiad->description) . '" 
                                data-status="' . $olympiad->status . '" 
                                data-image="' . $olympiad->image . '"
                                data-icon="' . $olympiad->icon . '"
                                data-icon_bg="' . $olympiad->icon_bg . '"
                                data-price_indian="' . $olympiad->price_indian . '"
                                data-price_international="' . $olympiad->price_international . '"
                                data-currency_indian="' . $olympiad->currency_indian . '"
                                data-currency_international="' . $olympiad->currency_international . '">
                                <i class="mdi mdi-pencil"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $olympiad->id . '">
                                <i class="mdi mdi-delete"></i> Delete
                            </button>';

            $data[] = [
                "id" => $sn,
                "image" => $image,
                "icon" => $icon,
                "title" => $olympiad->title,
                "description" => substr($olympiad->description, 0, 80) . (strlen($olympiad->description) > 80 ? '...' : ''),
                "price_indian" => $priceIndian,
                "price_international" => $priceInternational,
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

    public function add_olympiad()
    {
        $session = session();
        if(session()->get('admin_type')=='Supar Admin' or session()->get('admin_type')=='Promoter' or session()->get('admin_type')=='Franchise') {
            
            $commanmodel = new Commanmodel();
            helper(['form', 'url']);
            $validation = \Config\Services::validation();
            
            $rules = [
                'title' => [
                    'label' => 'Title',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter olympiad title'],
                ],
                'description' => [
                    'label' => 'Description',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter description'],
                ],
                'price_indian' => [
                    'label' => 'Indian Price',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'Please enter Indian price',
                        'numeric' => 'Price must be a number'
                    ],
                ],
                'price_international' => [
                    'label' => 'International Price',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'Please enter International price',
                        'numeric' => 'Price must be a number'
                    ],
                ],
                'image' => [
                    'label' => 'Image',
                    'rules' => 'uploaded[image]|is_image[image]|max_size[image,2048]',
                    'errors' => [
                        'uploaded' => 'Please select an image',
                        'is_image' => 'Please select a valid image file',
                        'max_size' => 'Image size should not exceed 2MB'
                    ],
                ],
                'icon' => [
                    'label' => 'Icon',
                    'rules' => 'uploaded[icon]|is_image[icon]|max_size[icon,1024]',
                    'errors' => [
                        'uploaded' => 'Please select an icon',
                        'is_image' => 'Please select a valid icon file',
                        'max_size' => 'Icon size should not exceed 1MB'
                    ],
                ],
                'icon_bg' => [
                    'label' => 'Icon Background',
                    'rules' => 'uploaded[icon_bg]|is_image[icon_bg]|max_size[icon_bg,1024]',
                    'errors' => [
                        'uploaded' => 'Please select an icon background',
                        'is_image' => 'Please select a valid icon background file',
                        'max_size' => 'Icon background size should not exceed 1MB'
                    ],
                ],
            ];

            if($this->validate($rules)) {
                // Upload Image
                $imageFile = $this->request->getFile('image');
                $imageName = '';
                if($imageFile->isValid() && !$imageFile->hasMoved()) {
                    $imageName = $imageFile->getRandomName();
                    $imageFile->move('uploads/olympiads/images/', $imageName);
                }
                
                // Upload Icon
                $iconFile = $this->request->getFile('icon');
                $iconName = '';
                if($iconFile->isValid() && !$iconFile->hasMoved()) {
                    $iconName = $iconFile->getRandomName();
                    $iconFile->move('uploads/olympiads/icons/', $iconName);
                }
                
                // Upload Icon Background
                $iconBgFile = $this->request->getFile('icon_bg');
                $iconBgName = '';
                if($iconBgFile->isValid() && !$iconBgFile->hasMoved()) {
                    $iconBgName = $iconBgFile->getRandomName();
                    $iconBgFile->move('uploads/olympiads/icon_bg/', $iconBgName);
                }
                
                $postData = array(
                    'title' => $this->request->getVar('title'),
                    'description' => $this->request->getVar('description'),
                    'price_indian' => $this->request->getVar('price_indian'),
                    'price_international' => $this->request->getVar('price_international'),
                    'currency_indian' => $this->request->getVar('currency_indian') ?: '₹',
                    'currency_international' => $this->request->getVar('currency_international') ?: '$',
                    'image' => $imageName,
                    'icon' => $iconName,
                    'icon_bg' => $iconBgName,
                    'status' => $this->request->getVar('status'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                
                $insertid = $commanmodel->insert_query_get_inserid('olympiads', $postData);
                
                if($insertid) {
                    $session->setFlashdata('created', 'Olympiad added successfully!');
                    return redirect()->to('/admin/olympiads');
                } else {
                    $session->setFlashdata('failed', 'Failed to add olympiad.');
                    return redirect()->to('/admin/olympiads');
                }
            } else {
                $session->setFlashdata('failed', $validation->getErrors());
                return redirect()->to('/admin/olympiads');
            }
        } else {
            $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
            return redirect()->back()->withInput();
        }
    }

    public function update_olympiad()
    {
        $session = session();
        if(session()->get('admin_type')=='Supar Admin' or session()->get('admin_type')=='Promoter' or session()->get('admin_type')=='Franchise') {
            
            $commanmodel = new Commanmodel();
            helper(['form', 'url']);
            $validation = \Config\Services::validation();
            
            $id = $this->request->getVar('id');
            
            $rules = [
                'title' => [
                    'label' => 'Title',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter olympiad title'],
                ],
                'description' => [
                    'label' => 'Description',
                    'rules' => 'required',
                    'errors' => ['required' => 'Please enter description'],
                ],
                'price_indian' => [
                    'label' => 'Indian Price',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'Please enter Indian price',
                        'numeric' => 'Price must be a number'
                    ],
                ],
                'price_international' => [
                    'label' => 'International Price',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'Please enter International price',
                        'numeric' => 'Price must be a number'
                    ],
                ],
            ];

            if($this->validate($rules)) {
                $postData = array(
                    'title' => $this->request->getVar('title'),
                    'description' => $this->request->getVar('description'),
                    'price_indian' => $this->request->getVar('price_indian'),
                    'price_international' => $this->request->getVar('price_international'),
                    'currency_indian' => $this->request->getVar('currency_indian') ?: '₹',
                    'currency_international' => $this->request->getVar('currency_international') ?: '$',
                    'status' => $this->request->getVar('status'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                
                // Get old data to delete old files
                $oldOlympiad = $commanmodel->get_single_query('olympiads', ['id' => $id]);
                
                // Upload Image if new
                $imageFile = $this->request->getFile('image');
                if($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                    if($oldOlympiad->image && file_exists('uploads/olympiads/images/' . $oldOlympiad->image)) {
                        unlink('uploads/olympiads/images/' . $oldOlympiad->image);
                    }
                    $imageName = $imageFile->getRandomName();
                    $imageFile->move('uploads/olympiads/images/', $imageName);
                    $postData['image'] = $imageName;
                }
                
                // Upload Icon if new
                $iconFile = $this->request->getFile('icon');
                if($iconFile && $iconFile->isValid() && !$iconFile->hasMoved()) {
                    if($oldOlympiad->icon && file_exists('uploads/olympiads/icons/' . $oldOlympiad->icon)) {
                        unlink('uploads/olympiads/icons/' . $oldOlympiad->icon);
                    }
                    $iconName = $iconFile->getRandomName();
                    $iconFile->move('uploads/olympiads/icons/', $iconName);
                    $postData['icon'] = $iconName;
                }
                
                // Upload Icon Background if new
                $iconBgFile = $this->request->getFile('icon_bg');
                if($iconBgFile && $iconBgFile->isValid() && !$iconBgFile->hasMoved()) {
                    if($oldOlympiad->icon_bg && file_exists('uploads/olympiads/icon_bg/' . $oldOlympiad->icon_bg)) {
                        unlink('uploads/olympiads/icon_bg/' . $oldOlympiad->icon_bg);
                    }
                    $iconBgName = $iconBgFile->getRandomName();
                    $iconBgFile->move('uploads/olympiads/icon_bg/', $iconBgName);
                    $postData['icon_bg'] = $iconBgName;
                }
                
                $where_data = ['id' => $id];
                $update = $commanmodel->update_query('olympiads', $postData, $where_data);
                
                if($update) {
                    $session->setFlashdata('created', 'Olympiad updated successfully!');
                    return redirect()->to('/admin/olympiads');
                } else {
                    $session->setFlashdata('failed', 'Failed to update olympiad.');
                    return redirect()->to('/admin/olympiads');
                }
            } else {
                $session->setFlashdata('failed', $validation->getErrors());
                return redirect()->to('/admin/olympiads');
            }
        } else {
            $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
            return redirect()->back()->withInput();
        }
    }

    public function delete_olympiad()
    {
        $session = session();
        if(session()->get('admin_type')=='Supar Admin' or session()->get('admin_type')=='Promoter' or session()->get('admin_type')=='Franchise') {
            
            $commanmodel = new Commanmodel();
            $id = $this->request->getVar('id');
            
            // Get olympiad data to delete files
            $olympiad = $commanmodel->get_single_query('olympiads', ['id' => $id]);
            
            // Delete image
            if($olympiad->image && file_exists('uploads/olympiads/images/' . $olympiad->image)) {
                unlink('uploads/olympiads/images/' . $olympiad->image);
            }
            
            // Delete icon
            if($olympiad->icon && file_exists('uploads/olympiads/icons/' . $olympiad->icon)) {
                unlink('uploads/olympiads/icons/' . $olympiad->icon);
            }
            
            // Delete icon background
            if($olympiad->icon_bg && file_exists('uploads/olympiads/icon_bg/' . $olympiad->icon_bg)) {
                unlink('uploads/olympiads/icon_bg/' . $olympiad->icon_bg);
            }
            
            $delete = $commanmodel->delete_query('olympiads', ['id' => $id]);
            
            if($delete) {
                echo json_encode(['success' => true, 'message' => 'Olympiad deleted successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete olympiad.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access!']);
        }
    }
}