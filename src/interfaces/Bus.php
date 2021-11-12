<?php

namespace aklim\yii2\aws\s3\interfaces;

use aklim\yii2\aws\s3\interfaces\commands\Command;

/**
 * Interface Bus.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
interface Bus
{
    /**
     * @param Command $command
     *
     * @return mixed
     */
    public function execute(Command $command);
}
