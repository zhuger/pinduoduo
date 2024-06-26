<?php
/**
 * Created for pinduoduo
 * User: 丁海军
 * Date: 2018/6/30
 * Time: 下午1:40.
 */

namespace ZhuGer\PinDuoDuo;

use Hanson\Foundation\AbstractAccessToken;
use Hanson\Foundation\Foundation;

class AccessToken extends AbstractAccessToken
{
    const TOKEN_API = 'https://open-api.pinduoduo.com/oauth/token';
    protected $code;

    /**
     * key of token in json.
     *
     * @var string
     */
    protected $tokenJsonKey = 'access_token';

    /**
     * key of expires in json.
     *
     * @var string
     */
    protected $expiresJsonKey = 'expires_in';

    /**
     * @param string     $clientId
     * @param string     $secret
     * @param Foundation $app
     */
    public function __construct(string $clientId, string $secret, Foundation $app)
    {
        parent::__construct($app);
        $this->appId = $clientId;
        $this->secret = $secret;
    }

    /**
     * Get token from remote server.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function getTokenFromServer()
    {
        if (!empty($_GET['code'])) {
            $this->setCode(trim($_GET['code']));
        }
        if (empty($this->code)) {
            throw new \Exception('code不能为空');
        }
        $response = $this->getHttp()->json(static::TOKEN_API, [
            'client_id'     => $this->appId,
            'client_secret' => $this->secret,
            'grant_type'    => 'authorization_code',
            'code'          => $this->code,
        ]);

        return json_decode(strval($response->getBody()), true);
    }

    /**
     * @param bool $forceRefresh
     *
     * @return string
     */
    public function getToken($forceRefresh = false): string
    {
        return $this->token ?: parent::getToken($forceRefresh);
    }

    /**
     * Throw exception if token is invalid.
     *
     * @param $result
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function checkTokenResponse($result)
    {
        if (isset($result['error_response'])) {
            throw new \Exception($result['error_response']['error_msg'], $result['error_response']['code']);
        }

        return true;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @param mixed $code
     *
     * @return AccessToken
     */
    public function setCode($code): AccessToken
    {
        $this->code = $code;

        return $this;
    }
}
