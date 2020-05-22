<?php
/**
 * Created by PhpStorm.
 * User: caihu
 * Date: 2018/10/31
 * Time: 8:56
 */

namespace app\common\command;

use think\console\command\Make;

class ActionMake extends Make
{
    protected $type = "Action";

    protected function configure()
    {
        parent::configure();
        $this->setName('make:action')
            ->setDescription('Create a new action class');
    }

    protected function getStub()
    {
        return __DIR__ . '/stubs/action.stub';
    }

    protected function getClassName($name)
    {
        return parent::getClassName($name) . 'Action';
    }

    protected function getNamespace($appNamespace, $module)
    {
        return parent::getNamespace($appNamespace, $module) . '\action';
    }
}

