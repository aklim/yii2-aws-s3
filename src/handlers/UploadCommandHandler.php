<?php

namespace aklim\yii2\aws\s3\handlers;

use aklim\yii2\aws\s3\base\handlers\Handler;
use aklim\yii2\aws\s3\commands\UploadCommand;
use Aws\ResultInterface;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7;
use Psr\Http\Message\StreamInterface;

/**
 * Class UploadCommandHandler.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
final class UploadCommandHandler extends Handler
{
    /**
     * @param UploadCommand $command
     *
     * @return ResultInterface|PromiseInterface
     */
    public function handle(UploadCommand $command): ResultInterface|PromiseInterface
    {
        $source = $this->sourceToStream($command->getSource());
        $options = array_filter($command->getOptions());

        $promise = $this->s3Client->uploadAsync(
            $command->getBucket(),
            $command->getFilename(),
            $source,
            $command->getAcl(),
            $options
        );

        return $command->isAsync() ? $promise : $promise->wait();
    }

    /**
     * Create a new stream based on the input type.
     *
     * @param resource|string|StreamInterface $source path to a local file, resource or stream
     *
     * @return StreamInterface
     */
    protected function sourceToStream(mixed $source): StreamInterface
    {
        if (is_string($source)) {
            $source = Psr7\try_fopen($source, 'r+');
        }

        return Psr7\stream_for($source);
    }
}
