<?php

namespace Common\Tests\Helper;

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
     * @param string $email
     * @param string $password
     *
     * @throws ModuleException
     *
     * @return string
     */
    public function getAccessToken(string $email, string $password): string
    {
        $rest = $this->getModule('REST');

        if (!$this->token) {
            $rest->haveHttpHeader('Content-Type', 'application/json');
            $rest->sendPOST('/token/create', [
                'email' => $email,
                'password' => $password,
            ]);

            $this->token = json_decode($rest->grabResponse(), true)['token'];
        }

        unset($rest->headers['Authorization']);

        return $this->token;
    }
}
