<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CommentModel;
use App\Models\UserModel;
use App\Models\ReactionModel;

class PostController extends BaseController
{
    protected $postModel;
    protected $commentModel;
    protected $userModel;
    protected $reactionModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->commentModel = new CommentModel();
        $this->userModel = new UserModel();
        $this->reactionModel = new ReactionModel();
    }

    // Helper method to get user ID from session
    private function getUserId()
    {
        $session = session();
        $usersession = $session->get('loggedin');
        return isset($usersession['user_id']) ? $usersession['user_id'] : null;
    }

    // Create new post
  public function createPost()
{
    // Check if user is logged in
    $userId = $this->getUserId();
    if (!$userId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Please login to create a post'
        ]);
    }

    // Validation rules
    $rules = [
        'content' => 'required|min_length[1]|max_length[5000]',
        // hex color validation using regex (instead of valid_color)
        'background_color' => 'permit_empty|regex_match[/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/]',
        'feeling' => 'permit_empty|max_length[100]',
        'location' => 'permit_empty|max_length[255]',
        // file validation (optional)
        'media' => 'permit_empty|max_size[media,10240]|ext_in[media,jpg,jpeg,png,gif,webp,mp4,mov,avi,mkv]'
    ];

    if (!$this->validate($rules)) {
        return $this->response->setJSON([
            'success' => false,
            'errors' => $this->validator->getErrors()
        ]);
    }

    // tagged_users can be array or string
    $taggedUsers = $this->request->getPost('tagged_users');
    if (is_string($taggedUsers)) {
        // if it comes as JSON string already
        $decoded = json_decode($taggedUsers, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $taggedUsers = $decoded;
        }
    }

    $data = [
        'user_id' => $userId,
        'content' => trim((string) $this->request->getPost('content')),
        'background_color' => $this->request->getPost('background_color') ?: '#ffffff',
        'feeling' => $this->request->getPost('feeling'),
        'location' => $this->request->getPost('location'),
        'tagged_users' => !empty($taggedUsers) ? json_encode($taggedUsers) : null
    ];

    // Handle file upload
    $mediaFile = $this->request->getFile('media');

    if ($mediaFile && $mediaFile->isValid() && !$mediaFile->hasMoved()) {
        try {
            $uploadPath = ROOTPATH . 'public/assets/uploads/posts/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = $mediaFile->getRandomName();
            $mediaFile->move($uploadPath, $newName);

            $data['media_url']  = 'assets/uploads/posts/' . $newName;

            $mime = $mediaFile->getClientMimeType(); // better
            $data['media_type'] = (strpos($mime, 'image/') === 0) ? 'image' : 'video';

        } catch (\Throwable $e) {
            log_message('error', 'File upload error: ' . $e->getMessage());
            // optional: return error
            return $this->response->setJSON([
                'success' => false,
                'message' => 'File upload failed'
            ]);
        }
    }

    try {
        $postId = $this->postModel->insert($data);

        if (!$postId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to create post'
            ]);
        }

        $post = $this->postModel->getPostWithUser($postId);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Post created successfully',
            'post' => $post
        ]);

    } catch (\Throwable $e) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to create post: ' . $e->getMessage()
        ]);
    }
}


    // Add comment
    public function addComment()
    {
        // Check if user is logged in
        $userId = $this->getUserId();
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to comment'
            ]);
        }

        $validation = \Config\Services::validation();
        
        $rules = [
            'post_id' => 'required|numeric',
            'content' => 'required|min_length[1]|max_length[2000]',
            'parent_id' => 'permit_empty|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        $data = [
            'post_id' => $this->request->getPost('post_id'),
            'user_id' => $userId,
            'parent_id' => $this->request->getPost('parent_id') ?? 0,
            'content' => $this->request->getPost('content')
        ];

        try {
            $commentId = $this->commentModel->insert($data);
            $comment = $this->commentModel->getCommentWithUser($commentId);
            
            // Get updated comment count
            $commentCount = $this->commentModel->getCommentCount($data['post_id']);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Comment added successfully',
                'comment' => $comment,
                'comment_count' => $commentCount
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add comment: ' . $e->getMessage()
            ]);
        }
    }

    // Get comments for a specific post
    public function getPostComments($postId)
    {
        try {
            $comments = $this->commentModel->getCommentsByPost($postId);
            $commentCount = $this->commentModel->getCommentCount($postId);
            
            return $this->response->setJSON([
                'success' => true,
                'comments' => $comments,
                'total_comments' => $commentCount
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to fetch comments: ' . $e->getMessage()
            ]);
        }
    }

    // Add reaction
    public function addReaction()
    {
        // Check if user is logged in
        $userId = $this->getUserId();
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to react'
            ]);
        }

        $validation = \Config\Services::validation();
        
        $rules = [
            'post_id' => 'required|numeric',
            'type' => 'required|in_list[like,love,haha,wow,sad,angry]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        $postId = $this->request->getPost('post_id');
        $type = $this->request->getPost('type');

        try {
            // Check if user already reacted
            $existingReaction = $this->reactionModel
                ->where('post_id', $postId)
                ->where('user_id', $userId)
                ->first();

            if ($existingReaction) {
                if ($existingReaction['type'] === $type) {
                    // Remove reaction if same type clicked
                    $this->reactionModel->delete($existingReaction['id']);
                    $action = 'removed';
                } else {
                    // Update reaction type
                    $this->reactionModel->update($existingReaction['id'], ['type' => $type]);
                    $action = 'updated';
                }
            } else {
                // Add new reaction
                $this->reactionModel->insert([
                    'post_id' => $postId,
                    'user_id' => $userId,
                    'type' => $type
                ]);
                $action = 'added';
            }

            // Get updated reaction count
            $reactions = $this->reactionModel
                ->where('post_id', $postId)
                ->findAll();

            // Get reaction summary
            $reactionSummary = [];
            $reactionTypes = ['like', 'love', 'haha', 'wow', 'sad', 'angry'];
            foreach ($reactionTypes as $reactionType) {
                $count = array_filter($reactions, function($reaction) use ($reactionType) {
                    return $reaction['type'] === $reactionType;
                });
                if (count($count) > 0) {
                    $reactionSummary[$reactionType] = count($count);
                }
            }

            // Get current user's reaction
            $userReaction = $this->reactionModel
                ->where('post_id', $postId)
                ->where('user_id', $userId)
                ->first();

            return $this->response->setJSON([
                'success' => true,
                'action' => $action,
                'reactions' => $reactions,
                'reaction_summary' => $reactionSummary,
                'user_reaction' => $userReaction ? $userReaction['type'] : null,
                'total' => count($reactions)
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update reaction: ' . $e->getMessage()
            ]);
        }
    }

    // Get posts with pagination
    public function getPosts($page = 1)
    {
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        try {
            $posts = $this->postModel->getPostsWithUsers($perPage, $offset);

            // Add comment count, reaction count, and user reaction to each post
            foreach ($posts as &$post) {
                $post['comment_count'] = $this->commentModel
                    ->where('post_id', $post['id'])
                    ->countAllResults();
                
                $post['reactions'] = $this->reactionModel
                    ->where('post_id', $post['id'])
                    ->findAll();
                
                $userId = $this->getUserId();
                $post['user_has_reacted'] = null;
                if ($userId) {
                    $post['user_has_reacted'] = $this->reactionModel
                        ->where('post_id', $post['id'])
                        ->where('user_id', $userId)
                        ->first();
                }
                
                // Format date
                $post['formatted_date'] = $this->formatDate($post['created_at']);
            }

            return $this->response->setJSON([
                'success' => true,
                'posts' => $posts,
                'current_page' => $page,
                'per_page' => $perPage
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to fetch posts: ' . $e->getMessage()
            ]);
        }
    }

    // Delete post
    public function deletePost($postId)
    {
        // Check if user is logged in
        $userId = $this->getUserId();
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to delete post'
            ]);
        }

        try {
            $post = $this->postModel->find($postId);
            
            // Check if user owns the post
            if ($post['user_id'] != $userId) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You are not authorized to delete this post'
                ]);
            }

            // Delete post (cascade will delete comments and reactions)
            $this->postModel->delete($postId);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Post deleted successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete post: ' . $e->getMessage()
            ]);
        }
    }

    // Format date to Facebook-style
    private function formatDate($dateString)
    {
        $date = new \DateTime($dateString);
        $now = new \DateTime();
        $diff = $now->diff($date);
        
        if ($diff->y > 0) {
            return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
        } elseif ($diff->m > 0) {
            return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
        } elseif ($diff->d > 0) {
            return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
        } elseif ($diff->h > 0) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
        } elseif ($diff->i > 0) {
            return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
        } else {
            return 'Just now';
        }
    }
}