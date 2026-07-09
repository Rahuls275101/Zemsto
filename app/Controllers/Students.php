<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Commanmodel;

class Students extends BaseController
{
    // =============================================
    // INDEX - Main Page
    // =============================================
    public function index()
    {
        $commanmodel = new Commanmodel();
        $session = session();

        if (session()->get('admin_type') == 'Supar Admin' || session()->get('admin_type') == 'School') {
            
            $table_header = [
                ['data' => 'id'],
                ['data' => 'photo'],
                ['data' => 'student_name'],
                ['data' => 'user_email'],
                ['data' => 'user_phone'],
                ['data' => 'class_grade'],
                ['data' => 'school_name'],
                ['data' => 'gender'],
                ['data' => 'user_age'],
                ['data' => 'status'],
                ['data' => 'action']
            ];
            
            $data['table_column'] = json_encode($table_header);
            return view('admin/head')
                   . view('admin/sidebar')
                   . view('admin/students', $data)
                   . view('admin/footer');
        } else {
            return redirect()->back()->withInput();
        }
    }

    // =============================================
    // DATATABLE LIST
    // =============================================
    public function students_list()
    {
        $commanmodel = new Commanmodel();
        $draw = $_POST['draw'];
        $start = $_POST['start'];
        $length = $_POST['length'];
        
        // Filters
        $filters = [];
        
        if (!empty($_POST['user_type'])) {
            $filters[] = ['column' => 'user_type', 'value' => $_POST['user_type'], 'type' => 'where'];
        }
        if (!empty($_POST['status'])) {
            $filters[] = ['column' => 'user_status', 'value' => $_POST['status'], 'type' => 'where'];
        }
        if (!empty($_POST['approval'])) {
            $filters[] = ['column' => 'approval', 'value' => $_POST['approval'], 'type' => 'where'];
        }
        if (!empty($_POST['gender'])) {
            $filters[] = ['column' => 'gender', 'value' => $_POST['gender'], 'type' => 'where'];
        }

        if (session()->get('admin_type')=='School') { 
    $filters[] = [
    'column' => 'school_name',
    'value' => session()->get('id'),
    'type' => 'where',
];
}



        $order = ['column' => 'account_id', 'order' => 'DESC'];

        $result = $commanmodel->getDataFromTable('user_account', $filters, $order, $length, $start);
        $alldata = $result['filteredRecords'];
        $data = [];
        $sn = $start + 1;

        foreach ($alldata as $row) {
            
            // Student Photo
            $photo = '<img src="' . base_url('assets/user/' . $row->user_photo) . '" 
                      width="45" height="45" style="object-fit:cover; border-radius:50%; border:2px solid #4e73df;" 
                      onerror="this.src=\'' . base_url('assets/images/default-user.png') . '\'">';
            
            // Status Badge
            $statusBadge = '';
            if ($row->user_status == 'Active') {
                $statusBadge = '<span class="badge bg-success">Active</span>';
            } elseif ($row->user_status == 'Inactive') {
                $statusBadge = '<span class="badge bg-danger">Inactive</span>';
            } elseif ($row->user_status == 'Pending') {
                $statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
            } else {
                $statusBadge = '<span class="badge bg-secondary">' . $row->user_status . '</span>';
            }

            // Student Name (with fallback)
            $studentName = !empty($row->student_name) ? $row->student_name : $row->user_name;
            
            // View Button with all data
            $viewBtn = '
                <button class="view-btn viewStudent" 
                    data-account_id="' . $row->account_id . '"
                    data-user_id="' . $row->user_id . '"
                    data-user_name="' . $row->user_name . '"
                    data-user_email="' . $row->user_email . '"
                    data-user_phone="' . $row->user_phone . '"
                    data-user_type="' . $row->user_type . '"
                    data-date_of_birth="' . $row->date_of_birth . '"
                    data-user_age="' . $row->user_age . '"
                    data-gender="' . $row->gender . '"
              
                    data-user_country="' . $row->user_country . '"
                    data-user_state="' . $row->state . '"
                    data-user_city="' . $row->city . '"
                    data-user_address="' . $row->user_address . '"
                    data-user_pincode="' . $row->zip_code . '"
                    data-user_photo="' . $row->user_photo . '"
                    data-student_name="' . $row->student_name . '"
                    data-class_grade="' . $row->class_grade . '"
                    data-parent_name="' . $row->parent_name . '"
                    data-school_name="' . $row->school_name . '"
                    data-school_branch="' . $row->school_branch . '"
           >
                    <i class="fas fa-eye"></i> View
                </button>
            ';

            $data[] = [
                'id' => $sn++,
                'photo' => $photo,
                'student_name' => $studentName,
                'user_email' => $row->user_email,
                'user_phone' => $row->user_phone,
                'class_grade' => $row->class_grade ?? 'N/A',
                'school_name' => $row->school_name ?? 'N/A',
                'gender' => $row->gender ?? 'N/A',
                'user_age' => $row->user_age ?? 'N/A',
                'status' => $statusBadge,
                'action' => $viewBtn
            ];
        }

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $result['totalRecords'],
            'recordsFiltered' => $result['totalRecords'],
            'data' => $data
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
        // =============================================
    // CSV EXPORT - Download All Students Data
    // =============================================
    public function csv_export()
    {
        $commanmodel = new Commanmodel();
        $session = session();
        
        // Build filters based on user type
        $filters = [];
        
        if (session()->get('admin_type') == 'School') {
            $filters[] = [
                'column' => 'school_name',
                'value' => session()->get('id'),
                'type' => 'where'
            ];
        }
        
        // Get all students
        $order = ['column' => 'account_id', 'order' => 'DESC'];
        $result = $commanmodel->getDataFromTable('user_account', $filters, $order, 10000, 0);
        $students = $result['filteredRecords'] ?? [];
        
        // Set CSV headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="students_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Add CSV headers
        fputcsv($output, [
            'Account ID', 'Student Name', 'Email', 'Phone', 
            'Class/Grade', 'Parent Name', 'Date of Birth', 'Age', 
            'Gender', 'Country', 'State', 'City', 
            'Address', 'Zip/Pincode', 'School Name', 'School Branch', 
            'Status', 'Approval', 'Registration Date'
        ]);
        
        // Add data rows
        foreach ($students as $row) {
            $studentName = !empty($row->student_name) ? $row->student_name : $row->user_name;
            
            fputcsv($output, [
                $row->account_id ?? '',
                $studentName,
                $row->user_email ?? '',
                $row->user_phone ?? '',
                $row->class_grade ?? '',
                $row->parent_name ?? '',
                $row->date_of_birth ?? '',
                $row->user_age ?? '',
                $row->gender ?? '',
                $row->user_country ?? '',
                $row->state ?? '',
                $row->city ?? '',
                $row->user_address ?? '',
                $row->zip_code ?? '',
                $row->school_name ?? '',
                $row->school_branch ?? '',
                $row->user_status ?? '',
                $row->approval ?? '',
                $row->created_at ?? ''
            ]);
        }
        
        fclose($output);
        exit;
    }

    // =============================================
    // CSV EXPORT - Filtered Students Data
    // =============================================
    public function csv_export_filtered()
    {
        $commanmodel = new Commanmodel();
        $session = session();
        
        // Build filters from POST data
        $filters = [];
        
        if (!empty($_POST['user_type'])) {
            $filters[] = ['column' => 'user_type', 'value' => $_POST['user_type'], 'type' => 'where'];
        }
        if (!empty($_POST['status'])) {
            $filters[] = ['column' => 'user_status', 'value' => $_POST['status'], 'type' => 'where'];
        }
        if (!empty($_POST['approval'])) {
            $filters[] = ['column' => 'approval', 'value' => $_POST['approval'], 'type' => 'where'];
        }
        if (!empty($_POST['gender'])) {
            $filters[] = ['column' => 'gender', 'value' => $_POST['gender'], 'type' => 'where'];
        }
        
        if (session()->get('admin_type') == 'School') {
            $filters[] = [
                'column' => 'school_name',
                'value' => session()->get('id'),
                'type' => 'where'
            ];
        }
        
        // Get filtered students
        $order = ['column' => 'account_id', 'order' => 'DESC'];
        $result = $commanmodel->getDataFromTable('user_account', $filters, $order, 10000, 0);
        $students = $result['filteredRecords'] ?? [];
        
        // Set CSV headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="filtered_students_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Add CSV headers
        fputcsv($output, [
            'Account ID', 'Student Name', 'Email', 'Phone', 'Class/Grade', 
            'Parent Name', 'Date of Birth', 'Age', 'Gender', 'Country', 
            'State', 'City', 'Address', 'Zip/Pincode', 'School Name', 
            'School Branch', 'Status', 'Approval', 'Registration Date'
        ]);
        
        // Add data rows
        foreach ($students as $row) {
            $studentName = !empty($row->student_name) ? $row->student_name : $row->user_name;
            
            fputcsv($output, [
                $row->account_id ?? '',
                $studentName,
                $row->user_email ?? '',
                $row->user_phone ?? '',
                $row->class_grade ?? '',
                $row->parent_name ?? '',
                $row->date_of_birth ?? '',
                $row->user_age ?? '',
                $row->gender ?? '',
                $row->user_country ?? '',
                $row->state ?? '',
                $row->city ?? '',
                $row->user_address ?? '',
                $row->zip_code ?? '',
                $row->school_name ?? '',
                $row->school_branch ?? '',
                $row->user_status ?? '',
                $row->approval ?? '',
                $row->created_at ?? ''
            ]);
        }
        
        fclose($output);
        exit;
    }
}