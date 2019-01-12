<?php

namespace Common\Tests\Helper;

use Codeception\Module;

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
        return $this->getModule('Symfony')->grabService('test.service_container')->get($id);
    }
}
