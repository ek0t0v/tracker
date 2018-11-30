<?php

namespace App\Tests\Helper;

use Codeception\Module;

/**
 * Class Unit.
 */
class Unit extends Module
{
    /**
     * @param string $id
     *
     * @return mixed
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function getSymfonyService(string $id)
    {
        return $this->getModule('Symfony')->grabService('test.service_container')->get($id);
    }
}
