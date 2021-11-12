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
 * Class ListCommand.
 *
 * @method ResultInterface|PromiseInterface execute()
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
class ListCommand extends ExecutableCommand implements PlainCommand, HasBucket, Asynchronous
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
    public function getPrefix(): string
    {
        return $this->args['Prefix'] ?? '';
    }

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function byPrefix(string $prefix): ExecutableCommand
    {
        $this->args['Prefix'] = $prefix;

        return $this;
    }

    /**
     * @return string
     * @internal used by the handlers
     *
     */
    public function getName(): string
    {
        return 'ListObjects';
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
