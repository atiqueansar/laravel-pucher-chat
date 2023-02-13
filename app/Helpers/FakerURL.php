<?php
/**
 * Created by PhpStorm.
 * User: Atiq Ansar
 * Date: 22/04/2021
 * Time: 12:33 AM
 */

namespace App\Helpers;

use Hashids\Hashids;

class FakerURL
{
    public static function id_e($id = 'id') {
        $hashId = new Hashids(md5(config('app.hash')));
        return $hashId->encode($id);
    }

    public static function id_d($value) {

        $hashId = new Hashids(md5(config('app.hash')));
        $decoded = $hashId->decode($value);
        if (is_array($decoded) && isset($decoded[0])) {
            return $decoded[0];
        }
        if (!$decoded) {
            // so 404 shows up in case of wrong id
            return -9999999999;
        }
        return $decoded;
    }

}
