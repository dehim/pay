<?php

namespace Dehim\Pay\Service;

use Psr\Container\ContainerInterface;
use yii\di\Container as YiiContainer;
use Dehim\Pay\Exception\ContainerNotFoundException;


class Yii2ContainerAdapter implements ContainerInterface
{
    protected $yiiContainer;

    public function __construct(YiiContainer $yiiContainer)
    {
        $this->yiiContainer = $yiiContainer;
    }

    public function get($id)
    {
        if (!$this->yiiContainer->has($id)) {
            throw new ContainerNotFoundException($id);
        }

        return $this->yiiContainer->get($id);

        // if ($this->yiiContainer->has($id)) {

        //     return $this->yiiContainer->get($id);
        // }
    }

    // Psr\Container\ContainerInterface 没有定义 set 方法
    public function set($id, $value): void
    {
        $this->yiiContainer->set($id, $value);
    }

    public function has(string $id): bool
    {
        return $this->yiiContainer->has($id);
    }
}
