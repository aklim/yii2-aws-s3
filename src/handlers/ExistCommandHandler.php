<?php

namespace aklim\yii2\aws\s3\handlers;

use aklim\yii2\aws\s3\base\handlers\Handler;
use aklim\yii2\aws\s3\commands\ExistCommand;

/**
 * Class ExistCommandHandler.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
final class ExistCommandHandler extends Handler
{
    /**
     * @param ExistCommand $command
     *
     * @return bool
     */
    public function handle(ExistCommand $command): bool
    {
        return $this->s3Client->doesObjectExist(
            $command->getBucket(),
            $command->getFilename(),
            $command->getOptions()
        );
    }
}
