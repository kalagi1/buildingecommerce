<?php

// app/Helpers/helpers.php

use Illuminate\Support\Facades\Crypt;
use App\Models\HousingComment;
use App\Models\ProjectComment;
use Illuminate\Support\Facades\Auth;


// app/Helpers/CommentHelper.php
if (!function_exists('canUserAddComment')) {
    function canUserAddComment($housingId)
    {
        $user = Auth::user();

        // Check if the user is logged in
        if ($user) {
            // Check if a comment already exists for this housing by the logged-in user
            $commentExists = HousingComment::where('user_id', $user->id)
                                           ->where('housing_id', $housingId)
                                           ->exists();
            
            return !$commentExists; // Return true if the user can add a comment (no existing comment found), false otherwise
        }

        return false; // Return false if user is not logged in
    }
}

if (!function_exists('canUserAddProjectComment')) {
    function canUserAddProjectComment($projecyId)
    {
        $user = Auth::user();

        // Check if the user is logged in
        if ($user) {
            // Check if a comment already exists for this housing by the logged-in user
            $commentExists = ProjectComment::where('user_id', $user->id)
                                           ->where('project_id', $projecyId)
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

        // Check if the user is logged in
        if ($user) {
            // Check if there exists a housing record with the given $housingId and user_id matching the logged-in user
            $exists = $user->housings()->where('id', $housingId)->exists();
            return !$exists; // Return true if the user can add to cart (housing not found), false otherwise
        }

        return true; // Return false if user is not logged in
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

if (!function_exists('checkIfUserCanAddToProject')) {
    function checkIfUserCanAddToProject($projectId)
    {
        $user = auth()->user();

        if ($user) {

            $exists = $user->Projects()->where('id', $projectId)->exists();
            return !$exists;
        }

        return true;
    }
}

if (!function_exists('checkIfUserCanAddToProjectHousings')) {
    function checkIfUserCanAddToProjectHousings($projectId, $keyIndex)
    {
        $user = auth()->user();

        if ($user) {
            $exists = $user->projects()
                ->where('id', $projectId)
                ->whereHas('housings', function ($query) use ($keyIndex) {
                    $query->where('room_order', $keyIndex);
                })
                ->exists();
            return !$exists;
        }

        return true;
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
