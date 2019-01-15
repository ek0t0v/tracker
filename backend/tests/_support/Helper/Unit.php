<?php

namespace Tests\Helper;

use Codeception\Module;
use Codeception\Module\Symfony;

/**
 * Class Unit.
 */
class Unit extends Module
{
    /**
     * @param string $id
     *
     * @throws \Codeception\Exception\ModuleException
     *
     * @return mixed
     */
    public function getSymfonyService(string $id)
    {
        /**
         * @var Symfony $symfony
         */
        $symfony = $this->getModule('Symfony');

        return $symfony->grabService('test.service_container')->get($id);
    }
}
