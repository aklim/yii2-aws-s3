<?php

namespace aklim\yii2\aws\s3\handlers;

use aklim\yii2\aws\s3\base\handlers\Handler;
use aklim\yii2\aws\s3\commands\GetPresignedUrlCommand;

/**
 * Class GetPresignedUrlCommandHandler.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
final class GetPresignedUrlCommandHandler extends Handler
{
    /**
     * @param GetPresignedUrlCommand $command
     *
     * @return string
     */
    public function handle(GetPresignedUrlCommand $command): string
    {
        $awsCommand = $this->s3Client->getCommand('GetObject', $command->getArgs());
        $request = $this->s3Client->createPresignedRequest($awsCommand, $command->getExpiration());

        return (string)$request->getUri();
    }
}
