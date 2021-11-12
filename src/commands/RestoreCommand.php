<?php

namespace aklim\yii2\aws\s3\commands;

use aklim\yii2\aws\s3\base\commands\ExecutableCommand;
use aklim\yii2\aws\s3\base\commands\traits\Async;
use aklim\yii2\aws\s3\interfaces\commands\Asynchronous;
use aklim\yii2\aws\s3\interfaces\commands\HasBucket;
use aklim\yii2\aws\s3\interfaces\commands\PlainCommand;
use Aws\ResultInterface;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Class RestoreCommand.
 *
 * @method ResultInterface|PromiseInterface execute()
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
class RestoreCommand extends ExecutableCommand implements PlainCommand, HasBucket, Asynchronous
{
    use Async;

    /** @var array */
    protected array $args = [];

    /**
     * @return string
     */
    public function getBucket(): string
    {
        return $this->args['Bucket'] ?? '';
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function inBucket(string $name):  ExecutableCommand
    {
        $this->args['Bucket'] = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->args['Key'] ?? '';
    }

    /**
     * @param string $filename
     *
     * @return $this
     */
    public function byFilename(string $filename):  ExecutableCommand
    {
        $this->args['Key'] = $filename;

        return $this;
    }

    /**
     * @return int lifetime of the active copy in days
     */
    public function getLifetime(): int
    {
        return $this->args['Days'] ?? 0;
    }

    /**
     * @param int $days lifetime of the active copy in days
     *
     * @return $this
     */
    public function withLifetime(int $days):  ExecutableCommand
    {
        $this->args['Days'] = $days;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersionId(): string
    {
        return $this->args['VersionId'] ?? '';
    }

    /**
     * @param string $versionId
     *
     * @return $this
     */
    public function withVersionId(string $versionId):  ExecutableCommand
    {
        $this->args['VersionId'] = $versionId;

        return $this;
    }

    /**
     * @return string
     * @internal used by the handlers
     *
     */
    public function getName(): string
    {
        return 'RestoreObject';
    }

    /**
     * @return array
     * @internal used by the handlers
     *
     */
    public function toArgs(): array
    {
        return $this->args;
    }
}
