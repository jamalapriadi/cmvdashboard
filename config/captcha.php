<?php
/*
 * Secret key and Site key get on https://www.google.com/recaptcha
 * */
return [
    'secret' => env('CAPTCHA_SECRET', '6Lev9lMUAAAAAE4pPmg_TzViFeNc8tuvr1RNV1-L'),
    'sitekey' => env('CAPTCHA_SITEKEY', '6Lev9lMUAAAAAOOXZcSXMelRObV_COWuO-73tJfm'),
    /**
     * @var string|null Default ``null``.
     * Custom with function name (example customRequestCaptcha) or class@method (example \App\CustomRequestCaptcha@custom).
     * Function must be return instance, read more in folder ``examples``
     */
    'request_method' => null,
];