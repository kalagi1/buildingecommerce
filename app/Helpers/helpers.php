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
    $key = env('APP_KEY'); // Laravel'in APP_KEY değeri
    $cipher = 'aes-256-cbc';
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($id, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
    $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
    // Base62 Encode
    return Str::limit(base62_encode($ciphertext), 20, '');
}
function base62_encode($data) {
    $outstring = '';
    $base = 62;
    $index = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input = unpack('C*', $data);
    $input = array_values($input);
    while ($count = count($input)) {
        $div = 0;
        $newlen = 0;
        for ($i = 0; $i != $count; ++$i) {
            $div = $div * 256 + $input[$i];
            if ($div >= $base) {
                $input[$newlen++] = (int)($div / $base);
                $div = $div % $base;
            } else if ($newlen > 0) {
                $input[$newlen++] = 0;
            }
        }
        $count = $newlen;
        $outstring = $index[$div] . $outstring;
    }
    return $outstring;
}
function base62_decode($data) {
    $outstring = 0;
    $base = 62;
    $index = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input = str_split($data);
    foreach ($input as $char) {
        $outstring = $outstring * $base + strpos($index, $char);
    }
    return pack('H*', base_convert($outstring, 10, 16));
}
function decode_id($encryptedId)
{
    $key = env('APP_KEY');
    $cipher = 'aes-256-cbc';

    // Decode the encrypted ID
    $decoded = base64_decode(base62_decode($encryptedId));

    // Extract IV and HMAC from the decoded string
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = substr($decoded, 0, $ivlen);
    $hmac = substr($decoded, $ivlen, 32);
    $ciphertext_raw = substr($decoded, $ivlen + 32);

    // Verify the HMAC to ensure integrity
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
    if (!hash_equals($hmac, $calcmac)) {
        return null; // HMAC validation failed
    }

    // Decrypt the ciphertext
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    if ($original_plaintext === false) {
        return null; // Decryption failed
    }

    return $original_plaintext;
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