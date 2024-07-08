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
    // ID'yi şifreleyin
    $encrypted = Crypt::encryptString($id);

    // Şifrelenmiş veriyi base64_encode ile kodlayın
    $base64Encoded = base64_encode($encrypted);

    // Kodlanmış veriyi 15-30 karakter arasında sınırlandırın
    $length = rand(15, 30);
    $truncated = Str::limit($base64Encoded, $length, '');

    return $truncated;
}

function decode_id($hashedId)
{
    try {
        // Kesilen veriyi base64_decode ile çözün
        $base64Decoded = base64_decode($hashedId);

        // Şifrelenmiş veriyi çözün
        $decrypted = Crypt::decryptString($base64Decoded);

        return $decrypted;
    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
        abort(404);
    } catch (\Exception $e) {
        // Eğer base64_decode sırasında bir hata oluşursa 404'e yönlendir
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
