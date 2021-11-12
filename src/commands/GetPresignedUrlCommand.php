<?php

namespace aklim\yii2\aws\s3\commands;

use aklim\yii2\aws\s3\base\commands\ExecutableCommand;
use aklim\yii2\aws\s3\interfaces\commands\HasBucket;
use aklim\yii2\aws\s3\interfaces\commands\HasExpiration;
use DateTime;

/**
 * Class GetPresignedUrlCommand.
 *
 * @method string execute()
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
class GetPresignedUrlCommand extends ExecutableCommand implements HasBucket, HasExpiration
{
    /** @var array */
    protected array $args = [];

    /** @var mixed */
    protected mixed $expiration;

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
    public function inBucket(string $name): ExecutableCommand
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
    public function byFilename(string $filename): ExecutableCommand
    {
        $this->args['Key'] = $filename;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiration(): mixed
    {
        return $this->expiration;
    }

    /**
     * @param int|string|DateTime $expiration
     *
     * @return $this
     */
    public function withExpiration(int|string|DateTime $expiration): ExecutableCommand
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * @return array
     * @internal used by the handlers
     *
     */
    public function getArgs(): array
    {
        return $this->args;
    }
}
