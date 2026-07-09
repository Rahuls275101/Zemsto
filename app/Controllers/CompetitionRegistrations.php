<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Commanmodel;

class CompetitionRegistrations extends BaseController
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
                ['data' => 'student'],
                ['data' => 'email'],
                ['data' => 'phone'],
                ['data' => 'class'],
                ['data' => 'school'],
                ['data' => 'competition'],
                ['data' => 'price'],
                ['data' => 'type'],
                ['data' => 'payment'],
                ['data' => 'created'],
                ['data' => 'action']
            ];
            
            $data['table_column'] = json_encode($table_header);
            return view('admin/head')
                   . view('admin/sidebar')
                   . view('admin/competition_registrations', $data)
                   . view('admin/footer');
        } else {
            return redirect()->back()->withInput();
        }
    }

    // =============================================
    // DATATABLE LIST
    // =============================================
    public function competition_registrations_list()
    {
        $commanmodel = new Commanmodel();
        $draw = $_POST['draw'];
        $start = $_POST['start'];
        $length = $_POST['length'];

        $filters = [];
        $order = ['column' => 'id', 'order' => 'DESC'];
        
        
                if (session()->get('admin_type')=='School') { 
    $filters[] = [
    'column' => 'competition_school_id',
    'value' => session()->get('id'),
    'type' => 'where',
];
}

        $result = $commanmodel->getDataFromTable('competition_registrations', $filters, $order, $length, $start);
        $alldata = $result['filteredRecords'];
        $data = [];
        $sn = $start + 1;

        foreach ($alldata as $row) {
            
            // Get Student Info from user_account table
            $student = $commanmodel->getDataFromTable(
                'user_account',
                [['column' => 'account_id', 'value' => $row->account_id, 'type' => 'where']]
            );
            
            $studentData = !empty($student['filteredRecords']) ? $student['filteredRecords'][0] : null;
            
            // Student Name
            $studentName = '-';
            $studentEmail = '-';
            $studentPhone = '-';
            $studentClass = '-';
            $studentSchool = '-';
            $studentGender = '-';
            $studentPhoto = '';
            
            if ($studentData) {
                $studentName = !empty($studentData->student_name) ? $studentData->student_name : $studentData->user_name;
                $studentEmail = $studentData->user_email ?? '-';
                $studentPhone = $studentData->user_phone ?? '-';
                $studentClass = $studentData->class_grade ?? '-';
                $studentSchool = $studentData->school_name ?? '-';
                $studentGender = $studentData->gender ?? '-';
                $studentPhoto = $studentData->user_photo ?? '';
            }
            
            // Student Info with Photo
            $photoHtml = '<img src="' . base_url('assets/user/' . $studentPhoto) . '" 
                          width="35" height="35" style="object-fit:cover; border-radius:50%; border:2px solid #4e73df;" 
                          onerror="this.src=\'' . base_url('assets/images/default-user.png') . '\'">';
            
            $studentHtml = $photoHtml . ' <span>' . $studentName . '</span>';
            
            // Registration Status Badge
            $regBadge = '';
            if ($row->registration_status == 'confirmed') {
                $regBadge = '<span class="badge bg-success">Confirmed</span>';
            } elseif ($row->registration_status == 'pending') {
                $regBadge = '<span class="badge bg-warning text-dark">Pending</span>';
            } elseif ($row->registration_status == 'cancelled') {
                $regBadge = '<span class="badge bg-danger">Cancelled</span>';
            } else {
                $regBadge = '<span class="badge bg-secondary">' . $row->registration_status . '</span>';
            }

            // Payment Status Badge
            $payBadge = '';
            if ($row->payment_status == 'completed') {
                $payBadge = '<span class="badge bg-success">Completed</span>';
            } elseif ($row->payment_status == 'pending') {
                $payBadge = '<span class="badge bg-warning text-dark">Pending</span>';
            } elseif ($row->payment_status == 'failed') {
                $payBadge = '<span class="badge bg-danger">Failed</span>';
            } elseif ($row->payment_status == 'refunded') {
                $payBadge = '<span class="badge bg-info">Refunded</span>';
            } else {
                $payBadge = '<span class="badge bg-secondary">' . $row->payment_status . '</span>';
            }

            // View Button with all data
            $viewBtn = '
                <button class="view-btn viewRecord" 
                    data-reg_id="' . $row->id . '"
                    data-account_id="' . $row->account_id . '"
                    data-student_name="' . $studentName . '"
                    data-student_email="' . $studentEmail . '"
                    data-student_phone="' . $studentPhone . '"
                    data-student_class="' . $studentClass . '"
                    data-student_school="' . $studentSchool . '"
                    data-student_gender="' . $studentGender . '"
                    data-student_photo="' . $studentPhoto . '"
                    data-comp_name="' . $row->competition_name . '"
                    data-comp_price="₹' . number_format($row->competition_price, 2) . '"
                    data-comp_type="' . ucfirst($row->competition_type) . '"
                    data-reg_status="' . $row->registration_status . '"
                    data-pay_status="' . $row->payment_status . '"
                    data-razorpay_order="' . ($row->razorpay_order_id ?? 'N/A') . '"
                    data-razorpay_payment="' . ($row->razorpay_payment_id ?? 'N/A') . '">
                    <i class="fas fa-eye"></i> View
                </button>
            ';

            $data[] = [
                'id' => $sn++,
                'student' => $studentHtml,
                'email' => $studentEmail,
                'phone' => $studentPhone,
                'class' => $studentClass,
                'school' => $studentSchool,
                'competition' => $row->competition_name,
                'price' => '₹' . number_format($row->competition_price, 2),
                'type' => ucfirst($row->competition_type),
                'payment' => $payBadge,
                'created' => date('d-M-Y', strtotime($row->created_at)),
                'action' => $viewBtn
            ];
        }

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $result['totalRecords'],
            'recordsFiltered' => $result['filteredRecordCount'],
            'data' => $data
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}