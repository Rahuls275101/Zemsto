<?php

namespace App\Controllers;

use App\Models\Commanmodel;

class CompetitionController extends BaseController
{
    public function index()
    {
        $session = session();
        if(session()->get('admin_type')=='Supar Admin' or session()->get('admin_type')=='School' ) {
            
            $data['table_name'] = 'competitions';
    
            $table_header = [
                ['data' => 'id'],
                ['data' => 'image'],
                ['data' => 'title'],
                ['data' => 'status'],
                ['data' => 'action'],
            ];
            
            $data['table_column'] = json_encode($table_header);
         
            return view('admin/head')
                . view('admin/sidebar')
                . view('admin/competitions', $data)
                . view('admin/footer');
        } else {
            $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
            return redirect()->back()->withInput();
        }
    }

    public function competition_list()
    {
        $session = session();
        $commanmodel = new Commanmodel();

        $draw = $_POST['draw'];
        $start = $_POST['start'];
        $length = $_POST['length'];
        $search = $_POST['search']['value'];
        
        $filters = [];

        if (!empty($search)) {
            $filters[] = [
                'column' => 'title',
                'value' => $search,
                'type' => 'like',
            ];
        }
        
        
        if (session()->get('admin_type')=='School') { 
    $filters[] = [
    'column' => 'created_by',
    'value' => session()->get('id'),
    'type' => 'where',
];
}

        if (!empty($_POST['order'])) {
            $order = [
                'column' => 'id',
                'order' => 'DESC',
            ];
        }

        $result = $commanmodel->getDataFromTable('competitions', $filters, $order, $length, $start);

        $alldata = $result['filteredRecords'];
        $data = [];
        $sn = $start + 1;

        foreach ($alldata as $competition) {
            $image = '<img src="' . base_url('uploads/competitions/' . $competition->image) . '" alt="' . $competition->title . '" style="width:80px; height:60px; object-fit:cover;">';
            
            $status_badge = '<span class="badge badge-' . ($competition->status == 'Active' ? 'success' : 'danger') . '">' . $competition->status . '</span>';
            
            $action = '<button type="button" class="btn btn-primary btn-sm edit-btn" data-id="' . $competition->id . '">
                            <i class="mdi mdi-pencil"></i> Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $competition->id . '">
                            <i class="mdi mdi-delete"></i> Delete
                        </button>';

            $data[] = [
                "id" => $sn,
                "image" => $image,
                "title" => $competition->title,
                "status" => $status_badge,
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

    public function add_competition()
    {
        $session = session();
        if(session()->get('admin_type')=='Supar Admin' or session()->get('admin_type')=='Promoter' or session()->get('admin_type')=='Franchise') {
            
            $commanmodel = new Commanmodel();
            helper(['form', 'url']);
            
            if(empty($this->request->getVar('title'))) {
                $session->setFlashdata('failed', 'Title is required');
                return redirect()->to('/admin/competitions');
            }

            // Main Image
            $file = $this->request->getFile('image');
            $mainImageName = '';
            if($file && $file->isValid() && !$file->hasMoved()) {
                $mainImageName = $file->getRandomName();
                $file->move('uploads/competitions/', $mainImageName);
            }
            
            // Poster Card Image
            $posterFile = $this->request->getFile('poster_card_image');
            $posterImageName = '';
            if($posterFile && $posterFile->isValid() && !$posterFile->hasMoved()) {
                $posterImageName = $posterFile->getRandomName();
                $posterFile->move('uploads/competitions/', $posterImageName);
            }
            
            // Counter Data
            $counterData = [];
            $counterIcons = $this->request->getVar('counter_icon') ?? [];
            $counterTexts = $this->request->getVar('counter_text') ?? [];
            $counterSubtexts = $this->request->getVar('counter_subtext') ?? [];
            
            for($i = 0; $i < count($counterIcons); $i++) {
                if(!empty($counterIcons[$i]) || !empty($counterTexts[$i])) {
                    $counterData[] = [
                        'icon' => $counterIcons[$i] ?? '',
                        'text' => $counterTexts[$i] ?? '',
                        'subtext' => $counterSubtexts[$i] ?? ''
                    ];
                }
            }
            
            // Features - Only Icon Image
            $featureData = [];
            $featureTitles = $this->request->getVar('feature_title') ?? [];
            $featureDescriptions = $this->request->getVar('feature_description') ?? [];
            
            // Icon Images
            $featureIconImages = $this->request->getFiles('feature_icon_image') ?? [];
            $featureIconNames = [];
            if(!empty($featureIconImages)) {
                foreach($featureIconImages as $key => $img) {
                    if($img && $img->isValid() && !$img->hasMoved()) {
                        $imgName = $img->getRandomName();
                        $img->move('uploads/features/', $imgName);
                        $featureIconNames[$key] = $imgName;
                    } else {
                        $featureIconNames[$key] = '';
                    }
                }
            }
            
            for($i = 0; $i < count($featureTitles); $i++) {
                if(!empty($featureTitles[$i])) {
                    $featureData[] = [
                        'icon_image' => $featureIconNames[$i] ?? '',
                        'title' => $featureTitles[$i] ?? '',
                        'description' => $featureDescriptions[$i] ?? ''
                    ];
                }
            }
            
            // Categories
            $categoryData = [];
            $categoryBadges = $this->request->getVar('category_badge') ?? [];
            $categoryTitles = $this->request->getVar('category_title') ?? [];
            $categoryColors = $this->request->getVar('category_color') ?? [];
            $themeIcons = $this->request->getVar('theme_icon') ?? [];
            $themeTitles = $this->request->getVar('theme_title') ?? [];
            $themeDescriptions = $this->request->getVar('theme_description') ?? [];
            
            for($i = 0; $i < count($categoryBadges); $i++) {
                if(!empty($categoryBadges[$i]) || !empty($categoryTitles[$i])) {
                    $themes = [];
                    $themeCount = count($themeIcons);
                    $themesPerCategory = ceil($themeCount / max(1, count($categoryBadges)));
                    $start = $i * $themesPerCategory;
                    $end = min($start + $themesPerCategory, $themeCount);
                    
                    for($j = $start; $j < $end; $j++) {
                        if(!empty($themeIcons[$j]) || !empty($themeTitles[$j])) {
                            $themes[] = [
                                'icon' => $themeIcons[$j] ?? '',
                                'title' => $themeTitles[$j] ?? '',
                                'description' => $themeDescriptions[$j] ?? ''
                            ];
                        }
                    }
                    
                    $categoryData[] = [
                        'badge' => $categoryBadges[$i] ?? '',
                        'title' => $categoryTitles[$i] ?? '',
                        'color' => $categoryColors[$i] ?? 'category-pink',
                        'themes' => $themes
                    ];
                }
            }
            
            // Requirements
            $requirementData = [];
            $reqIcons = $this->request->getVar('requirement_icon') ?? [];
            $reqTitles = $this->request->getVar('requirement_title') ?? [];
            $reqDescriptions = $this->request->getVar('requirement_description') ?? [];
            
            for($i = 0; $i < count($reqIcons); $i++) {
                if(!empty($reqIcons[$i]) || !empty($reqTitles[$i])) {
                    $requirementData[] = [
                        'icon' => $reqIcons[$i] ?? '',
                        'title' => $reqTitles[$i] ?? '',
                        'description' => $reqDescriptions[$i] ?? ''
                    ];
                }
            }
            
            // Prizes
            $prizeData = [];
            $prizeTypes = $this->request->getVar('prize_type') ?? [];
            $prizeIcons = $this->request->getVar('prize_icon') ?? [];
            $prizeTitles = $this->request->getVar('prize_title') ?? [];
            $prizeItems = $this->request->getVar('prize_items') ?? [];
            
            for($i = 0; $i < count($prizeTypes); $i++) {
                if(!empty($prizeTypes[$i])) {
                    $items = explode(',', $prizeItems[$i] ?? '');
                    $items = array_map('trim', $items);
                    $items = array_filter($items);
                    
                    $prizeData[] = [
                        'type' => $prizeTypes[$i] ?? 'participant',
                        'icon' => $prizeIcons[$i] ?? '',
                        'title' => $prizeTitles[$i] ?? '',
                        'items' => $items
                    ];
                }
            }
            
            // FAQs
            $faqData = [];
            $faqQuestions = $this->request->getVar('faq_question') ?? [];
            $faqAnswers = $this->request->getVar('faq_answer') ?? [];
            
            for($i = 0; $i < count($faqQuestions); $i++) {
                if(!empty($faqQuestions[$i])) {
                    $faqData[] = [
                        'question' => $faqQuestions[$i] ?? '',
                        'answer' => $faqAnswers[$i] ?? ''
                    ];
                }
            }
            
            // Steps
            $stepData = [];
            $stepIcons = $this->request->getVar('step_icon') ?? [];
            $stepTitles = $this->request->getVar('step_title') ?? [];
            $stepDescriptions = $this->request->getVar('step_description') ?? [];
            
            for($i = 0; $i < count($stepIcons); $i++) {
                if(!empty($stepIcons[$i]) || !empty($stepTitles[$i])) {
                    $stepData[] = [
                        'icon' => $stepIcons[$i] ?? '',
                        'title' => $stepTitles[$i] ?? '',
                        'description' => $stepDescriptions[$i] ?? ''
                    ];
                }
            }
      
            $postData = array(
                'title' => $this->request->getVar('title'),
                'description' => $this->request->getVar('description'),
                'image' => $mainImageName,
                'hero_title' => $this->request->getVar('hero_title'),
                'hero_description' => $this->request->getVar('hero_description'),
                'hero_status_badge' => $this->request->getVar('hero_status_badge'),
                'registration_deadline' => $this->request->getVar('registration_deadline'),
                'submission_deadline' => $this->request->getVar('submission_deadline'),
                'price_india' => $this->request->getVar('price_india'),
                'price_international' => $this->request->getVar('price_international'),
                'poster_card_title' => $this->request->getVar('poster_card_title'),
                'poster_card_description' => $this->request->getVar('poster_card_description'),
                'poster_card_image' => $posterImageName,
                'counter_data' => json_encode($counterData),
                'features' => json_encode($featureData),
                'categories' => json_encode($categoryData),
                'submission_requirements' => json_encode($requirementData),
                'prizes' => json_encode($prizeData),
                'faqs' => json_encode($faqData),
                'how_to_participate' => json_encode($stepData),
                'meta_keywords' => $this->request->getVar('meta_keywords'),
                'meta_description' => $this->request->getVar('meta_description'),
                'status' => $this->request->getVar('status'),
                'created_by' => session()->get('id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            $insertid = $commanmodel->insert_query_get_inserid('competitions', $postData);
            
            if($insertid) {
                $session->setFlashdata('created', 'Competition added successfully!');
                return redirect()->to('/admin/competitions');
            } else {
                $session->setFlashdata('failed', 'Failed to add competition.');
                return redirect()->to('/admin/competitions');
            }
        } else {
            $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
            return redirect()->back()->withInput();
        }
    }

    public function update_competition()
    {
        $session = session();
        if(session()->get('admin_type')=='Supar Admin' or session()->get('admin_type')=='Promoter' or session()->get('admin_type')=='Franchise') {
            
            $commanmodel = new Commanmodel();
            helper(['form', 'url']);
            
            $id = $this->request->getVar('id');
            $oldCompetition = $commanmodel->get_single_query('competitions', ['id' => $id]);
            
            if(!$oldCompetition) {
                $session->setFlashdata('failed', 'Competition not found.');
                return redirect()->to('/admin/competitions');
            }
            
            $postData = array(
                'title' => $this->request->getVar('title'),
                'description' => $this->request->getVar('description'),
                'hero_title' => $this->request->getVar('hero_title'),
                'hero_description' => $this->request->getVar('hero_description'),
                'hero_status_badge' => $this->request->getVar('hero_status_badge'),
                'registration_deadline' => $this->request->getVar('registration_deadline'),
                'submission_deadline' => $this->request->getVar('submission_deadline'),
                'price_india' => $this->request->getVar('price_india'),
                'price_international' => $this->request->getVar('price_international'),
                'poster_card_title' => $this->request->getVar('poster_card_title'),
                'poster_card_description' => $this->request->getVar('poster_card_description'),
                'status' => $this->request->getVar('status'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            // Main Image
            $file = $this->request->getFile('image');
            if($file && $file->isValid() && !$file->hasMoved()) {
                if($oldCompetition->image && file_exists('uploads/competitions/' . $oldCompetition->image)) {
                    unlink('uploads/competitions/' . $oldCompetition->image);
                }
                $newName = $file->getRandomName();
                $file->move('uploads/competitions/', $newName);
                $postData['image'] = $newName;
            }
            
            // Poster Card Image
            $posterFile = $this->request->getFile('poster_card_image');
            if($posterFile && $posterFile->isValid() && !$posterFile->hasMoved()) {
                if($oldCompetition->poster_card_image && file_exists('uploads/competitions/' . $oldCompetition->poster_card_image)) {
                    unlink('uploads/competitions/' . $oldCompetition->poster_card_image);
                }
                $newName = $posterFile->getRandomName();
                $posterFile->move('uploads/competitions/', $newName);
                $postData['poster_card_image'] = $newName;
            }
            
            // Counter Data
            $counterData = [];
            $counterIcons = $this->request->getVar('edit_counter_icon') ?? [];
            $counterTexts = $this->request->getVar('edit_counter_text') ?? [];
            $counterSubtexts = $this->request->getVar('edit_counter_subtext') ?? [];
            
            for($i = 0; $i < count($counterIcons); $i++) {
                if(!empty($counterIcons[$i]) || !empty($counterTexts[$i])) {
                    $counterData[] = [
                        'icon' => $counterIcons[$i] ?? '',
                        'text' => $counterTexts[$i] ?? '',
                        'subtext' => $counterSubtexts[$i] ?? ''
                    ];
                }
            }
            $postData['counter_data'] = json_encode($counterData);
            
            // Features - Only Icon Image
            $oldFeatures = json_decode($oldCompetition->features ?? '[]', true);
            $featureData = [];
            $featureTitles = $this->request->getVar('edit_feature_title') ?? [];
            $featureDescriptions = $this->request->getVar('edit_feature_description') ?? [];
            
            // Icon Images
  $files = $this->request->getFiles();

$featureIconImages = $files['edit_feature_icon_image'] ?? [];

$featureIconNames = [];

foreach ($featureIconImages as $key => $img) {

    if ($img instanceof \CodeIgniter\HTTP\Files\UploadedFile
        && $img->isValid()
        && !$img->hasMoved()) {

        if (
            isset($oldFeatures[$key]['icon_image']) &&
            !empty($oldFeatures[$key]['icon_image']) &&
            file_exists(FCPATH . 'uploads/features/' . $oldFeatures[$key]['icon_image'])
        ) {
            unlink(FCPATH . 'uploads/features/' . $oldFeatures[$key]['icon_image']);
        }

        $imgName = $img->getRandomName();
        $img->move(FCPATH . 'uploads/features/', $imgName);

        $featureIconNames[$key] = $imgName;

    } else {

        $featureIconNames[$key] = $oldFeatures[$key]['icon_image'] ?? '';
    }
}
            
            for($i = 0; $i < count($featureTitles); $i++) {
                if(!empty($featureTitles[$i])) {
                    $featureData[] = [
                        'icon_image' => $featureIconNames[$i] ?? '',
                        'title' => $featureTitles[$i] ?? '',
                        'description' => $featureDescriptions[$i] ?? ''
                    ];
                }
            }
            $postData['features'] = json_encode($featureData);
            
            // Categories
            $categoryData = [];
            $categoryBadges = $this->request->getVar('edit_category_badge') ?? [];
            $categoryTitles = $this->request->getVar('edit_category_title') ?? [];
            $categoryColors = $this->request->getVar('edit_category_color') ?? [];
            $themeIcons = $this->request->getVar('edit_theme_icon') ?? [];
            $themeTitles = $this->request->getVar('edit_theme_title') ?? [];
            $themeDescriptions = $this->request->getVar('edit_theme_description') ?? [];
            
            for($i = 0; $i < count($categoryBadges); $i++) {
                if(!empty($categoryBadges[$i]) || !empty($categoryTitles[$i])) {
                    $themes = [];
                    $themeCount = count($themeIcons);
                    $categoriesCount = count($categoryBadges);
                    $themesPerCategory = $categoriesCount > 0 ? ceil($themeCount / $categoriesCount) : 0;
                    $start = $i * $themesPerCategory;
                    $end = min($start + $themesPerCategory, $themeCount);
                    
                    for($j = $start; $j < $end; $j++) {
                        if(!empty($themeIcons[$j]) || !empty($themeTitles[$j])) {
                            $themes[] = [
                                'icon' => $themeIcons[$j] ?? '',
                                'title' => $themeTitles[$j] ?? '',
                                'description' => $themeDescriptions[$j] ?? ''
                            ];
                        }
                    }
                    
                    $categoryData[] = [
                        'badge' => $categoryBadges[$i] ?? '',
                        'title' => $categoryTitles[$i] ?? '',
                        'color' => $categoryColors[$i] ?? 'category-pink',
                        'themes' => $themes
                    ];
                }
            }
            $postData['categories'] = json_encode($categoryData);
            
            // Requirements
            $requirementData = [];
            $reqIcons = $this->request->getVar('edit_requirement_icon') ?? [];
            $reqTitles = $this->request->getVar('edit_requirement_title') ?? [];
            $reqDescriptions = $this->request->getVar('edit_requirement_description') ?? [];
            
            for($i = 0; $i < count($reqIcons); $i++) {
                if(!empty($reqIcons[$i]) || !empty($reqTitles[$i])) {
                    $requirementData[] = [
                        'icon' => $reqIcons[$i] ?? '',
                        'title' => $reqTitles[$i] ?? '',
                        'description' => $reqDescriptions[$i] ?? ''
                    ];
                }
            }
            $postData['submission_requirements'] = json_encode($requirementData);
            
            // Prizes
            $prizeData = [];
            $prizeTypes = $this->request->getVar('edit_prize_type') ?? [];
            $prizeIcons = $this->request->getVar('edit_prize_icon') ?? [];
            $prizeTitles = $this->request->getVar('edit_prize_title') ?? [];
            $prizeItems = $this->request->getVar('edit_prize_items') ?? [];
            
            for($i = 0; $i < count($prizeTypes); $i++) {
                if(!empty($prizeTypes[$i])) {
                    $items = explode(',', $prizeItems[$i] ?? '');
                    $items = array_map('trim', $items);
                    $items = array_filter($items);
                    
                    $prizeData[] = [
                        'type' => $prizeTypes[$i] ?? 'participant',
                        'icon' => $prizeIcons[$i] ?? '',
                        'title' => $prizeTitles[$i] ?? '',
                        'items' => $items
                    ];
                }
            }
            $postData['prizes'] = json_encode($prizeData);
            
            // FAQs
            $faqData = [];
            $faqQuestions = $this->request->getVar('edit_faq_question') ?? [];
            $faqAnswers = $this->request->getVar('edit_faq_answer') ?? [];
            
            for($i = 0; $i < count($faqQuestions); $i++) {
                if(!empty($faqQuestions[$i])) {
                    $faqData[] = [
                        'question' => $faqQuestions[$i] ?? '',
                        'answer' => $faqAnswers[$i] ?? ''
                    ];
                }
            }
            $postData['faqs'] = json_encode($faqData);
            
            // Steps
            $stepData = [];
            $stepIcons = $this->request->getVar('edit_step_icon') ?? [];
            $stepTitles = $this->request->getVar('edit_step_title') ?? [];
            $stepDescriptions = $this->request->getVar('edit_step_description') ?? [];
            
            for($i = 0; $i < count($stepIcons); $i++) {
                if(!empty($stepIcons[$i]) || !empty($stepTitles[$i])) {
                    $stepData[] = [
                        'icon' => $stepIcons[$i] ?? '',
                        'title' => $stepTitles[$i] ?? '',
                        'description' => $stepDescriptions[$i] ?? ''
                    ];
                }
            }
            $postData['how_to_participate'] = json_encode($stepData);
            
            $postData['meta_keywords'] = $this->request->getVar('meta_keywords');
            $postData['meta_description'] = $this->request->getVar('meta_description');
            
            $where_data = ['id' => $id];
            $update = $commanmodel->update_query('competitions', $postData, $where_data);
            
            if($update) {
                $session->setFlashdata('created', 'Competition updated successfully!');
                return redirect()->to('/admin/competitions');
            } else {
                $session->setFlashdata('failed', 'Failed to update competition.');
                return redirect()->to('/admin/competitions');
            }
        } else {
            $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
            return redirect()->back()->withInput();
        }
    }

    public function delete_competition()
    {
        $session = session();
        if(session()->get('admin_type')=='Supar Admin' or session()->get('admin_type')=='Promoter' or session()->get('admin_type')=='Franchise') {
            
            $commanmodel = new Commanmodel();
            $id = $this->request->getVar('id');
            
            $competition = $commanmodel->get_single_query('competitions', ['id' => $id]);
            if($competition) {
                if($competition->image && file_exists('uploads/competitions/' . $competition->image)) {
                    unlink('uploads/competitions/' . $competition->image);
                }
                if($competition->poster_card_image && file_exists('uploads/competitions/' . $competition->poster_card_image)) {
                    unlink('uploads/competitions/' . $competition->poster_card_image);
                }
                
                // Delete feature icon images only
                if($competition->features) {
                    $features = json_decode($competition->features, true);
                    if(is_array($features)) {
                        foreach($features as $feature) {
                            if(isset($feature['icon_image']) && $feature['icon_image'] && file_exists('uploads/features/' . $feature['icon_image'])) {
                                unlink('uploads/features/' . $feature['icon_image']);
                            }
                        }
                    }
                }
            }
            
            $delete = $commanmodel->delete_query('competitions', ['id' => $id]);
            
            if($delete) {
                echo json_encode(['success' => true, 'message' => 'Competition deleted successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete competition.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access!']);
        }
    }
    
    public function get_competition_data()
    {
        $commanmodel = new Commanmodel();
        $id = $this->request->getVar('id');
        
        $competition = $commanmodel->get_single_query('competitions', ['id' => $id]);
        
        if($competition) {
            echo json_encode(['success' => true, 'data' => $competition]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Competition not found.']);
        }
    }
}