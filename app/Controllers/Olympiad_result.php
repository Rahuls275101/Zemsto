<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Commanmodel;

class Olympiad_result extends BaseController
{
    public function index()
    {
        $commanmodel = new Commanmodel();
        $db = \Config\Database::connect();

        // Get subjects from olympiad_subjects table
        $subjects = $db->table('olympiad_subjects')
                       ->where('status', 'Active')
                       ->orderBy('subject_name', 'ASC')
                       ->get()
                       ->getResult();

        $data['subjects'] = $subjects;

        $meta = $commanmodel->get_single_query('meta', ['meta_id' => 1]);

        $data['title'] = !empty($meta->meta_title) ? $meta->meta_title : 'Olympiad Result 2025-26';
        $data['keyword'] = $meta->meta_keyword ?? '';
        $data['description'] = $meta->meta_description ?? '';
        $data['pageimage'] = !empty($meta->meta_image)
            ? base_url('assets/meta/' . $meta->meta_image)
            : '';

        $data['pageurl'] = current_url();

        return view('frontend/header', $data)
            . view('frontend/olympiad_result', $data)
            . view('frontend/footer');
    }

    // ============================================================
    // SEARCH RESULT - Frontend AJAX
    // ============================================================
    public function search()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('olympiad_results r');
        $builder->select('r.*, s.subject_name, c.class_name');
        $builder->join('olympiad_subjects s', 's.id = r.subject_id', 'left');
        $builder->join('olympiad_classes c', 'c.id = r.class_id', 'left');
        $builder->where('r.status', 'Active');

        $subject_id   = trim($this->request->getPost('subject_id'));
        $enrollment   = trim($this->request->getPost('enrollment'));
        $access_code  = trim($this->request->getPost('accesscode'));
        $student_name = trim($this->request->getPost('studentname'));
        $parent_name  = trim($this->request->getPost('parentname'));
        $phone        = trim($this->request->getPost('phone'));
        $email        = trim($this->request->getPost('email'));

        if (!empty($subject_id)) {
            $builder->where('r.subject_id', $subject_id);
        }

        if (!empty($enrollment)) {
            $builder->like('r.enrollment', $enrollment);
        }

        if (!empty($access_code)) {
            $builder->like('r.access_code', $access_code);
        }

        if (!empty($student_name)) {
            $builder->like('r.student_name', $student_name);
        }

        if (!empty($parent_name)) {
            $builder->like('r.parent_name', $parent_name);
        }

        if (!empty($phone)) {
            $builder->like('r.phone', $phone);
        }

        if (!empty($email)) {
            $builder->like('r.email', $email);
        }

        $results = $builder->get()->getResult();

        $html = '';

        if (!empty($results)) {
            foreach ($results as $result) {
                $position = $result->position;

                if ($result->position == '1st') {
                    $position = '🥇 1st';
                } elseif ($result->position == '2nd') {
                    $position = '🥈 2nd';
                } elseif ($result->position == '3rd') {
                    $position = '🥉 3rd';
                }

                $subjectName = !empty($result->subject_name) ? $result->subject_name : $result->subject;
                $className = !empty($result->class_name) ? $result->class_name : $result->class;

                $html .= '
                <div class="result-card">
                    <div class="result-header">
                        <h4>' . esc($subjectName) . '</h4>
                        <span class="enrollment-badge">' . esc($result->enrollment) . '</span>
                    </div>
                    <div class="result-body">
                        <p><strong>Student:</strong> ' . esc($result->student_name) . '</p>
                        <p><strong>Parent:</strong> ' . esc($result->parent_name) . '</p>
                        <p><strong>Class:</strong> ' . esc($className) . '</p>
                        <p><strong>School:</strong> ' . esc($result->school_name) . '</p>
                        <p><strong>Marks:</strong> <span class="marks">' . esc($result->marks) . '</span></p>
                        <p><strong>Rank:</strong> <span class="rank">' . $position . '</span></p>
                    </div>
                </div>';
            }
        } else {
            $html = '<div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> No results found. Please check your details.
                     </div>';
        }

        return $this->response->setJSON([
            'status' => true,
            'count'  => count($results),
            'html'   => $html
        ]);
    }
}