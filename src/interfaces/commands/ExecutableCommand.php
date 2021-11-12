<?php

namespace aklim\yii2\aws\s3\interfaces\commands;

/**
 * Interface ExecutableCommand.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
interface ExecutableCommand extends Command
{
    /**
     * @return mixed
     */
    public function execute(): mixed;
}
