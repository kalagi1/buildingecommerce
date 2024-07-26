<?php

// app/Helpers/helpers.php

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
                           ->whereHas('housings', function($query) use ($keyIndex) {
                               $query->where('room_order', $keyIndex);
                           })
                           ->exists();
            return !$exists;
        }

        return true;
    }
}