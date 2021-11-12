<?php

namespace aklim\yii2\aws\s3\commands;

use aklim\yii2\aws\s3\base\commands\ExecutableCommand;
use aklim\yii2\aws\s3\base\commands\traits\Async;
use aklim\yii2\aws\s3\base\commands\traits\Options;
use aklim\yii2\aws\s3\interfaces\commands\Asynchronous;
use aklim\yii2\aws\s3\interfaces\commands\HasBucket;
use aklim\yii2\aws\s3\interfaces\commands\PlainCommand;
use Aws\ResultInterface;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Class GetCommand.
 *
 * @method ResultInterface|PromiseInterface execute()
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
class GetCommand extends ExecutableCommand implements PlainCommand, HasBucket, Asynchronous
{
    use Async;
    use Options;

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
     * @param string $value
     *
     * @return $this
     */
    public function saveAs(string $value): ExecutableCommand
    {
        $this->args['SaveAs'] = $value;

        return $this;
    }

    /**
     * @param string $ifMatch
     *
     * @return $this
     */
    public function ifMatch(string $ifMatch): ExecutableCommand
    {
        $this->args['IfMatch'] = $ifMatch;

        return $this;
    }

    /**
     * @return string
     * @internal used by the handlers
     *
     */
    public function getName(): string
    {
        return 'GetObject';
    }

    /**
     * @return array
     * @internal used by the handlers
     *
     */
    public function toArgs(): array
    {
        return array_replace($this->options, $this->args);
    }
}
