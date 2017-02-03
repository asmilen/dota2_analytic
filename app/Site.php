<?php

namespace App;


class Site
{
    public static function moduleEnable($key_type, $key_content, $key_value)
    {
        $modules = Module::where('key_type', $key_type)
            ->where('key_content', $key_content)
            ->where('key_value', $key_value)
            ->get();

        return ($modules->count() > 0) ? $modules->first() : null;
    }

    /**
     * Using for testing.
     * @param null $uid
     */
    public static function hardLogin($uid = null)
    {
        session()->forget('frontend_login');
        if (!$uid) {
            $uid = random_int(1, 1000000);
        }

        $account = Account::firstOrCreate([
            'uid' => $uid
        ], [
            'username' => 'user_' . $uid,
            'email' => ''
        ]);

        session()->put('frontend_login', $account);

    }
}