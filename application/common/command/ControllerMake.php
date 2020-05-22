<?php
/**
 * Created by PhpStorm.
 * User: caihu
 * Date: 2018/10/31
 * Time: 8:56
 */

namespace app\common\command;

use think\console\command\Make;

class ControllerMake extends Make
{
    protected $type = "Controller";

    protected function configure()
    {
        parent::configure();
        $this->setName('make:control')
            ->setDescription('Create a new controller class');
    }

    protected function getStub()
    {
        return __DIR__ . '/stubs/controller.api.stub';
    }

    protected function getClassName($name)
    {
        return parent::getClassName($name);
    }

    protected function getNamespace($appNamespace, $module)
    {
        return parent::getNamespace($appNamespace, $module) . '\controller';
    }
}

