<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Commanmodel;

class Enquiry extends BaseController
{
    protected $commanmodel;
    
    public function __construct()
    {
        $this->commanmodel = new Commanmodel();
        helper(['form', 'url']);
    }

    // ============================================================
    // MAIN PAGE - Enquiry List
    // ============================================================
    public function enquiry()
    {
        $session = session();
        
        if (session()->get('admin_type') == 'Supar Admin') {
            $table_header = [
                ['data' => 'id'],
                ['data' => 'book_name'],
                ['data' => 'name'],
                ['data' => 'email'],
                ['data' => 'phone'],
                ['data' => 'message'],
                ['data' => 'status'],
                ['data' => 'created_at'],
                ['data' => 'action'],
            ];

            $data['table_column'] = json_encode($table_header);
            $data['title'] = 'Enquiry List';
            return view('admin/head', $data) 
                 . view('admin/sidebar', $data) 
                 . view('admin/enquiry', $data) 
                 . view('admin/footer');
        } else {
            return redirect()->back()->withInput();
        }
    }

    // ============================================================
    // DATATABLE AJAX - Get Enquiry List
    // ============================================================
    public function enquiry_list()
    {
        $commanmodel = new Commanmodel();
        
        $draw = $_POST['draw'] ?? 1;
        $start = $_POST['start'] ?? 0;
        $length = $_POST['length'] ?? 10;

        $filters = [];
        $order = [
            'column' => 'enquiry_id',
            'order' => 'DESC'
        ];

        $result = $commanmodel->getDataFromTable('enquiries', $filters, $order, $length, $start);
        $alldata = $result['filteredRecords'];
        $data = [];
        $sn = $start + 1;

        foreach ($alldata as $row) {
            // Status Badge
            $statusBadge = '';
            if ($row->status == 'Pending') {
                $statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
            } elseif ($row->status == 'Contacted') {
                $statusBadge = '<span class="badge bg-info">Contacted</span>';
            } elseif ($row->status == 'Closed') {
                $statusBadge = '<span class="badge bg-success">Closed</span>';
            }

            // Action Buttons
            $action = '<div class="btn-group">
                <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                    <span class="sr-only">Info</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item viewEnquiry" href="javascript:void(0);" 
                       data-id="' . $row->enquiry_id . '"
                       data-book_name="' . htmlspecialchars($row->book_name) . '"
                       data-name="' . htmlspecialchars($row->name) . '"
                       data-email="' . $row->email . '"
                       data-phone="' . $row->phone . '"
                       data-message="' . htmlspecialchars($row->message) . '"
                       data-status="' . $row->status . '"
                       data-created="' . $row->created_at . '">
                       <i class="fas fa-eye"></i> View
                    </a>
                    <a class="dropdown-item updateStatus" href="javascript:void(0);" 
                       data-id="' . $row->enquiry_id . '"
                       data-status="' . $row->status . '">
                       <i class="fas fa-edit"></i> Update Status
                    </a>
                    <a class="dropdown-item deleteEnquiry" href="javascript:void(0);" 
                       data-id="' . $row->enquiry_id . '">
                       <i class="fas fa-trash"></i> Delete
                    </a>
                </div>
            </div>';

            // Message (shortened)
            $shortMessage = strlen($row->message) > 50 
                ? substr($row->message, 0, 50) . '...' 
                : $row->message;

            $data[] = [
                "id" => $sn,
                "book_name" => htmlspecialchars($row->book_name),
                "name" => htmlspecialchars($row->name),
                "email" => $row->email,
                "phone" => $row->phone,
                "message" => $shortMessage,
                "status" => $statusBadge,
                "created_at" => date('d M Y h:i A', strtotime($row->created_at)),
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
    // UPDATE ENQUIRY STATUS
    // ============================================================
    public function update_status()
    {
        $commanmodel = new Commanmodel();
        $enquiryId = $this->request->getPost('enquiry_id');
        $status = $this->request->getPost('status');

        $data = ['status' => $status];
        $where = ['enquiry_id' => $enquiryId];

        try {
            $updated = $commanmodel->update_query('enquiries', $data, $where);
            
            if ($updated) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Status updated successfully!'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Failed to update status!'
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
    // DELETE ENQUIRY
    // ============================================================
    public function delete_enquiry()
    {
        $commanmodel = new Commanmodel();
        $enquiryId = $this->request->getPost('enquiry_id');

        try {
            $where = ['enquiry_id' => $enquiryId];
            $deleted = $commanmodel->delete_query('enquiries', $where);
            
            if ($deleted) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Enquiry deleted successfully!'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Failed to delete enquiry!'
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
    // GET SINGLE ENQUIRY (for view)
    // ============================================================
    public function get_enquiry()
    {
        $commanmodel = new Commanmodel();
        $enquiryId = $this->request->getPost('enquiry_id');

        $enquiry = $commanmodel->get_row('enquiries', ['enquiry_id' => $enquiryId]);
        
        if ($enquiry) {
            return $this->response->setJSON([
                'status' => true,
                'data' => $enquiry
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Enquiry not found!'
            ]);
        }
    }
}