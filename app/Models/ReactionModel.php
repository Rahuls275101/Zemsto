<?php

namespace App\Models;

use CodeIgniter\Model;

class ReactionModel extends Model
{
    protected $table = 'reactions';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'post_id', 
        'user_id', 
        'type', 
        'created_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'post_id' => 'required|numeric',
        'user_id' => 'required|numeric',
        'type' => 'required|in_list[like,love,haha,wow,sad,angry]'
    ];
    
    protected $validationMessages = [
        'type' => [
            'in_list' => 'Reaction type must be one of: like, love, haha, wow, sad, angry'
        ]
    ];
    
    // Get reactions for a specific post
    public function getReactionsByPost($postId)
    {
        return $this->select('reactions.*, user_account.user_name, user_account.user_photo')
                    ->join('user_account', 'user_account.account_id = reactions.user_id')
                    ->where('reactions.post_id', $postId)
                    ->orderBy('reactions.created_at', 'DESC')
                    ->findAll();
    }
    
    // Get reaction count by type for a post
    public function getReactionCounts($postId)
    {
        $reactions = $this->where('post_id', $postId)->findAll();
        
        $counts = [
            'like' => 0,
            'love' => 0,
            'haha' => 0,
            'wow' => 0,
            'sad' => 0,
            'angry' => 0,
            'total' => count($reactions)
        ];
        
        foreach ($reactions as $reaction) {
            $counts[$reaction['type']]++;
        }
        
        return $counts;
    }
    
    // Check if user has reacted to a post
    public function getUserReaction($postId, $userId)
    {
        return $this->where('post_id', $postId)
                    ->where('user_id', $userId)
                    ->first();
    }
    
    // Get most common reaction for a post
    public function getTopReaction($postId)
    {
        $reactions = $this->where('post_id', $postId)->findAll();
        
        if (empty($reactions)) {
            return null;
        }
        
        $counts = [];
        foreach ($reactions as $reaction) {
            $type = $reaction['type'];
            $counts[$type] = isset($counts[$type]) ? $counts[$type] + 1 : 1;
        }
        
        arsort($counts);
        return key($counts); // Returns the reaction type with highest count
    }
    
    // Remove a user's reaction from a post
    public function removeReaction($postId, $userId)
    {
        return $this->where('post_id', $postId)
                    ->where('user_id', $userId)
                    ->delete();
    }
    
    // Get reaction summary (for display like Facebook)
    public function getReactionSummary($postId)
    {
        $reactions = $this->where('post_id', $postId)->findAll();
        
        if (empty($reactions)) {
            return ['total' => 0, 'types' => []];
        }
        
        $summary = [];
        $reactionTypes = ['like', 'love', 'haha', 'wow', 'sad', 'angry'];
        
        foreach ($reactionTypes as $type) {
            $count = 0;
            foreach ($reactions as $reaction) {
                if ($reaction['type'] === $type) {
                    $count++;
                }
            }
            if ($count > 0) {
                $summary[$type] = $count;
            }
        }
        
        return [
            'total' => count($reactions),
            'types' => $summary
        ];
    }
}