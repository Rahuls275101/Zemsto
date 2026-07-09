<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Commanmodel;

class Book extends BaseController
{
    protected $commanmodel;
    
    public function __construct()
    {
        $this->commanmodel = new Commanmodel();
        helper(['form', 'url', 'filesystem']);
    }

    // ============================================================
    // MAIN PAGE
    // ============================================================
    public function book()
    {
        $session = session();
        
        if (session()->get('admin_type') == 'Supar Admin') {
            $table_header = [
                ['data' => 'id'],
                ['data' => 'image'],
                ['data' => 'book_name'],
                ['data' => 'class'],
                ['data' => 'subject'],
                ['data' => 'price'],
                ['data' => 'status'],
                ['data' => 'action'],
            ];

            $data['table_column'] = json_encode($table_header);
            return view('admin/head') . view('admin/sidebar') . view('admin/book', $data) . view('admin/footer');
        } else {
            return redirect()->back()->withInput();
        }
    }

    // ============================================================
    // DATATABLE AJAX
    // ============================================================
    public function book_list()
    {
        $commanmodel = new Commanmodel();
        
        $draw = $_POST['draw'] ?? 1;
        $start = $_POST['start'] ?? 0;
        $length = $_POST['length'] ?? 10;

        $filters = [];
        $order = [
            'column' => 'book_id',
            'order' => 'DESC'
        ];

        $result = $commanmodel->getDataFromTable('books', $filters, $order, $length, $start);
        $alldata = $result['filteredRecords'];
        $data = [];
        $sn = $start + 1;

        foreach ($alldata as $row) {
            // Single Image Display
            $imageHtml = '';
            if (!empty($row->book_image)) {
                $imageHtml = '<img src="' . base_url('assets/books/' . $row->book_image) . '" style="width:60px;height:60px;object-fit:cover;border-radius:4px;">';
            }

            $statusColor = ($row->book_status == 'Active') ? 'success' : 'danger';

            $action = '<div class="btn-group">
                <button type="button" class="btn btn-outline-' . $statusColor . '">' . $row->book_status . '</button>
                <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                    <span class="sr-only">Info</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item editRecordbook" href="javascript:void(0);" 
                       data-book_id="' . $row->book_id . '"
                       data-book_name="' . htmlspecialchars($row->book_name) . '"
                       data-book_class="' . $row->book_class . '"
                       data-book_subject="' . $row->book_subject . '"
                       data-book_price="' . $row->book_price . '"
                       data-book_discount_price="' . $row->book_discount_price . '"
                       data-book_type="' . $row->book_type . '"
                       data-book_status="' . $row->book_status . '"
                       data-book_description="' . htmlspecialchars($row->book_description) . '"
                       data-book_image="' . $row->book_image . '">Edit</a>
                    <a class="dropdown-item deleteRecordbook" href="javascript:void(0);" data-book_id="' . $row->book_id . '">Delete</a>
                </div>
            </div>';

            $data[] = [
                "id" => $sn,
                "image" => $imageHtml,
                "book_name" => '<a href="' . base_url('admin/book/' . $row->book_id) . '">' . htmlspecialchars($row->book_name) . '</a>',
                "class" => $row->book_class,
                "subject" => $row->book_subject,
                "price" => '₹' . $row->book_price . ($row->book_discount_price ? ' <del>₹' . $row->book_discount_price . '</del>' : ''),
                "status" => '<span class="badge bg-' . $statusColor . '">' . $row->book_status . '</span>',
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
    // INSERT BOOK - SINGLE IMAGE
    // ============================================================
    public function book_save()
    {
        $commanmodel = new Commanmodel();
        $session = session();

        // Validation
        $rules = [
            'book_name' => 'required|min_length[3]|max_length[255]',
            'book_class' => 'required',
            'book_subject' => 'required',
            'book_price' => 'required|numeric',
            'book_description' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // ============================================
        // SINGLE IMAGE UPLOAD
        // ============================================
        $imageName = '';
        $file = $this->request->getFile('book_image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'assets/books/';
            
            // Create folder if not exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Get original name
            $originalName = $file->getClientName();
            $extension = $file->getExtension();
            
            // Clean name
            $cleanName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            
            // Generate unique name
            $imageName = $cleanName . '_' . time() . '_' . uniqid() . '.' . $extension;
            
            // Move file
            $file->move($uploadPath, $imageName);
        }

        // Generate URL slug
        $title = strip_tags($this->request->getVar('book_name'));
        $titleURL = strtolower(url_title($title));
        
        if ($commanmodel->get_url_slug('books', $titleURL)) {
            $titleURL = $titleURL . '-' . time();
        }

        $status = $this->request->getVar('book_status');
        $statusColor = ($status == 'Active') ? 'success' : 'danger';

        // Prepare data
        $data = [
            'book_name' => $this->request->getVar('book_name'),
            'book_class' => $this->request->getVar('book_class'),
            'book_subject' => $this->request->getVar('book_subject'),
            'book_price' => $this->request->getVar('book_price'),
            'book_discount_price' => $this->request->getVar('book_discount_price') ?? null,
            'book_type' => $this->request->getVar('book_type'),
            'book_status' => $status,
            'book_status_color' => $statusColor,
            'book_description' => $this->request->getVar('book_description'),
            'book_image' => $imageName,  // Single image
            'url_slug' => $titleURL,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => session()->get('id') ?? 1
        ];

        // Insert
        try {
            $insertId = $commanmodel->insert_query('books', $data);
            
            if ($insertId) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Book added successfully!',
                    'id' => $insertId,
                    'image' => $imageName
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Failed to add book!'
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
    // UPDATE BOOK - SINGLE IMAGE
    // ============================================================
    public function book_update()
    {
        $commanmodel = new Commanmodel();
        $session = session();
        $bookId = $this->request->getVar('edit_book_id');

        // Validation
        $rules = [
            'edit_book_name' => 'required|min_length[3]|max_length[255]',
            'edit_book_class' => 'required',
            'edit_book_subject' => 'required',
            'edit_book_price' => 'required|numeric',
            'edit_book_description' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // ============================================
        // SINGLE IMAGE UPDATE
        // ============================================
        $imageName = $this->request->getVar('edit_existing_image');
        $file = $this->request->getFile('edit_book_image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'assets/books/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Delete old image if exists
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

        // Generate URL slug
        $title = strip_tags($this->request->getVar('edit_book_name'));
        $titleURL = strtolower(url_title($title));
        if ($commanmodel->get_url_slug_update('books', $titleURL, ['book_id' => $bookId])) {
            $titleURL = $titleURL . '-' . time();
        }

        $status = $this->request->getVar('edit_book_status');
        $statusColor = ($status == 'Active') ? 'success' : 'danger';

        $data = [
            'book_name' => $this->request->getVar('edit_book_name'),
            'book_class' => $this->request->getVar('edit_book_class'),
            'book_subject' => $this->request->getVar('edit_book_subject'),
            'book_price' => $this->request->getVar('edit_book_price'),
            'book_discount_price' => $this->request->getVar('edit_book_discount_price') ?? null,
            'book_type' => $this->request->getVar('edit_book_type'),
            'book_status' => $status,
            'book_status_color' => $statusColor,
            'book_description' => $this->request->getVar('edit_book_description'),
            'book_image' => $imageName,
            'url_slug' => $titleURL,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => session()->get('id') ?? 1
        ];

        $where = ['book_id' => $bookId];

        try {
            $updated = $commanmodel->update_query('books', $data, $where);
            
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Book updated successfully!'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // ============================================================
    // DELETE BOOK
    // ============================================================
    public function book_delete()
    {
        $commanmodel = new Commanmodel();
        $bookId = $this->request->getVar('book_id');

        try {
            $book = $commanmodel->get_row('books', ['book_id' => $bookId]);
            
            // Delete image from server
            if ($book && !empty($book->book_image)) {
                $filePath = FCPATH . 'assets/books/' . $book->book_image;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $where = ['book_id' => $bookId];
            $deleted = $commanmodel->delete_query('books', $where);

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Book deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}