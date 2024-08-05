<?php

// app/Helpers/CommentHelper.php

use Illuminate\Support\Facades\Crypt;
use App\Models\HousingComment;
use App\Models\ProjectComment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (!function_exists('canUserAddComment')) {
    function canUserAddComment($housingId)
    {
        $user = Auth::user();

        if ($user) {
            // Determine the user ID to use (parent ID if available)
            $userId = $user->parent_id ?: $user->id;

            // Check if a comment already exists for this housing by the user or their parent
            $commentExists = HousingComment::where('user_id', $userId)
                ->where('housing_id', $housingId)
                ->exists();

            return !$commentExists; // Return true if the user can add a comment (no existing comment found), false otherwise
        }

        return false; // Return false if user is not logged in
    }
}

if (!function_exists('canUserAddProjectComment')) {
    function canUserAddProjectComment($projectId)
    {
        $user = Auth::user();

        if ($user) {
            // Determine the user ID to use (parent ID if available)
            $userId = $user->parent_id ?: $user->id;

            // Check if a comment already exists for this project by the user or their parent
            $commentExists = ProjectComment::where('user_id', $userId)
                ->where('project_id', $projectId)
                ->exists();

            return !$commentExists; // Return true if the user can add a comment (no existing comment found), false otherwise
        }

        return false; // Return false if user is not logged in
    }
}

if (!function_exists('checkIfUserCanAddToCart')) {
    function checkIfUserCanAddToCart($housingId)
    {
        $user = auth()->user();

        if ($user) {
            // Determine the user ID to use (parent ID if available)
            if ($user->parent_id) {
                // Get the parent user
                $parentUser = \App\Models\User::find($user->parent_id);

                if ($parentUser) {
                    // Check if the housing exists for the parent user
                    $exists = $parentUser->housings()->where('id', $housingId)->exists();
                } else {
                    // If the parent user is not found, fallback to current user
                    $exists = $user->housings()->where('id', $housingId)->exists();
                }
            } else {
                // No parent ID, use the current user
                $exists = $user->housings()->where('id', $housingId)->exists();
            }

            // Return true if the housing does not exist (i.e., the user can add it)
            return !$exists;
        }

        return true; // Return true if the user is not logged in
    }
}


if (!function_exists('checkIfUserCanAddToProject')) {
    function checkIfUserCanAddToProject($projectId)
    {
        $user = auth()->user();

        if ($user) {
            // Determine the user ID to use (parent ID if available)
            if ($user->parent_id) {
                // Get the parent user
                $parentUser = \App\Models\User::find($user->parent_id);

                if ($parentUser) {
                    // Check if the project exists for the parent user
                    $exists = $parentUser->projects()
                        ->where('id', $projectId)
                        ->exists();
                } else {
                    // If the parent user is not found, fallback to current user
                    $exists = $user->projects()
                        ->where('id', $projectId)
                        ->exists();
                }
            } else {
                // No parent ID, use the current user
                $exists = $user->projects()
                    ->where('id', $projectId)
                    ->exists();
            }

            // Return true if the project does not exist (i.e., the user can add it)
            return !$exists;
        }

        return true; // Return true if the user is not logged in
    }
}

if (!function_exists('checkIfUserCanAddToProjectHousings')) {
    function checkIfUserCanAddToProjectHousings($projectId, $keyIndex)
    {
        $user = auth()->user();

        if ($user) {
            // Determine the user ID to use (parent ID if available)
            $userId = $user->parent_id ?: $user->id;
            $user = User::where("id", $userId)->first();

            $exists = $user->projects()
                ->where('id', $projectId)
                ->whereHas('housings', function ($query) use ($keyIndex) {
                    $query->where('room_order', $keyIndex);
                })
                ->exists();

            if (!$exists && $user->type == 1 || !$exists && ($user->type == 2 && $user->corporate_type == 'Emlak Ofisi')) {
                return true; // User or parent is not associated with the project
            }

         
        }

        return false; // Return false if user is not logged in or does not meet type criteria
    }
}


if (!function_exists('getInitials')) {
    function getInitials($name)
    {
        $words = explode(" ", $name);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper($word[0]);
        }

        return $initials;
    }
}

function hash_id($id)
{
    return Crypt::encryptString($id);
}

function decode_id($hashedId)
{
    return Crypt::decryptString($hashedId);
}
