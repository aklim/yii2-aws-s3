<?php

namespace aklim\yii2\aws\s3\interfaces;

use aklim\yii2\aws\s3\interfaces\commands\Command;

/**
 * Interface CommandBuilder.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
interface CommandBuilder
{
    /**
     * @param string $commandClass
     *
     * @return Command
     */
    public function build(string $commandClass): Command;
}
