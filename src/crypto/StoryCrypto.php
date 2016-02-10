<?php

namespace Snapchat\Crypto;

class StoryCrypto {

    /**
     * Decrypts blob data for stories.
     *
     * @param $data object The data to decrypt.
     * @param $key string The base64-encoded Key.
     * @param $iv string The base64-encoded IV.
     * @return object The decrypted data.
     */
    public static function decryptStory($data, $key, $iv){

        $iv = base64_decode($iv);
        $key = base64_decode($key);

        $data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $iv);
        $padding = ord($data[strlen($data) - 1]);

        return substr($data, 0, -$padding);

    }

}