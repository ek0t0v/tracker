<?php

namespace App\Tests\Helper;

use Codeception\Exception\ModuleException;
use Codeception\Module;

/**
 * Class Api.
 */
class Api extends Module
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @param array $settings
     *
     * @throws ModuleException
     */
    public function _beforeSuite($settings = [])
    {
        $I = $this->getModule('REST');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/token/create', [
            'email' => 'user@mail.ru',
            'password' => 'passw0rd',
        ]);

        $this->accessToken = json_decode($I->grabResponse(), true)['token'];
    }

    /**
     * @return string
     *
     * @throws ModuleException
     */
    public function getAccessToken()
    {
        unset($this->getModule('REST')->headers['Authorization']);

        return $this->accessToken;
    }
}
