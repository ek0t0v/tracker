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
    private $token;

    /**
     * @return string
     *
     * @throws ModuleException
     */
    public function getAccessToken()
    {
        $rest = $this->getModule('REST');

        if (!$this->token) {
            $rest->haveHttpHeader('Content-Type', 'application/json');
            $rest->sendPOST('/token/create', [
                'email' => 'user@mail.ru',
                'password' => 'passw0rd',
            ]);

            $this->token = json_decode($rest->grabResponse(), true)['token'];
        }

        unset($rest->headers['Authorization']);

        return $this->token;
    }
}
