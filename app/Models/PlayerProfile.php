<?php
/**
 * Player Profile Model
 * Handles player profile questionnaire data
 */

namespace App\Models;

use App\Core\Database;
use App\Core\Logger;

class PlayerProfile
{
    protected $table = 'player_profiles';

    /**
     * Create player profile
     */
    public static function create($userId, $data = [])
    {
        $query = "INSERT INTO player_profiles (user_id, created_at, updated_at) VALUES (?, NOW(), NOW())";
        
        try {
            Database::execute($query, [$userId]);
            $profileId = Database::connect()->lastInsertId();
            
            if (!empty($data)) {
                self::update($profileId, $data);
            }
            
            return $profileId;
        } catch (\Exception $e) {
            Logger::error('Player profile creation error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Find profile by user ID
     */
    public static function findByUserId($userId)
    {
        $query = "SELECT * FROM player_profiles WHERE user_id = ? LIMIT 1";
        $stmt = Database::execute($query, [$userId]);
        return $stmt->fetch();
    }

    /**
     * Find profile by ID
     */
    public static function findById($id)
    {
        $query = "SELECT * FROM player_profiles WHERE id = ? LIMIT 1";
        $stmt = Database::execute($query, [$id]);
        return $stmt->fetch();
    }

    /**
     * Update profile
     */
    public static function update($id, $data)
    {
        $allowed = [
            'full_name', 'date_of_birth', 'age', 'gender', 'mobile_number',
            'alternate_number', 'address', 'city', 'state', 'country',
            'postal_code', 'nationality', 'emergency_contact_name',
            'emergency_contact_number', 'emergency_contact_relationship',
            'primary_role', 'secondary_role', 'batting_style', 'bowling_arm',
            'bowling_type', 'batting_position', 'is_wicket_keeper',
            'captain_experience', 'vice_captain_experience', 'years_experience',
            'current_team', 'previous_teams', 'cricket_academy', 'coach_name',
            'highest_level_played', 'preferred_match_format', 'favorite_position',
            'jersey_number', 'height', 'weight', 'fitness_level', 'dominant_hand',
            'blood_group', 'strongest_skill', 'secondary_skill', 'weakness_area',
            'playing_style_description', 'favorite_cricketer', 'career_goal',
            'matches_played', 'innings', 'runs', 'highest_score', 'batting_average',
            'strike_rate', 'hundreds', 'fifties', 'fours', 'sixes', 'overs_bowled',
            'wickets', 'best_bowling_figures', 'bowling_average', 'economy_rate',
            'five_wicket_hauls', 'catches', 'run_outs', 'stumpings',
            'fitness_score', 'sprint_time', 'yoyo_test_score', 'injury_history',
            'current_injury_status', 'awards', 'tournament_wins', 'certificates',
            'special_achievements', 'profile_photo', 'id_proof', 'availability_status',
            'preferred_training_days', 'preferred_practice_time', 'about_me', 'notes'
        ];

        $updates = [];
        $params = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowed)) {
                $updates[] = "$key = ?";
                $params[] = $value;
            }
        }

        if (empty($updates)) {
            return false;
        }

        $updates[] = 'updated_at = NOW()';
        $params[] = $id;

        $query = "UPDATE player_profiles SET " . implode(', ', $updates) . " WHERE id = ?";

        try {
            Database::execute($query, $params);
            return true;
        } catch (\Exception $e) {
            Logger::error('Player profile update error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get profile completion percentage
     */
    public static function getCompletionPercentage($profileId)
    {
        $profile = self::findById($profileId);
        if (!$profile) {
            return 0;
        }

        $totalFields = 88; // Total questionnaire fields
        $filledFields = 0;

        foreach ($profile as $value) {
            if (!empty($value)) {
                $filledFields++;
            }
        }

        return round(($filledFields / $totalFields) * 100);
    }
}
