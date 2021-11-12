<?php

namespace aklim\yii2\aws\s3\handlers;

use aklim\yii2\aws\s3\base\handlers\Handler;
use aklim\yii2\aws\s3\commands\GetUrlCommand;

/**
 * Class GetUrlCommandHandler.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
final class GetUrlCommandHandler extends Handler
{
    /**
     * @param GetUrlCommand $command
     *
     * @return string
     */
    public function handle(GetUrlCommand $command): string
    {
        return $this->s3Client->getObjectUrl($command->getBucket(), $command->getFilename());
    }
}
