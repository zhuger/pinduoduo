<?php
/**
 * Created for pinduoduo.
 * User: 丁海军
 * Date: 2018/10/13
 * Time: 15:05.
 */

namespace ZhuGer\PinDuoDuo;

use Hanson\Foundation\Foundation;
use ZhuGer\PinDuoDuo\Oauth\Oauth;
use ZhuGer\PinDuoDuo\Oauth\PreAuth;

/**
 * Class PinDuoDuo.
 *
 * @property Api         $api
 * @property Api         $auth_api
 * @property AccessToken $access_token
 * @property PreAuth     $pre_auth
 * @property Oauth       $oauth
 */
class PinDuoDuo extends Foundation
{
    protected $providers = [
        ServiceProvider::class,
        \ZhuGer\PinDuoDuo\Oauth\ServiceProvider::class,
    ];
}
