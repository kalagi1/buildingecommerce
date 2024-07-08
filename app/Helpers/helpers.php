<?php

// app/Helpers/helpers.php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

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
    // Encrypt the ID (you can skip this step if not encrypting)
    $encrypted = encrypt($id); // Replace with your encryption method if needed

    // Hash the encrypted value with SHA-256
    $hashed = hash('sha256', $encrypted);

    // Encode to base64
    $base64Encoded = base64_encode($hashed);

    // Truncate the encoded string to 15-30 characters
    $length = rand(15, 30);
    $truncated = Str::limit($base64Encoded, $length, '');

    return $truncated;
}

function decode_id($hashedId)
{
    try {
        // Decode the base64-encoded string
        $base64Decoded = base64_decode($hashedId);

        // Hash the decoded value with SHA-256
        $hashed = hash('sha256', $base64Decoded);

        // Decrypt the hashed value (replace with your decryption method if needed)
        $decrypted = decrypt($hashed); // Replace with your decryption method

        return $decrypted;
    } catch (\Exception $e) {
        abort(404);
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
                ->whereHas('housings', function ($query) use ($keyIndex) {
                    $query->where('room_order', $keyIndex);
                })
                ->exists();
            return !$exists;
        }

        return true;
    }
}
