<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Commanmodel;

class Winners_member extends BaseController
{
    protected $commanmodel;
    
    public function __construct()
    {
        $this->commanmodel = new Commanmodel();
        helper(['form', 'url', 'filesystem']);
    }

    // ============================================================
    // MAIN PAGE - Winners List
    // ============================================================
    public function winners_member()
    {
        $session = session();
        
        if (session()->get('admin_type') == 'Supar Admin') {
            $table_header = [
                ['data' => 'id'],
                ['data' => 'image'],
                ['data' => 'name'],
                ['data' => 'title'],
                ['data' => 'category'],
                ['data' => 'year'],
                ['data' => 'status'],
                ['data' => 'action'],
            ];

            $data['table_column'] = json_encode($table_header);
            $data['title'] = 'Winners Member List';
            return view('admin/head', $data) 
                 . view('admin/sidebar', $data) 
                 . view('admin/winners_member', $data) 
                 . view('admin/footer');
        } else {
            return redirect()->back()->withInput();
        }
    }

    // ============================================================
    // DATATABLE AJAX - Get Winners List
    // ============================================================
    public function winners_member_list()
    {
        $commanmodel = new Commanmodel();
        
        $draw = $_POST['draw'] ?? 1;
        $start = $_POST['start'] ?? 0;
        $length = $_POST['length'] ?? 10;

        $filters = [];
        $order = [
            'column' => 'winner_id',
            'order' => 'DESC'
        ];

        $result = $commanmodel->getDataFromTable('winners_member', $filters, $order, $length, $start);
        $alldata = $result['filteredRecords'];
        $data = [];
        $sn = $start + 1;

        foreach ($alldata as $row) {
            // Image
            $imageHtml = !empty($row->image) 
                ? '<img src="' . base_url('assets/winners/' . $row->image) . '" style="width:60px;height:60px;object-fit:cover;border-radius:4px;">'
                : '<img src="' . base_url('assets/img/default.jpg') . '" style="width:60px;height:60px;object-fit:cover;border-radius:4px;">';

            // Status Badge
            $statusBadge = ($row->status == 'Active') 
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';

            // Action Buttons
            $action = '<div class="btn-group">
                <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                    <span class="sr-only">Info</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item editWinner" href="javascript:void(0);" 
                       data-id="' . $row->winner_id . '"
                       data-name="' . htmlspecialchars($row->name) . '"
                       data-title="' . htmlspecialchars($row->title) . '"
                       data-category="' . $row->category . '"
                       data-year="' . $row->year . '"
                       data-status="' . $row->status . '"
                       data-image="' . $row->image . '">
                       <i class="fas fa-edit"></i> Edit
                    </a>
                    <a class="dropdown-item deleteWinner" href="javascript:void(0);" 
                       data-id="' . $row->winner_id . '">
                       <i class="fas fa-trash"></i> Delete
                    </a>
                </div>
            </div>';

            $data[] = [
                "id" => $sn,
                "image" => $imageHtml,
                "name" => htmlspecialchars($row->name),
                "title" => htmlspecialchars($row->title),
                "category" => $row->category,
                "year" => $row->year,
                "status" => $statusBadge,
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

    // ============================================================
    // INSERT WINNER
    // ============================================================
    public function winner_member_save()
    {
        $commanmodel = new Commanmodel();
        $session = session();

        // Validation
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'title' => 'required|min_length[2]|max_length[100]',
            'category' => 'required',
            'year' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // ============================================
        // IMAGE UPLOAD
        // ============================================
        $imageName = '';
        $file = $this->request->getFile('image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'assets/winners/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $originalName = $file->getClientName();
            $extension = $file->getExtension();
            $cleanName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            $imageName = $cleanName . '_' . time() . '_' . uniqid() . '.' . $extension;
            
            $file->move($uploadPath, $imageName);
        }

        // ============================================
        // PREPARE DATA
        // ============================================
        $data = [
            'name' => $this->request->getPost('name'),
            'title' => $this->request->getPost('title'),
            'category' => $this->request->getPost('category'),
            'year' => $this->request->getPost('year'),
            'status' => $this->request->getPost('status'),
            'image' => $imageName,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // ============================================
        // INSERT
        // ============================================
        try {
            $insertId = $commanmodel->insert_query('winners_member', $data);
            
            if ($insertId) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Winner added successfully!',
                    'id' => $insertId
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Failed to add winner!'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // ============================================================
    // UPDATE WINNER
    // ============================================================
    public function winner_member_update()
    {
        $commanmodel = new Commanmodel();
        $session = session();
        $winnerId = $this->request->getPost('edit_winner_id');

        // Validation
        $rules = [
            'edit_name' => 'required|min_length[2]|max_length[100]',
            'edit_title' => 'required|min_length[2]|max_length[100]',
            'edit_category' => 'required',
            'edit_year' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // ============================================
        // IMAGE UPDATE
        // ============================================
        $imageName = $this->request->getPost('edit_existing_image');
        $file = $this->request->getFile('edit_image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'assets/winners/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Delete old image
            if (!empty($imageName)) {
                $oldFilePath = $uploadPath . $imageName;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            
            // Upload new image
            $originalName = $file->getClientName();
            $extension = $file->getExtension();
            $cleanName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            $imageName = $cleanName . '_' . time() . '_' . uniqid() . '.' . $extension;
            
            $file->move($uploadPath, $imageName);
        }

        // ============================================
        // PREPARE DATA
        // ============================================
        $data = [
            'name' => $this->request->getPost('edit_name'),
            'title' => $this->request->getPost('edit_title'),
            'category' => $this->request->getPost('edit_category'),
            'year' => $this->request->getPost('edit_year'),
            'status' => $this->request->getPost('edit_status'),
            'image' => $imageName,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $where = ['winner_id' => $winnerId];

        // ============================================
        // UPDATE
        // ============================================
        try {
            $updated = $commanmodel->update_query('winners_member', $data, $where);
            
            if ($updated) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Winner updated successfully!'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'No changes made!'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // ============================================================
    // DELETE WINNER
    // ============================================================
    public function winner_member_delete()
    {
        $commanmodel = new Commanmodel();
        $winnerId = $this->request->getPost('winner_id');

        try {
            // Get winner data to delete image
            $winner = $commanmodel->get_row('winners_member', ['winner_id' => $winnerId]);
            
            if ($winner && !empty($winner->image)) {
                $filePath = FCPATH . 'assets/winners/' . $winner->image;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $where = ['winner_id' => $winnerId];
            $deleted = $commanmodel->delete_query('winners_member', $where);

            if ($deleted) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Winner deleted successfully!'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Failed to delete winner!'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}