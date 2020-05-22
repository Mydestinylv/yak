<?php
/**
 * Created by PhpStorm.
 * User: caihu
 * Date: 2018/10/31
 * Time: 8:56
 */

namespace app\common\command;

use think\console\command\Make;

class ValidateMake extends Make
{
    protected $type = "Verify";

    protected function configure()
    {
        parent::configure();
        $this->setName('make:verify')
            ->setDescription('Create a new verify class');
    }

    protected function getStub()
    {
        return __DIR__ . '/stubs/validate.stub';
    }

    protected function getClassName($name)
    {
        return parent::getClassName($name);
    }

    protected function getNamespace($appNamespace, $module)
    {
        return parent::getNamespace($appNamespace, $module) . '\validate';
    }
}

