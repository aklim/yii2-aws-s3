<?php

namespace aklim\yii2\aws\s3\interfaces;

use aklim\yii2\aws\s3\interfaces\commands\Command;

/**
 * Interface Service.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
interface Service
{
    /**
     * @param Command $command
     *
     * @return mixed
     */
    public function execute(Command $command): mixed;

    /**
     * @param string $commandClass
     *
     * @return Command
     */
    public function create(string $commandClass): Command;
}
