<?php
/**
 * Created by PhpStorm.
 * User: caihu
 * Date: 2018/10/31
 * Time: 8:56
 */

namespace app\common\command;

use think\console\command\Make;

class SubActionMake extends Make
{
    protected $type = "SubAction";

    protected function configure()
    {
        parent::configure();
        $this->setName('make:subaction')
            ->setDescription('Create a new sub action class');
    }

    protected function getStub()
    {
        return __DIR__ . '/stubs/sub_action.stub';
    }

    protected function getClassName($name)
    {
        return parent::getClassName($name) . 'SubAction';
    }

    protected function getNamespace($appNamespace, $module)
    {
        return parent::getNamespace($appNamespace, $module) . '\sub_action';
    }
}

