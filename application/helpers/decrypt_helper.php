<?php

if (!function_exists('encrypt_data')) {
    function encrypt_data($data, $key)
    {
        // Generate a random salt and initialization vector
        $salt = openssl_random_pseudo_bytes(16);
        $iv = openssl_random_pseudo_bytes(16);

        // Derive an encryption key from the password using PBKDF2
        $key = openssl_pbkdf2($key, $salt, 32, 1000, 'sha1');

        // Encrypt the data using AES-256-CBC
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

        // Combine the salt, initialization vector, and encrypted data into a single string
        $encryptedData = bin2hex($salt) . bin2hex($iv) . bin2hex($encrypted);

        return $encryptedData;
    }
}

if (!function_exists('decrypt_data')) {
    function decryptData($encryptedData, $key)
    {
        // Ambil salt, vektor inisialisasi, dan data terenkripsi dari string terenkripsi
        $saltHex = substr($encryptedData, 0, 32);
        $ivHex = substr($encryptedData, 32, 32);
        $encryptedHex = substr($encryptedData, 64);
        $salt = hex2bin($saltHex);
        $iv = hex2bin($ivHex);
        $encrypted = hex2bin($encryptedHex);

        // Bangkitkan kunci enkripsi dari kunci acak dengan PBKDF2
        $derivedKey = openssl_pbkdf2($key, $salt, 32, 1000, "sha1");

        // Dekripsi data dengan kunci acak dan vektor inisialisasi acak
        $decrypted = openssl_decrypt($encrypted, "AES-256-CBC", $derivedKey, OPENSSL_RAW_DATA, $iv);
        return $decrypted;
    }
}
