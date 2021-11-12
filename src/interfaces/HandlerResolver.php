<?php

namespace aklim\yii2\aws\s3\interfaces;

use aklim\yii2\aws\s3\interfaces\commands\Command;
use aklim\yii2\aws\s3\interfaces\handlers\Handler;

/**
 * Interface HandlerResolver.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
interface HandlerResolver
{
    /**
     * @param Command $command
     *
     * @return Handler
     */
    public function resolve(Command $command): Handler;

    /**
     * @param string $commandClass
     * @param mixed  $handler
     */
    public function bindHandler(string $commandClass, mixed $handler): void;
}
