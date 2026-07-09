<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Commanmodel;

class Teacher extends BaseController
{
    public function index()
    {
        $commanmodel = new Commanmodel();
        $session = session();
        
        if(session()->get('admin_type') == 'Supar Admin') {
            $data['table_name'] = '';
            
            $table_header = [
                ['data' => 'id'],
                ['data' => 'images'],
                ['data' => 'name'],
                ['data' => 'position'],
                ['data' => 'action'],
            ];
            
            $data['table_column'] = json_encode($table_header);
            
            return view('admin/head')
                   . view('admin/sidebar')
                   . view('admin/teacher', $data)
                   . view('admin/footer');
        } else {
            return redirect()->back()->withInput();
        }
    }
    
    public function teacher_list()
    {
        $session = session();
        $commanmodel = new Commanmodel();
        
        $draw = $_POST['draw'];
        $start = $_POST['start'];
        $length = $_POST['length'];
        $searchname = $_POST['searchname'];
        
        $filters = [];
        
        $order = null;
        if (!empty($_POST['order'])) {
            $orderColumn = $_POST['order'][0]['column'];
            $orderDirection = $_POST['order'][0]['dir'];
            $order = [
                'column' => 'teacher_id',
                'order' => 'DESC',
            ];
        }
        
        $result = $commanmodel->getDataFromTable('teacher', $filters, $order, $length, $start);
        
        $alldata = $result['filteredRecords'];
        $data = [];
        $no = $start + 1;
        $sn = 1;
        
        foreach ($alldata as $alldata_view) {
            $name = '<a href="' . base_url('admin/teacher/' . $alldata_view->teacher_id) . '">' . $alldata_view->teacher_name . '</a>';
            
            $images = '<img class="cat-thumb" src="' . base_url() . '/assets/teacher/' . $alldata_view->teacher_image . '" style="width:60px;height:60px;object-fit:cover;border-radius:50%;">';
            
            $status_badge = $alldata_view->teacher_status == 'Active' 
                ? '<span class="badge badge-success">Active</span>' 
                : '<span class="badge badge-danger">Inactive</span>';
            
            $action = '<div class="btn-group">
                <button type="button" class="btn btn-outline-' . $alldata_view->teacher_status_color . '">' . $alldata_view->teacher_status . '</button>
                <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                    <span class="sr-only">Info</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item editRecordteacher" href="javascript:void(0);" 
                       data-teacher_id="' . $alldata_view->teacher_id . '" 
                       data-teacher_image="' . $alldata_view->teacher_image . '" 
                       data-teacher_name="' . $alldata_view->teacher_name . '" 
                       data-teacher_position="' . $alldata_view->teacher_position . '"
                       data-teacher_status="' . $alldata_view->teacher_status . '"
                       data-teacher_facebook="' . $alldata_view->teacher_facebook . '"
                       data-teacher_instagram="' . $alldata_view->teacher_instagram . '"
                       data-teacher_linkedin="' . $alldata_view->teacher_linkedin . '"
                       data-teacher_twitter="' . $alldata_view->teacher_twitter . '">Edit</a>
                    <a class="dropdown-item deleteRecord" href="javascript:void(0);" data-id="' . $alldata_view->teacher_id . '">Delete</a>
                </div>
            </div>';
            
            $data[] = [
                "id" => $sn,
                "images" => $images,
                "name" => $name,
                "position" => $alldata_view->teacher_position,
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
    
    public function teacher_save()
    {
        $session = session();
        $commanmodel = new Commanmodel();
        
        $status = $this->request->getVar('teacher_status');
        if ($status == 'Active') {
            $status_color = 'success';
        } else {
            $status_color = 'danger';
        }
        
        $validated = $this->validate([
            'teacher_image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[teacher_image]'
                    . '|is_image[teacher_image]'
                    . '|mime_in[teacher_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[teacher_image,2048]'
            ],
        ]);
        
        if ($validated) {
            $file = $this->request->getFile('teacher_image');
            $teacher_image = $file->getRandomName();
            $file->move('assets/teacher', $teacher_image);
        } else {
            $teacher_image = '';
        }
        
        $title = strip_tags($this->request->getVar('teacher_name'));
        $titleURL = strtolower(url_title($title));
        
        // Check if slug exists
        if ($commanmodel->get_url_slug('teacher', $titleURL)) {
            $titleURL = $titleURL . '-' . time();
        }
        
        $data = array(
            'teacher_name' => $this->request->getVar('teacher_name'),
            'teacher_position' => $this->request->getVar('teacher_position'),
            'teacher_status' => $this->request->getVar('teacher_status'),
            'teacher_status_color' => $status_color,
            'teacher_image' => $teacher_image,
            'teacher_facebook' => $this->request->getVar('teacher_facebook'),
            'teacher_instagram' => $this->request->getVar('teacher_instagram'),
            'teacher_linkedin' => $this->request->getVar('teacher_linkedin'),
            'teacher_twitter' => $this->request->getVar('teacher_twitter'),
            'url_slug' => $titleURL,
        );
        
        $Inserted = $commanmodel->insert_query('teacher', $data);
        echo json_encode($Inserted);
    }
    
    public function teacher_update()
    {
        $session = session();
        helper(['form', 'url']);
        $commanmodel = new Commanmodel();
        
        $status = $this->request->getVar('edit_teacher_status');
        if ($status == 'Active') {
            $status_color = 'success';
        } else {
            $status_color = 'danger';
        }
        
        $validated = $this->validate([
            'edit_teacher_image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[edit_teacher_image]'
                    . '|is_image[edit_teacher_image]'
                    . '|mime_in[edit_teacher_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[edit_teacher_image,2048]'
            ],
        ]);
        
        if ($validated) {
            $file = $this->request->getFile('edit_teacher_image');
            $teacher_image = $file->getRandomName();
            $file->move('assets/teacher', $teacher_image);
        } else {
            $teacher_image = $this->request->getVar('edit_teacher_image_old');
        }
        
        $title = strip_tags($this->request->getVar('edit_teacher_name'));
        $titleURL = strtolower(url_title($title));
        
        if ($commanmodel->get_url_slug_update('teacher', $titleURL, array('teacher_id' => $this->request->getVar('edit_teacher_id')))) {
            $titleURL = $titleURL . '-' . time();
        }
        
        $data = array(
            'teacher_name' => $this->request->getVar('edit_teacher_name'),
            'teacher_position' => $this->request->getVar('edit_teacher_position'),
            'teacher_status' => $this->request->getVar('edit_teacher_status'),
            'teacher_status_color' => $status_color,
            'teacher_image' => $teacher_image,
            'teacher_facebook' => $this->request->getVar('edit_teacher_facebook'),
            'teacher_instagram' => $this->request->getVar('edit_teacher_instagram'),
            'teacher_linkedin' => $this->request->getVar('edit_teacher_linkedin'),
            'teacher_twitter' => $this->request->getVar('edit_teacher_twitter'),
            'url_slug' => $titleURL,
        );
        
        $where = array(
            'teacher_id' => $this->request->getVar('edit_teacher_id')
        );
        
        $updated = $commanmodel->update_query('teacher', $data, $where);
        echo json_encode($updated);
    }
    
    public function teacher_delete()
    {
        $commanmodel = new Commanmodel();
        $id = $this->request->getVar('id');
        
        $where = array('teacher_id' => $id);
        $deleted = $commanmodel->delete_query('teacher', $where);
        
        echo json_encode($deleted);
    }
}