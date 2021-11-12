<?php

namespace aklim\yii2\aws\s3;

use aklim\yii2\aws\s3\interfaces;
use aklim\yii2\aws\s3\interfaces\commands\Command;

/**
 * Class Bus.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
class Bus implements interfaces\Bus
{
    /** @var interfaces\HandlerResolver */
    protected interfaces\HandlerResolver $resolver;

    /**
     * Bus constructor.
     *
     * @param \aklim\yii2\aws\s3\interfaces\HandlerResolver $inflector
     */
    public function __construct(interfaces\HandlerResolver $inflector)
    {
        $this->resolver = $inflector;
    }

    /**
     * @param Command $command
     *
     * @return mixed
     */
    public function execute(Command $command)
    {
        $handler = $this->resolver->resolve($command);

        return call_user_func([$handler, 'handle'], $command);
    }
}
