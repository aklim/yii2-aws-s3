<?php

namespace aklim\yii2\aws\s3\handlers;

use aklim\yii2\aws\s3\base\handlers\Handler;
use aklim\yii2\aws\s3\interfaces\commands\Asynchronous;
use aklim\yii2\aws\s3\interfaces\commands\PlainCommand;
use Aws\CommandInterface as AwsCommand;
use Aws\ResultInterface;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Class PlainCommandHandler.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
final class PlainCommandHandler extends Handler
{
    /**
     * @param PlainCommand $command
     *
     * @return ResultInterface|PromiseInterface
     */
    public function handle(PlainCommand $command): ResultInterface|PromiseInterface
    {
        $awsCommand = $this->transformToAwsCommand($command);

        /** @var PromiseInterface $promise */
        $promise = $this->s3Client->executeAsync($awsCommand);

        return $this->commandIsAsync($command) ? $promise : $promise->wait();
    }

    /**
     * @param PlainCommand $command
     *
     * @return bool
     */
    protected function commandIsAsync(PlainCommand $command): bool
    {
        return $command instanceof Asynchronous && $command->isAsync();
    }

    /**
     * @param PlainCommand $command
     *
     * @return AwsCommand
     */
    protected function transformToAwsCommand(PlainCommand $command): AwsCommand
    {
        $args = array_filter($command->toArgs());

        return $this->s3Client->getCommand($command->getName(), $args);
    }
}
