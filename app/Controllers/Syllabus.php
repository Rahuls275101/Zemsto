<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Commanmodel;

class Syllabus extends BaseController
{
    public function index()
    {
        $commanmodel = new Commanmodel();
        $session = session();

      
            $table_header = [
                ['data' => 'id'],
                ['data' => 'class_name'],
                ['data' => 'subject_name'],
                ['data' => 'image'],
                ['data' => 'pdf'],
                ['data' => 'questions'],
                ['data' => 'description'],
                ['data' => 'status'],
                ['data' => 'action'],
            ];
            $data['table_column'] = json_encode($table_header);
        
            
             return view('admin/head').view('admin/sidebar').view('admin/syllabus',$data).view('admin/footer');
       
    }

    // =============================================
    // SYLLABUS LIST
    // =============================================
    public function syllabus_list()
    {
        $commanmodel = new Commanmodel();
        $draw = $_POST['draw'];
        $start = $_POST['start'];
        $length = $_POST['length'];

        $filters = [];
        $order = ['column' => 'id', 'order' => 'DESC'];

        $result = $commanmodel->getDataFromTable('syllabus', $filters, $order, $length, $start);
        
      
        $alldata = $result['filteredRecords'];
         
        $data = [];
        $sn = $start + 1;

        foreach ($alldata as $row) {
            
            
            $image = '<img src="'.base_url('assets/syllabus/images/'.$row->image).'" width="50" height="50" style="object-fit:cover; border-radius:8px;">';
            
            $pdf = !empty($row->pdf_file) ? 
                '<a href="'.base_url('assets/syllabus/pdf/'.$row->pdf_file).'" target="_blank"><i class="mdi mdi-file" style="color:#dc3545; font-size:24px;"></i></a>' : 
                '<span class="text-muted">No PDF</span>';

            // Count Questions
            
         
            $questionCount = $commanmodel->get_single_query_count('syllabus_questions', array('syllabus_id' => $row->id));
              
            $questionsBtn = '<button class="btn btn-sm btn-info manageQuestions" data-id="'.$row->id.'" data-name="'.$row->subject_name.' ('.$row->class_name.')">
                                <i class="fas fa-question-circle"></i> '.$questionCount.'
                            </button>';

            $statusBadge = ($row->status == 'Active') ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';

            $action = '
               
                    <button class="btn btn-outline-primary btn-sm editRecord " 
                        data-id="'.$row->id.'"
                        data-class="'.$row->class_name.'"
                        data-subject="'.$row->subject_name.'"
                        data-description="'.$row->description.'"
                        data-status="'.$row->status.'"
                        data-image="'.$row->image.'"
                        data-pdf="'.$row->pdf_file.'">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-outline-danger btn-sm deleteRecord" data-id="'.$row->id.'">
                        <i class="fas fa-trash"></i> Delete
                    </button>
               
            ';

            $data[] = [
                'id' => $sn++,
                'class_name' => $row->class_name ,
                'subject_name' => $row->subject_name,
                'image' => $image,
                'pdf' => $pdf,
                'questions' => $questionsBtn,
                'description' => mb_substr($row->description, 0, 50, 'UTF-8') . '...',
                'status' => $statusBadge,
                'action' => $action
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
    // SYLLABUS SAVE
    // =============================================
    public function syllabus_save()
    {
        $commanmodel = new Commanmodel();

        $validated_image = $this->validate([
            'subject_image' => [
                'rules' => 'uploaded[subject_image]|is_image[subject_image]|mime_in[subject_image,image/jpg,image/jpeg,image/png,image/webp]'
            ]
        ]);

        $validated_pdf = $this->validate([
            'pdf_file' => [
                'rules' => 'uploaded[pdf_file]|mime_in[pdf_file,application/pdf]|max_size[pdf_file,5120]'
            ]
        ]);

        if ($validated_image) {
            $file = $this->request->getFile('subject_image');
            $image_name = $file->getRandomName();
            $file->move('assets/syllabus/images', $image_name);
        } else {
            $image_name = '';
        }

        if ($validated_pdf) {
            $pdf = $this->request->getFile('pdf_file');
            $pdf_name = $pdf->getRandomName();
            $pdf->move('assets/syllabus/pdf', $pdf_name);
        } else {
            $pdf_name = '';
        }

        $data = [
            'class_name' => $this->request->getVar('class_name'),
            'subject_name' => $this->request->getVar('subject_name'),
            'description' => $this->request->getVar('description'),
            'image' => $image_name,
            'pdf_file' => $pdf_name,
            'status' => $this->request->getVar('status'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $inserted = $commanmodel->insert_query('syllabus', $data);
        echo json_encode($inserted);
    }

    // =============================================
    // SYLLABUS UPDATE
    // =============================================
    public function syllabus_update()
    {
        $commanmodel = new Commanmodel();
        $id = $this->request->getVar('edit_syllabus_id');

        $oldData = $commanmodel->getDataFromTable('syllabus', [['column' => 'id', 'value' => $id, 'type' => 'where']]);
        $oldImage = $oldData['filteredRecords'][0]->image ?? '';
        $oldPdf = $oldData['filteredRecords'][0]->pdf_file ?? '';

        $validated_image = $this->validate([
            'edit_subject_image' => [
                'rules' => 'is_image[edit_subject_image]|mime_in[edit_subject_image,image/jpg,image/jpeg,image/png,image/webp]'
            ]
        ]);

        $validated_pdf = $this->validate([
            'edit_pdf_file' => [
                'rules' => 'mime_in[edit_pdf_file,application/pdf]|max_size[edit_pdf_file,5120]'
            ]
        ]);

        if ($validated_image && $this->request->getFile('edit_subject_image')->isValid()) {
            $file = $this->request->getFile('edit_subject_image');
            $image_name = $file->getRandomName();
            $file->move('assets/syllabus/images', $image_name);
            if ($oldImage && file_exists('assets/syllabus/images/' . $oldImage)) {
                unlink('assets/syllabus/images/' . $oldImage);
            }
        } else {
            $image_name = $this->request->getVar('edit_subject_image_old');
        }

        if ($validated_pdf && $this->request->getFile('edit_pdf_file')->isValid()) {
            $pdf = $this->request->getFile('edit_pdf_file');
            $pdf_name = $pdf->getRandomName();
            $pdf->move('assets/syllabus/pdf', $pdf_name);
            if ($oldPdf && file_exists('assets/syllabus/pdf/' . $oldPdf)) {
                unlink('assets/syllabus/pdf/' . $oldPdf);
            }
        } else {
            $pdf_name = $this->request->getVar('edit_pdf_file_old');
        }

        $data = [
            'class_name' => $this->request->getVar('edit_class_name'),
            'subject_name' => $this->request->getVar('edit_subject_name'),
            'description' => $this->request->getVar('edit_description'),
            'image' => $image_name,
            'pdf_file' => $pdf_name,
            'status' => $this->request->getVar('edit_status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $where = ['id' => $id];
        $updated = $commanmodel->update_query('syllabus', $data, $where);
        echo json_encode($updated);
    }

    // =============================================
    // SYLLABUS DELETE
    // =============================================
    public function syllabus_delete()
    {
        $commanmodel = new Commanmodel();
        $id = $this->request->getVar('id');

        $oldData = $commanmodel->getDataFromTable('syllabus', [['column' => 'id', 'value' => $id, 'type' => 'where']]);
        if (!empty($oldData['filteredRecords'])) {
            $record = $oldData['filteredRecords'][0];
            
            if ($record->image && file_exists('assets/syllabus/images/' . $record->image)) {
                unlink('assets/syllabus/images/' . $record->image);
            }
            if ($record->pdf_file && file_exists('assets/syllabus/pdf/' . $record->pdf_file)) {
                unlink('assets/syllabus/pdf/' . $record->pdf_file);
            }
            
            // Delete all questions for this syllabus
            $commanmodel->delete_query('syllabus_questions', ['syllabus_id' => $id]);
        }

        $where = ['id' => $id];
        $deleted = $commanmodel->delete_query('syllabus', $where);
        echo json_encode($deleted);
    }

    // =============================================
    // GET QUESTIONS
    // =============================================
    public function get_questions()
    {
        $commanmodel = new Commanmodel();
        $syllabusId = $this->request->getVar('syllabus_id');
        
        $questions = $commanmodel->getDataFromTable(
            'syllabus_questions', 
            [['column' => 'syllabus_id', 'value' => $syllabusId, 'type' => 'where']],
            ['column' => 'id', 'order' => 'ASC']
        );
        
        echo json_encode($questions['filteredRecords']);
    }

    // =============================================
    // ADD QUESTION
    // =============================================
    public function add_question()
    {
        $commanmodel = new Commanmodel();
        $syllabusId = $this->request->getVar('syllabus_id');

        // Get option A type and process
        $optionAType = $this->request->getVar('option_a_type');
        if ($optionAType == 'image') {
            $validated_a = $this->validate([
                'option_a_image' => [
                    'rules' => 'uploaded[option_a_image]|is_image[option_a_image]|mime_in[option_a_image,image/jpg,image/jpeg,image/png,image/webp]'
                ]
            ]);
            if ($validated_a) {
                $file = $this->request->getFile('option_a_image');
                $option_a_image = $file->getRandomName();
                $file->move('assets/questions', $option_a_image);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid Option A Image']);
                return;
            }
            $option_a_text = '';
        } else {
            $option_a_image = '';
            $option_a_text = $this->request->getVar('option_a_text');
        }

        // Get option B type and process
        $optionBType = $this->request->getVar('option_b_type');
        if ($optionBType == 'image') {
            $validated_b = $this->validate([
                'option_b_image' => [
                    'rules' => 'uploaded[option_b_image]|is_image[option_b_image]|mime_in[option_b_image,image/jpg,image/jpeg,image/png,image/webp]'
                ]
            ]);
            if ($validated_b) {
                $file = $this->request->getFile('option_b_image');
                $option_b_image = $file->getRandomName();
                $file->move('assets/questions', $option_b_image);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid Option B Image']);
                return;
            }
            $option_b_text = '';
        } else {
            $option_b_image = '';
            $option_b_text = $this->request->getVar('option_b_text');
        }
        
        
          $validated_question_image = $this->validate([
                'question_image' => [
                    'rules' => 'uploaded[question_image]|is_image[question_image]|mime_in[question_image,image/jpg,image/jpeg,image/png,image/webp]'
                ]
            ]);
            if ($validated_question_image) {
                $file = $this->request->getFile('question_image');
                $question_image = $file->getRandomName();
                $file->move('assets/questions', $question_image);
            } else {
               $question_image = '';
            }

        $data = [
            'syllabus_id' => $syllabusId,
            'question_text' => $this->request->getVar('question_text'),
            'question_image' => $question_image,
            'option_a_type' => $optionAType,
            'option_a_text' => $option_a_text,
            'option_a_image' => $option_a_image,
            'option_b_type' => $optionBType,
            'option_b_text' => $option_b_text,
            'option_b_image' => $option_b_image,
            'correct_answer' => $this->request->getVar('correct_answer'),
            'status' => $this->request->getVar('question_status') ?: 'Active',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $inserted = $commanmodel->insert_query('syllabus_questions', $data);
        echo json_encode(['success' => true, 'id' => $inserted]);
    }

    // =============================================
    // UPDATE QUESTION
    // =============================================
    public function update_question()
    {
        $commanmodel = new Commanmodel();
        $id = $this->request->getVar('edit_question_id');

        // Get old data
        $oldData = $commanmodel->getDataFromTable('syllabus_questions', [['column' => 'id', 'value' => $id, 'type' => 'where']]);
        $old = $oldData['filteredRecords'][0] ?? null;

        // Option A
        $optionAType = $this->request->getVar('edit_option_a_type');
        if ($optionAType == 'image') {
            $validated_a = $this->validate([
                'edit_option_a_image' => [
                    'rules' => 'is_image[edit_option_a_image]|mime_in[edit_option_a_image,image/jpg,image/jpeg,image/png,image/webp]'
                ]
            ]);
            if ($validated_a && $this->request->getFile('edit_option_a_image')->isValid()) {
                $file = $this->request->getFile('edit_option_a_image');
                $option_a_image = $file->getRandomName();
                $file->move('assets/questions', $option_a_image);
                if ($old && $old->option_a_image && file_exists('assets/questions/' . $old->option_a_image)) {
                    unlink('assets/questions/' . $old->option_a_image);
                }
            } else {
                $option_a_image = $this->request->getVar('edit_option_a_image_old');
            }
            $option_a_text = '';
        } else {
            $option_a_image = '';
            $option_a_text = $this->request->getVar('edit_option_a_text');
        }

        // Option B
        $optionBType = $this->request->getVar('edit_option_b_type');
        if ($optionBType == 'image') {
            $validated_b = $this->validate([
                'edit_option_b_image' => [
                    'rules' => 'is_image[edit_option_b_image]|mime_in[edit_option_b_image,image/jpg,image/jpeg,image/png,image/webp]'
                ]
            ]);
            if ($validated_b && $this->request->getFile('edit_option_b_image')->isValid()) {
                $file = $this->request->getFile('edit_option_b_image');
                $option_b_image = $file->getRandomName();
                $file->move('assets/questions', $option_b_image);
                if ($old && $old->option_b_image && file_exists('assets/questions/' . $old->option_b_image)) {
                    unlink('assets/questions/' . $old->option_b_image);
                }
            } else {
                $option_b_image = $this->request->getVar('edit_option_b_image_old');
            }
            $option_b_text = '';
        } else {
            $option_b_image = '';
            $option_b_text = $this->request->getVar('edit_option_b_text');
        }
        
        
           $validated_question_image = $this->validate([
                'edit_question_image' => [
                    'rules' => 'uploaded[edit_question_image]|is_image[edit_question_image]|mime_in[edit_question_image,image/jpg,image/jpeg,image/png,image/webp]'
                ]
            ]);
            if ($validated_question_image) {
                $file = $this->request->getFile('edit_question_image');
                $question_image = $file->getRandomName();
                $file->move('assets/questions', $question_image);
            } else {
               $question_image = $this->request->getVar('edit_question_image_old');
            }

        $data = [
            'question_text' => $this->request->getVar('edit_question_text'),
              'question_image' => $question_image,
            'option_a_type' => $optionAType,
            'option_a_text' => $option_a_text,
            'option_a_image' => $option_a_image,
            'option_b_type' => $optionBType,
            'option_b_text' => $option_b_text,
            'option_b_image' => $option_b_image,
            'correct_answer' => $this->request->getVar('edit_correct_answer'),
            'status' => $this->request->getVar('edit_question_status') ?: 'Active',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $where = ['id' => $id];
        $updated = $commanmodel->update_query('syllabus_questions', $data, $where);
        echo json_encode(['success' => true]);
    }

    // =============================================
    // DELETE QUESTION
    // =============================================
    public function delete_question()
    {
        $commanmodel = new Commanmodel();
        $id = $this->request->getVar('id');

        $oldData = $commanmodel->getDataFromTable('syllabus_questions', [['column' => 'id', 'value' => $id, 'type' => 'where']]);
        if (!empty($oldData['filteredRecords'])) {
            $record = $oldData['filteredRecords'][0];
            if ($record->option_a_image && file_exists('assets/questions/' . $record->option_a_image)) {
                unlink('assets/questions/' . $record->option_a_image);
            }
            if ($record->option_b_image && file_exists('assets/questions/' . $record->option_b_image)) {
                unlink('assets/questions/' . $record->option_b_image);
            }
        }

        $where = ['id' => $id];
        $deleted = $commanmodel->delete_query('syllabus_questions', $where);
        echo json_encode(['success' => true]);
    }
}