<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Commanmodel;

class Olympiad_results extends BaseController
{
    protected $commanmodel;
    
    public function __construct()
    {
        $this->commanmodel = new Commanmodel();
        helper(['form', 'url', 'filesystem']);
    }

    // ============================================================
    // MAIN PAGE - Olympiad Results List
    // ============================================================
    public function olympiad_results()
    {
        $session = session();
        
        if (session()->get('admin_type') == 'Supar Admin') {
            $table_header = [
                ['data' => 'id'],
                ['data' => 'subject'],
                ['data' => 'class'],
                ['data' => 'enrollment'],
                ['data' => 'student_name'],
                ['data' => 'parent_name'],
                ['data' => 'phone'],
                ['data' => 'email'],
                ['data' => 'marks'],
                ['data' => 'rank'],
                ['data' => 'status'],
                ['data' => 'action'],
            ];

            $data['table_column'] = json_encode($table_header);
            $data['title'] = 'Olympiad Results';
            return view('admin/head', $data) 
                 . view('admin/sidebar', $data) 
                 . view('admin/olympiad_results', $data) 
                 . view('admin/footer');
        } else {
            return redirect()->back()->withInput();
        }
    }

    // ============================================================
    // DATATABLE AJAX - Get Results List
    // ============================================================
    public function olympiad_results_list()
    {
        $db = \Config\Database::connect();
        
        $draw = $_POST['draw'] ?? 1;
        $start = $_POST['start'] ?? 0;
        $length = $_POST['length'] ?? 10;
        $search = $_POST['search']['value'] ?? '';

        // Main query with joins
        $builder = $db->table('olympiad_results r');
        $builder->select('r.*, s.subject_name, s.subject_code, c.class_name');
        $builder->join('olympiad_subjects s', 's.id = r.subject_id', 'left');
        $builder->join('olympiad_classes c', 'c.id = r.class_id', 'left');
        
        // Apply search
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('r.student_name', $search)
                    ->orLike('r.enrollment', $search)
                    ->orLike('s.subject_name', $search)
                    ->orLike('c.class_name', $search)
                    ->groupEnd();
        }
        
        // Get total count
        $countBuilder = $db->table('olympiad_results');
        $totalRecords = $countBuilder->countAllResults();
        
        // Get filtered count
        $filterBuilder = clone $builder;
        $filteredRecords = $filterBuilder->countAllResults();
        
        // Get data with limit
        $builder->orderBy('r.id', 'DESC');
        $builder->limit($length, $start);
        $query = $builder->get();
        $alldata = $query->getResult();
        
        $data = [];
        $sn = $start + 1;

        foreach ($alldata as $row) {
            // Status Badge
            $statusBadge = ($row->status == 'Active') 
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';

            // Position
            $positionBadge = '';
            if ($row->position == '1st') {
                $positionBadge = '<span class="badge bg-warning text-dark">🥇 1st</span>';
            } elseif ($row->position == '2nd') {
                $positionBadge = '<span class="badge bg-secondary">🥈 2nd</span>';
            } elseif ($row->position == '3rd') {
                $positionBadge = '<span class="badge bg-info">🥉 3rd</span>';
            }

            // Action Buttons
            $action = '<div class="btn-group">
                <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                    <span class="sr-only">Info</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item editResult" href="javascript:void(0);" 
                       data-id="' . $row->id . '"
                       data-subject_id="' . $row->subject_id . '"
                       data-class_id="' . $row->class_id . '"
                       data-enrollment="' . $row->enrollment . '"
                       data-access_code="' . $row->access_code . '"
                       data-student_name="' . htmlspecialchars($row->student_name) . '"
                       data-parent_name="' . htmlspecialchars($row->parent_name) . '"
                       data-phone="' . $row->phone . '"
                       data-email="' . $row->email . '"
                       data-school_name="' . htmlspecialchars($row->school_name) . '"
                       data-marks="' . $row->marks . '"
                       data-rank="' . $row->rank . '"
                       data-position="' . $row->position . '"
                       data-year="' . $row->year . '"
                       data-status="' . $row->status . '">
                       <i class="fas fa-edit"></i> Edit
                    </a>
                    <a class="dropdown-item deleteResult" href="javascript:void(0);" 
                       data-id="' . $row->id . '">
                       <i class="fas fa-trash"></i> Delete
                    </a>
                </div>
            </div>';

            $data[] = [
                "id" => $sn,
                "subject" => '<span class="badge bg-primary">' . htmlspecialchars($row->subject_name ?? 'N/A') . '</span>',
                "class" => $row->class_name ?? 'N/A',
                "enrollment" => $row->enrollment,
                "student_name" => htmlspecialchars($row->student_name),
                "parent_name" => htmlspecialchars($row->parent_name),
                "phone" => $row->phone,
                "email" => $row->email,
                "marks" => '<strong>' . $row->marks . '</strong>',
                "rank" => $positionBadge,
                "status" => $statusBadge,
                "action" => $action
            ];

            $sn++;
        }

        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $data
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // ============================================================
    // GET SUBJECTS FOR DROPDOWN
    // ============================================================
    public function get_subjects()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('olympiad_subjects');
        $builder->where('status', 'Active');
        $builder->orderBy('subject_name', 'ASC');
        $query = $builder->get();
        $subjects = $query->getResult();
        return $this->response->setJSON($subjects);
    }

    // ============================================================
    // GET CLASSES FOR DROPDOWN
    // ============================================================
    public function get_classes()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('olympiad_classes');
        $builder->where('status', 'Active');
        $builder->orderBy('class_name', 'ASC');
        $query = $builder->get();
        $classes = $query->getResult();
        return $this->response->setJSON($classes);
    }

    // ============================================================
    // INSERT RESULT
    // ============================================================
    public function olympiad_result_save()
    {
        $db = \Config\Database::connect();

        $rules = [
            'subject_id' => 'required|numeric',
            'class_id' => 'required|numeric',
            'enrollment' => 'required|max_length[50]',
            'access_code' => 'required|max_length[50]',
            'student_name' => 'required|min_length[2]|max_length[100]',
            'parent_name' => 'required|min_length[2]|max_length[100]',
            'phone' => 'required|min_length[10]|max_length[15]',
            'email' => 'required|valid_email',
            'marks' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Check duplicate enrollment
        $checkBuilder = $db->table('olympiad_results');
        $checkBuilder->where('enrollment', $this->request->getPost('enrollment'));
        $existing = $checkBuilder->get()->getRow();
        
        if ($existing) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Enrollment number already exists!'
            ]);
        }

        $data = [
            'subject_id' => $this->request->getPost('subject_id'),
            'class_id' => $this->request->getPost('class_id'),
            'enrollment' => $this->request->getPost('enrollment'),
            'access_code' => $this->request->getPost('access_code'),
            'student_name' => $this->request->getPost('student_name'),
            'parent_name' => $this->request->getPost('parent_name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'school_name' => $this->request->getPost('school_name'),
            'marks' => $this->request->getPost('marks'),
            'rank' => $this->request->getPost('rank'),
            'position' => $this->request->getPost('position'),
            'year' => $this->request->getPost('year'),
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            $builder = $db->table('olympiad_results');
            $result = $builder->insert($data);
            
            if ($result) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Result added successfully!'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Failed to add result!'
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
    // UPDATE RESULT
    // ============================================================
    public function olympiad_result_update()
    {
        $db = \Config\Database::connect();
        $resultId = $this->request->getPost('edit_id');

        $rules = [
            'edit_subject_id' => 'required|numeric',
            'edit_class_id' => 'required|numeric',
            'edit_enrollment' => 'required|max_length[50]',
            'edit_access_code' => 'required|max_length[50]',
            'edit_student_name' => 'required|min_length[2]|max_length[100]',
            'edit_parent_name' => 'required|min_length[2]|max_length[100]',
            'edit_phone' => 'required|min_length[10]|max_length[15]',
            'edit_email' => 'required|valid_email',
            'edit_marks' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'subject_id' => $this->request->getPost('edit_subject_id'),
            'class_id' => $this->request->getPost('edit_class_id'),
            'enrollment' => $this->request->getPost('edit_enrollment'),
            'access_code' => $this->request->getPost('edit_access_code'),
            'student_name' => $this->request->getPost('edit_student_name'),
            'parent_name' => $this->request->getPost('edit_parent_name'),
            'phone' => $this->request->getPost('edit_phone'),
            'email' => $this->request->getPost('edit_email'),
            'school_name' => $this->request->getPost('edit_school_name'),
            'marks' => $this->request->getPost('edit_marks'),
            'rank' => $this->request->getPost('edit_rank'),
            'position' => $this->request->getPost('edit_position'),
            'year' => $this->request->getPost('edit_year'),
            'status' => $this->request->getPost('edit_status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $builder = $db->table('olympiad_results');
            $builder->where('id', $resultId);
            $result = $builder->update($data);
            
            if ($result) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Result updated successfully!'
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
    // DELETE RESULT
    // ============================================================
    public function olympiad_result_delete()
    {
        $db = \Config\Database::connect();
        $resultId = $this->request->getPost('id');

        try {
            $builder = $db->table('olympiad_results');
            $builder->where('id', $resultId);
            $result = $builder->delete();

            if ($result) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Result deleted successfully!'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Failed to delete result!'
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
// CSV IMPORT - Upload and Import CSV
// ============================================================
public function csv_import()
{
    $db = \Config\Database::connect();
    
    // Check if file uploaded
    $file = $this->request->getFile('csv_file');
    
    if (!$file || !$file->isValid()) {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'Please upload a valid CSV file.'
        ]);
    }
    
    // Check file extension
    $extension = $file->getExtension();
    if (!in_array($extension, ['csv', 'xlsx'])) {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'Only CSV and Excel files are allowed.'
        ]);
    }
    
    try {
        // Read CSV file
        $handle = fopen($file->getTempName(), "r");
        
        // Get headers and clean them
        $headers = fgetcsv($handle);
        
        // Clean headers - remove BOM, trim, convert to lowercase
        $headers = array_map(function($header) {
            // Remove BOM and trim
            $header = trim($header);
            $header = str_replace("\xEF\xBB\xBF", '', $header); // Remove UTF-8 BOM
            $header = strtolower($header); // Convert to lowercase
            $header = str_replace(' ', '_', $header); // Replace spaces with underscores
            return $header;
        }, $headers);
        
        // Debug: Log headers
        log_message('debug', 'CSV Headers: ' . print_r($headers, true));
        
        // Define expected columns with aliases
        $columnMap = [
            'subject_name' => ['subject_name', 'subject', 'subjectname', 'subject name'],
            'class_name' => ['class_name', 'class', 'classname', 'class name', 'grade', 'grade_name'],
            'enrollment' => ['enrollment', 'enrolment', 'enrollment_number', 'enrolment_number', 'reg_number', 'registration_number'],
            'access_code' => ['access_code', 'accesscode', 'code', 'access', 'accesskey'],
            'student_name' => ['student_name', 'studentname', 'student name', 'name', 'student', 'full_name'],
            'parent_name' => ['parent_name', 'parentname', 'parent name', 'father_name', 'mother_name', 'guardian'],
            'phone' => ['phone', 'mobile', 'contact', 'phone_number', 'mobile_number', 'telephone'],
            'email' => ['email', 'email_address', 'mail', 'emailid'],
            'school_name' => ['school_name', 'schoolname', 'school name', 'school', 'institution'],
            'marks' => ['marks', 'score', 'marks_obtained', 'obtained_marks', 'total_marks'],
            'rank' => ['rank', 'rank_position', 'position_rank'],
            'position' => ['position', 'pos', 'ranking', 'rank_position'],
            'year' => ['year', 'academic_year', 'session', 'academic'],
            'status' => ['status', 'result_status', 'active_status']
        ];
        
        // Map headers to standard columns
        $mappedColumns = [];
        $missingColumns = [];
        
        foreach ($columnMap as $standardCol => $aliases) {
            $found = false;
            foreach ($headers as $header) {
                if (in_array($header, $aliases)) {
                    $mappedColumns[$standardCol] = $header;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $missingColumns[] = $standardCol;
            }
        }
        
        // Check required columns
        $requiredColumns = ['subject_name', 'class_name', 'enrollment', 'student_name', 'parent_name', 'phone', 'email'];
        $missingRequired = array_intersect($requiredColumns, $missingColumns);
        
        if (!empty($missingRequired)) {
            fclose($handle);
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Required columns missing: ' . implode(', ', $missingRequired) . 
                            '. Please check your CSV headers. Expected: subject_name, class_name, enrollment, student_name, parent_name, phone, email',
                'headers_found' => $headers
            ]);
        }
        
        $imported = 0;
        $skipped = 0;
        $errors = [];
        $rowNumber = 1;
        
        // Start transaction
        $db->transBegin();
        
        while (($row = fgetcsv($handle)) !== FALSE) {
            $rowNumber++;
            
            // Skip if row has fewer columns than headers
            if (count($row) < count($headers)) {
                $skipped++;
                $errors[] = "Row $rowNumber: Incomplete data, skipping";
                continue;
            }
            
            // Combine headers with row data
            $rowData = [];
            foreach ($headers as $index => $header) {
                $rowData[$header] = $row[$index] ?? '';
            }
            
            // Map to standard columns
            $data = [];
            foreach ($mappedColumns as $standardCol => $actualHeader) {
                $data[$standardCol] = trim($rowData[$actualHeader] ?? '');
            }
            
            // Skip empty rows
            if (empty($data['enrollment']) && empty($data['student_name'])) {
                $skipped++;
                $errors[] = "Row $rowNumber: Empty row, skipping";
                continue;
            }
            
            // Get subject ID
            $subjectId = null;
            if (!empty($data['subject_name'])) {
                $subjectBuilder = $db->table('olympiad_subjects');
                $subjectBuilder->like('subject_name', $data['subject_name'], 'both');
                $subject = $subjectBuilder->get()->getRow();
                if ($subject) {
                    $subjectId = $subject->id;
                } else {
                    // Try with subject_code
                    $subjectBuilder = $db->table('olympiad_subjects');
                    $subjectBuilder->like('subject_code', $data['subject_name'], 'both');
                    $subject = $subjectBuilder->get()->getRow();
                    if ($subject) {
                        $subjectId = $subject->id;
                    }
                }
            }
            
            // Get class ID
            $classId = null;
            if (!empty($data['class_name'])) {
                $classBuilder = $db->table('olympiad_classes');
                $classBuilder->like('class_name', $data['class_name'], 'both');
                $class = $classBuilder->get()->getRow();
                if ($class) {
                    $classId = $class->id;
                }
            }
            
            // Prepare data for insertion
            $insertData = [
                'subject_id' => $subjectId,
                'class_id' => $classId,
                'enrollment' => $data['enrollment'],
                'access_code' => $data['access_code'] ?? 'ACC' . rand(100000, 999999),
                'student_name' => $data['student_name'],
                'parent_name' => $data['parent_name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'school_name' => $data['school_name'] ?? '',
                'marks' => $data['marks'] ?? '0',
                'rank' => $data['rank'] ?? '',
                'position' => $data['position'] ?? '',
                'year' => $data['year'] ?? date('Y') . '-' . (date('Y')+1),
                'status' => $data['status'] ?? 'Active',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            // Validate required fields
            if (empty($insertData['enrollment']) || empty($insertData['student_name'])) {
                $skipped++;
                $errors[] = "Row $rowNumber: Missing enrollment or student name";
                continue;
            }
            
            // Check for duplicate enrollment
            $checkBuilder = $db->table('olympiad_results');
            $checkBuilder->where('enrollment', $insertData['enrollment']);
            $existing = $checkBuilder->get()->getRow();
            
            if ($existing) {
                $skipped++;
                $errors[] = "Row $rowNumber: Enrollment '{$insertData['enrollment']}' already exists";
                continue;
            }
            
            // Insert data
            $builder = $db->table('olympiad_results');
            $result = $builder->insert($insertData);
            
            if ($result) {
                $imported++;
            } else {
                $skipped++;
                $errors[] = "Row $rowNumber: Failed to insert";
            }
        }
        
        fclose($handle);
        
        // Commit transaction
        $db->transCommit();
        
        return $this->response->setJSON([
            'status' => true,
            'message' => "Import completed! Imported: $imported, Skipped: $skipped",
            'imported' => $imported,
            'skipped' => $skipped,
            'errors' => $errors
        ]);
        
    } catch (\Exception $e) {
        if (isset($db)) {
            $db->transRollback();
        }
        return $this->response->setJSON([
            'status' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}

    // ============================================================
    // CSV EXPORT - Download CSV
    // ============================================================
    public function csv_export()
    {
        $db = \Config\Database::connect();
        
        // Get all results with joins
        $builder = $db->table('olympiad_results r');
        $builder->select('r.*, s.subject_name, s.subject_code, c.class_name');
        $builder->join('olympiad_subjects s', 's.id = r.subject_id', 'left');
        $builder->join('olympiad_classes c', 'c.id = r.class_id', 'left');
        $builder->orderBy('r.id', 'DESC');
        $query = $builder->get();
        $results = $query->getResult();
        
        // Set CSV headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="olympiad_results_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Add CSV headers
        fputcsv($output, [
            'ID', 'Subject Name', 'Subject Code', 'Class Name', 'Enrollment', 
            'Access Code', 'Student Name', 'Parent Name', 'Phone', 'Email',
            'School Name', 'Marks', 'Rank', 'Position', 'Year', 'Status', 'Created At'
        ]);
        
        // Add data rows
        foreach ($results as $row) {
            fputcsv($output, [
                $row->id,
                $row->subject_name ?? '',
                $row->subject_code ?? '',
                $row->class_name ?? '',
                $row->enrollment,
                $row->access_code,
                $row->student_name,
                $row->parent_name,
                $row->phone,
                $row->email,
                $row->school_name,
                $row->marks,
                $row->rank,
                $row->position,
                $row->year,
                $row->status,
                $row->created_at
            ]);
        }
        
        fclose($output);
        exit;
    }

 // ============================================================
// DOWNLOAD SAMPLE CSV
// ============================================================
public function download_sample_csv()
{
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="sample_olympiad_results.csv"');
    
    $output = fopen('php://output', 'w');
    
    // Add headers - use lowercase with underscores
    fputcsv($output, [
        'subject_name', 'class_name', 'enrollment', 'access_code',
        'student_name', 'parent_name', 'phone', 'email',
        'school_name', 'marks', 'rank', 'position', 'year', 'status'
    ]);
    
    // Add sample data
    fputcsv($output, [
        'Mathematics', 'Class 5', 'ENR2025001', 'ACC123456',
        'John Doe', 'Jane Doe', '9876543210', 'john@example.com',
        'Bright School', '95', '1', '1st', '2024-25', 'Active'
    ]);
    
    fputcsv($output, [
        'Science', 'Class 6', 'ENR2025002', 'ACC123457',
        'Jane Smith', 'John Smith', '9876543211', 'jane@example.com',
        'Smart School', '88', '2', '2nd', '2024-25', 'Active'
    ]);
    
    fputcsv($output, [
        'English', 'Class 7', 'ENR2025003', 'ACC123458',
        'Bob Johnson', 'Mary Johnson', '9876543212', 'bob@example.com',
        'Excel School', '92', '3', '3rd', '2024-25', 'Active'
    ]);
    
    fclose($output);
    exit;
}
    // ============================================
    // SUBJECT CRUD
    // ============================================
    public function subject_save()
    {
        $db = \Config\Database::connect();
        
        $rules = [
            'subject_name' => 'required|min_length[2]|max_length[100]',
            'subject_code' => 'required|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Check duplicate
        $checkBuilder = $db->table('olympiad_subjects');
        $checkBuilder->where('subject_code', $this->request->getPost('subject_code'));
        $existing = $checkBuilder->get()->getRow();
        
        if ($existing) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Subject code already exists!'
            ]);
        }

        $data = [
            'subject_name' => $this->request->getPost('subject_name'),
            'subject_code' => $this->request->getPost('subject_code'),
            'status' => $this->request->getPost('status') ?? 'Active',
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            $builder = $db->table('olympiad_subjects');
            $result = $builder->insert($data);
            if ($result) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Subject added successfully!'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function subject_update()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('edit_subject_id');

        $rules = [
            'edit_subject_name' => 'required|min_length[2]|max_length[100]',
            'edit_subject_code' => 'required|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'subject_name' => $this->request->getPost('edit_subject_name'),
            'subject_code' => $this->request->getPost('edit_subject_code'),
            'status' => $this->request->getPost('edit_status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $builder = $db->table('olympiad_subjects');
            $builder->where('id', $id);
            $result = $builder->update($data);
            if ($result) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Subject updated successfully!'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function subject_delete()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');

        try {
            $builder = $db->table('olympiad_subjects');
            $builder->where('id', $id);
            $result = $builder->delete();
            if ($result) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Subject deleted successfully!'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function subject_list()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('olympiad_subjects');
        $builder->orderBy('id', 'DESC');
        $query = $builder->get();
        $subjects = $query->getResult();
        return $this->response->setJSON($subjects);
    }

    // ============================================
    // CLASS CRUD
    // ============================================
    public function class_save()
    {
        $db = \Config\Database::connect();
        
        $rules = [
            'class_name' => 'required|min_length[2]|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Check duplicate
        $checkBuilder = $db->table('olympiad_classes');
        $checkBuilder->where('class_name', $this->request->getPost('class_name'));
        $existing = $checkBuilder->get()->getRow();
        
        if ($existing) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Class already exists!'
            ]);
        }

        $data = [
            'class_name' => $this->request->getPost('class_name'),
            'status' => $this->request->getPost('status') ?? 'Active',
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            $builder = $db->table('olympiad_classes');
            $result = $builder->insert($data);
            if ($result) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Class added successfully!'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function class_update()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('edit_class_id');

        $rules = [
            'edit_class_name' => 'required|min_length[2]|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'class_name' => $this->request->getPost('edit_class_name'),
            'status' => $this->request->getPost('edit_status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $builder = $db->table('olympiad_classes');
            $builder->where('id', $id);
            $result = $builder->update($data);
            if ($result) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Class updated successfully!'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function class_delete()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');

        try {
            $builder = $db->table('olympiad_classes');
            $builder->where('id', $id);
            $result = $builder->delete();
            if ($result) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Class deleted successfully!'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function class_list()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('olympiad_classes');
        $builder->orderBy('id', 'DESC');
        $query = $builder->get();
        $classes = $query->getResult();
        return $this->response->setJSON($classes);
    }
}