<?php
namespace App\Controllers;

use CodeIgniter\Email\Email;
use App\Models\Commanmodel;
require_once(APPPATH . "Libraries/config.php");
require_once(APPPATH . "Libraries/razorpay-php/Razorpay.php");

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        $commanmodel = new Commanmodel();
        $usersession = $session->get('loggedin');
        
        if(!$usersession) {
            return redirect()->to('/login');
        }
        
        $userdata = $commanmodel->get_single_query('user_account', array('account_id' => $usersession['user_id']));
        
        // Get competition registrations
        $filters = [
            ['column' => 'account_id', 'value' => $usersession['user_id']]
        ];
        $orderBy = ['column' => 'id', 'order' => 'DESC'];
        $registrations = $commanmodel->getDataFromTable('competition_registrations', $filters, $orderBy, null, 0);
        
        $data = array(
            'title' => "Dashboard : Event", 
            'keyword' => "Dashboard : Event",
            'description' => "Dashboard : Event",
            'search' => '',
            'userdata' => $userdata,
            'registrations' => $registrations['filteredRecords'] ?? [],
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/images/logo.png')
        );

        return view('frontend/header', $data)
            . view('frontend/dashboard/index', $data)
            . view('frontend/footer');
    }
    
    public function update_user()
    {
        $session = session();
        $commanmodel = new Commanmodel();
        $usersession = $session->get('loggedin');
        
        if(!$usersession) {
            $response = [
                "title" => 'Error',
                "class" => 'error',
                "message" => 'User not logged in'
            ];
            echo json_encode($response);
            return;
        }
        
        // Registration form ke saare fields
        $data = array( 
            // Basic Information
            'student_name' => $this->request->getVar('student_name'),
            'user_name' => $this->request->getVar('student_name'),
            'class_grade' => $this->request->getVar('class_grade'),
            'parent_name' => $this->request->getVar('parent_name'),
            'user_phone' => $this->request->getVar('user_phone'),
            'user_email' => $this->request->getVar('user_email'),
            'user_address' => $this->request->getVar('user_address'),
            
            // Address Details
            'city' => $this->request->getVar('city'),
            'state' => $this->request->getVar('state'),
            'zip_code' => $this->request->getVar('zip_code'),
            'country' => $this->request->getVar('country'),
            
            // School Details
            'school_name' => $this->request->getVar('school_name'),
            'school_branch' => $this->request->getVar('school_branch'),
            
            // Personal Details
            'date_of_birth' => $this->request->getVar('date_of_birth'),
            'gender' => $this->request->getVar('gender'),
     
            
            // Competition Details
            'competition_type' => $this->request->getVar('competition_type'),
            
            
        );
        
        $where = array(             
            'account_id' => $usersession['user_id']
        );
        
        $updated = $commanmodel->update_query('user_account', $data, $where);
        
        if($updated) {
            // Update session data
            $session->set('loggedin', [
                'user_id' => $usersession['user_id'],
                'user_name' => $this->request->getVar('student_name'),
                'user_email' => $this->request->getVar('user_email'),
                'user_phone' => $this->request->getVar('user_phone'),
                'user_type' => $usersession['user_type'] ?? 1,
            ]);
            
            $response = [
                "title" => 'Success',
                "class" => 'success',
                "message" => 'Profile updated successfully'
            ];
        } else {
            $response = [
                "title" => 'Warning',
                "class" => 'warning',
                "message" => 'No changes made or update failed'
            ];
        }
        
        echo json_encode($response);
    }
    
    public function update_password()
    {
        $session = session();
        $commanmodel = new Commanmodel();
        $usersession = $session->get('loggedin');
        
        if(!$usersession) {
            $response = [
                "title" => 'Error',
                "class" => 'error',
                "message" => 'User not logged in'
            ];
            echo json_encode($response);
            return;
        }
        
        $current_password = $this->request->getVar('current_password');
        $new_password = $this->request->getVar('new_password');
        $confirm_password = $this->request->getVar('confirm_password');
        
        // Validate
        if(empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $response = [
                "title" => 'Error',
                "class" => 'error',
                "message" => 'All fields are required'
            ];
            echo json_encode($response);
            return;
        }
        
        if($new_password !== $confirm_password) {
            $response = [
                "title" => 'Error',
                "class" => 'error',
                "message" => 'New passwords do not match'
            ];
            echo json_encode($response);
            return;
        }
        
        if(strlen($new_password) < 6) {
            $response = [
                "title" => 'Error',
                "class" => 'error',
                "message" => 'Password must be at least 6 characters'
            ];
            echo json_encode($response);
            return;
        }
        
        // Get user data
        $userdata = $commanmodel->get_single_query('user_account', array('account_id' => $usersession['user_id']));
        
        // Verify current password
        if(!password_verify($current_password, $userdata->user_password)) {
            $response = [
                "title" => 'Error',
                "class" => 'error',
                "message" => 'Current password is incorrect'
            ];
            echo json_encode($response);
            return;
        }
        
        // Update password
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
        $updated = $commanmodel->update_query('user_account', 
            ['user_password' => $hashedPassword, 'updated_at' => date('Y-m-d H:i:s')], 
            ['account_id' => $usersession['user_id']]
        );
        
        if($updated) {
            $response = [
                "title" => 'Success',
                "class" => 'success',
                "message" => 'Password updated successfully'
            ];
        } else {
            $response = [
                "title" => 'Warning',
                "class" => 'warning',
                "message" => 'Failed to update password'
            ];
        }
        
        echo json_encode($response);
    }
}