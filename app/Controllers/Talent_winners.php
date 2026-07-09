<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Commanmodel;

class Talent_winners extends BaseController
{
    protected $commanmodel;
    
    public function __construct()
    {
        $this->commanmodel = new Commanmodel();
        helper(['form', 'url', 'filesystem']);
    }

    // ============================================================
    // MAIN PAGE - Talent Winners List
    // ============================================================
    public function talent_winners()
    {
        $session = session();
        
        if (session()->get('admin_type') == 'Supar Admin') {
            $table_header = [
                ['data' => 'id'],
                ['data' => 'image'],
                ['data' => 'name'],
                ['data' => 'rank'],
                ['data' => 'score'],
                ['data' => 'school'],
                ['data' => 'city_state'],
                ['data' => 'category'],
                ['data' => 'position'],
                ['data' => 'year'],
                ['data' => 'status'],
                ['data' => 'action'],
            ];

            $data['table_column'] = json_encode($table_header);
            $data['title'] = 'Talent Winners List';
            return view('admin/head', $data) 
                 . view('admin/sidebar', $data) 
                 . view('admin/talent_winners', $data) 
                 . view('admin/footer');
        } else {
            return redirect()->back()->withInput();
        }
    }

    // ============================================================
    // DATATABLE AJAX - Get Talent Winners List
    // ============================================================
    public function talent_winners_list()
    {
        $commanmodel = new Commanmodel();
        
        $draw = $_POST['draw'] ?? 1;
        $start = $_POST['start'] ?? 0;
        $length = $_POST['length'] ?? 10;

        $search = $_POST['search']['value'] ?? '';
        $filters = [];
        
        // Add search filters
        if (!empty($search)) {
            $filters['search'] = $search;
        }

        $order = [
            'column' => 'id',
            'order' => 'DESC'
        ];

        $result = $commanmodel->getDataFromTable('talent_winners', $filters, $order, $length, $start);
        $alldata = $result['filteredRecords'];
        $data = [];
        $sn = $start + 1;

        foreach ($alldata as $row) {
            // Image
            $imageHtml = !empty($row->image) 
                ? '<img src="' . base_url('assets/talent/' . $row->image) . '" style="width:50px;height:50px;object-fit:cover;border-radius:50%;border:2px solid #ddd;">'
                : '<img src="' . base_url('assets/img/default-user.png') . '" style="width:50px;height:50px;object-fit:cover;border-radius:50%;border:2px solid #ddd;">';

            // Rank Badge
            $rankBadge = '';
            if ($row->rank == '1st') {
                $rankBadge = '<span class="badge" style="background: linear-gradient(135deg, #FFD700, #FFA500); color: #000;">🥇 1st</span>';
            } elseif ($row->rank == '2nd') {
                $rankBadge = '<span class="badge" style="background: linear-gradient(135deg, #C0C0C0, #A8A8A8); color: #000;">🥈 2nd</span>';
            } elseif ($row->rank == '3rd') {
                $rankBadge = '<span class="badge" style="background: linear-gradient(135deg, #CD7F32, #B87333); color: #fff;">🥉 3rd</span>';
            } else {
                $rankBadge = '<span class="badge bg-secondary">' . $row->rank . '</span>';
            }

            // Score
            $scoreHtml = $row->score ? '<strong>' . $row->score . '</strong>' : '<span class="text-muted">-</span>';

            // City/State
            $cityStateHtml = '';
            if (!empty($row->city) || !empty($row->state)) {
                $cityStateHtml = '<i class="fas fa-map-marker-alt text-danger"></i> ' . $row->city . ', ' . $row->state;
            } else {
                $cityStateHtml = '<span class="text-muted">-</span>';
            }

            // Status Badge
            $statusBadge = ($row->status == 'Active') 
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';

            // Position Badge
            $positionBadge = '';
            if ($row->position == 'Winner') {
                $positionBadge = '<span class="badge bg-warning text-dark">🏆 Winner</span>';
            } elseif ($row->position == 'Runner Up') {
                $positionBadge = '<span class="badge bg-secondary">🥈 Runner Up</span>';
            } elseif ($row->position == 'Second Runner Up') {
                $positionBadge = '<span class="badge bg-info">🥉 2nd Runner Up</span>';
            }

            // Action Buttons
            $action = '<div class="btn-group" role="group">
               
                <button type="button" class="btn btn-sm btn-primary editWinner" 
                    data-id="' . $row->id . '"
                    data-name="' . htmlspecialchars($row->name, ENT_QUOTES) . '"
                    data-rank="' . $row->rank . '"
                    data-score="' . $row->score . '"
                    data-school="' . htmlspecialchars($row->school, ENT_QUOTES) . '"
                    data-city="' . htmlspecialchars($row->city, ENT_QUOTES) . '"
                    data-state="' . htmlspecialchars($row->state, ENT_QUOTES) . '"
                    data-category="' . $row->category . '"
                    data-position="' . $row->position . '"
                    data-year="' . $row->year . '"
                    data-status="' . $row->status . '"
                    data-image="' . $row->image . '"
                    title="Edit">
                    <i class="fas fa-edit"></i> edit
                </button>
                <button type="button" class="btn btn-sm btn-danger deleteWinner" data-id="' . $row->id . '" title="Delete">
                    <i class="fas fa-trash"></i> Delete
                </button>
              
            </div>';

            $data[] = [
                "id" => $sn,
                "image" => $imageHtml,
                "name" => '<strong>' . htmlspecialchars($row->name) . '</strong>',
                "rank" => $rankBadge,
                "score" => $scoreHtml,
                "school" => htmlspecialchars($row->school),
                "city_state" => $cityStateHtml,
                "category" => '<span class="badge bg-primary">' . $row->category . '</span>',
                "position" => $positionBadge,
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
    // INSERT TALENT WINNER
    // ============================================================
    public function talent_winner_save()
    {
        $commanmodel = new Commanmodel();
        $session = session();

        // Validation
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'rank' => 'required',
            'score' => 'permit_empty|numeric',
            'school' => 'required|min_length[2]|max_length[255]',
            'city' => 'required|min_length[2]|max_length[100]',
            'state' => 'required|min_length[2]|max_length[100]',
            'category' => 'required',
            'position' => 'required',
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
            $uploadPath = FCPATH . 'assets/talent/';
            
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
            'rank' => $this->request->getPost('rank'),
            'score' => $this->request->getPost('score') ?: null,
            'school' => $this->request->getPost('school'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'category' => $this->request->getPost('category'),
            'position' => $this->request->getPost('position'),
            'year' => $this->request->getPost('year'),
            'status' => $this->request->getPost('status'),
            'image' => $imageName,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // ============================================
        // INSERT
        // ============================================
        try {
            $insertId = $commanmodel->insert_query('talent_winners', $data);
            
            if ($insertId) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Talent winner added successfully!',
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
    // UPDATE TALENT WINNER
    // ============================================================
    public function talent_winner_update()
    {
        $commanmodel = new Commanmodel();
        $session = session();
        $winnerId = $this->request->getPost('edit_id');

        // Validation
        $rules = [
            'edit_name' => 'required|min_length[2]|max_length[100]',
            'edit_rank' => 'required',
            'edit_score' => 'permit_empty|numeric',
            'edit_school' => 'required|min_length[2]|max_length[255]',
            'edit_city' => 'required|min_length[2]|max_length[100]',
            'edit_state' => 'required|min_length[2]|max_length[100]',
            'edit_category' => 'required',
            'edit_position' => 'required',
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
            $uploadPath = FCPATH . 'assets/talent/';
            
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
            'rank' => $this->request->getPost('edit_rank'),
            'score' => $this->request->getPost('edit_score') ?: null,
            'school' => $this->request->getPost('edit_school'),
            'city' => $this->request->getPost('edit_city'),
            'state' => $this->request->getPost('edit_state'),
            'category' => $this->request->getPost('edit_category'),
            'position' => $this->request->getPost('edit_position'),
            'year' => $this->request->getPost('edit_year'),
            'status' => $this->request->getPost('edit_status'),
            'image' => $imageName,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $where = ['id' => $winnerId];

        // ============================================
        // UPDATE
        // ============================================
        try {
            $updated = $commanmodel->update_query('talent_winners', $data, $where);
            
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
    // DELETE TALENT WINNER
    // ============================================================
    public function talent_winner_delete()
    {
        $commanmodel = new Commanmodel();
        $winnerId = $this->request->getPost('id');

        try {
            // Get winner data to delete image
            $winner = $commanmodel->get_row('talent_winners', ['id' => $winnerId]);
            
            if ($winner && !empty($winner->image)) {
                $filePath = FCPATH . 'assets/talent/' . $winner->image;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $where = ['id' => $winnerId];
            $deleted = $commanmodel->delete_query('talent_winners', $where);

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

    // ============================================================
    // GET SINGLE WINNER DETAILS
    // ============================================================
    public function get_winner_details($id)
    {
        $commanmodel = new Commanmodel();
        $winner = $commanmodel->get_row('talent_winners', ['id' => $id]);

        if ($winner) {
            return $this->response->setJSON([
                'status' => true,
                'data' => $winner
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Winner not found'
            ]);
        }
    }

    // ============================================================
    // TOGGLE STATUS
    // ============================================================
    public function toggle_status()
    {
        $commanmodel = new Commanmodel();
        $id = $this->request->getPost('id');
        $currentStatus = $this->request->getPost('status');
        
        $newStatus = ($currentStatus == 'Active') ? 'Inactive' : 'Active';
        
        $data = ['status' => $newStatus];
        $where = ['id' => $id];
        
        $updated = $commanmodel->update_query('talent_winners', $data, $where);
        
        if ($updated) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Status updated successfully!',
                'new_status' => $newStatus
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Failed to update status!'
            ]);
        }
    }
}