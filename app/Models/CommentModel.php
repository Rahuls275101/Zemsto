<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['post_id', 'user_id', 'parent_id', 'content'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Get comment with user info
    public function getCommentWithUser($commentId)
    {
        return $this->select('comments.*, 
                             user_account.account_id as user_account_id,
                             user_account.user_name as username,
                             user_account.user_photo as profile_image,
                             user_account.user_email as email')
                    ->join('user_account', 'user_account.account_id = comments.user_id')
                    ->where('comments.id', $commentId)
                    ->first();
    }
    
    // Get comments by post with replies
    public function getCommentsByPost($postId)
    {
        // Get parent comments
        $comments = $this->select('comments.*, 
                                 user_account.account_id as user_account_id,
                                 user_account.user_name as username,
                                 user_account.user_photo as profile_image,
                                 user_account.user_email as email')
                        ->join('user_account', 'user_account.account_id = comments.user_id')
                        ->where('comments.post_id', $postId)
                        ->where('comments.parent_id', 0)
                        ->orderBy('comments.created_at', 'ASC')
                        ->findAll();

        // Get replies for each comment
        foreach ($comments as &$comment) {
            $comment['replies'] = $this->select('comments.*, 
                                               user_account.account_id as user_account_id,
                                               user_account.user_name as username,
                                               user_account.user_photo as profile_image,
                                               user_account.user_email as email')
                                      ->join('user_account', 'user_account.account_id = comments.user_id')
                                      ->where('comments.post_id', $postId)
                                      ->where('comments.parent_id', $comment['id'])
                                      ->orderBy('comments.created_at', 'ASC')
                                      ->findAll();
        }

        return $comments;
    }
    
    // Get comment count for a post
    public function getCommentCount($postId)
    {
        return $this->where('post_id', $postId)->countAllResults();
    }
}