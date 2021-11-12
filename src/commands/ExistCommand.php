<?php

namespace aklim\yii2\aws\s3\commands;

use aklim\yii2\aws\s3\base\commands\ExecutableCommand;
use aklim\yii2\aws\s3\base\commands\traits\Options;
use aklim\yii2\aws\s3\interfaces\commands\HasBucket;

/**
 * Class ExistCommand.
 *
 * @method bool execute()
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
class ExistCommand extends ExecutableCommand implements HasBucket
{
    use Options;

    /** @var string */
    protected string $bucket;

    /** @var string */
    protected string $filename;

    /**
     * @return string
     */
    public function getBucket(): string
    {
        return $this->bucket;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function inBucket(string $name): ExecutableCommand
    {
        $this->bucket = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     *
     * @return $this
     */
    public function byFilename(string $filename): ExecutableCommand
    {
        $this->filename = $filename;

        return $this;
    }
}
