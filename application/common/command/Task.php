<?php
/**
 * Created by PhpStorm.
 * User: caihu
 * Date: 2018/10/31
 * Time: 8:56
 */

namespace app\common\command;

use think\console\command\Make;

class Task extends Make
{
    protected $type = "Task";

    protected function configure()
    {
        parent::configure();
        $this->setName('make:task')
            ->setDescription('Create a new task class');
    }

    protected function getStub()
    {
        return __DIR__ . '/stubs/task.stub';
    }

    protected function getClassName($name)
    {
        return parent::getClassName($name) . 'Task';
    }

    protected function getNamespace($appNamespace, $module)
    {
        return parent::getNamespace($appNamespace, $module) . '\task';
    }
}

