<?php

namespace aklim\yii2\aws\s3\commands;

use aklim\yii2\aws\s3\base\commands\ExecutableCommand;
use aklim\yii2\aws\s3\base\commands\traits\Async;
use aklim\yii2\aws\s3\base\commands\traits\Options;
use aklim\yii2\aws\s3\interfaces\commands\Asynchronous;
use aklim\yii2\aws\s3\interfaces\commands\HasAcl;
use aklim\yii2\aws\s3\interfaces\commands\HasBucket;
use aklim\yii2\aws\s3\interfaces\commands\PlainCommand;
use Aws\ResultInterface;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Class PutCommand.
 *
 * @method ResultInterface|PromiseInterface execute()
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
class PutCommand extends ExecutableCommand implements PlainCommand, HasBucket, HasAcl, Asynchronous
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
    public function withFilename(string $filename): ExecutableCommand
    {
        $this->args['Key'] = $filename;

        return $this;
    }

    /**
     * @return string
     */
    public function getAcl(): string
    {
        return $this->args['ACL'] ?? '';
    }

    /**
     * @param string $acl
     *
     * @return $this
     */
    public function withAcl(string $acl): ExecutableCommand
    {
        $this->args['ACL'] = $acl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody(): mixed
    {
        return $this->args['Body'] ?? null;
    }

    /**
     * @param mixed $body
     *
     * @return $this
     */
    public function withBody(mixed $body): ExecutableCommand
    {
        $this->args['Body'] = $body;

        return $this;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->args['Metadata'] ?? [];
    }

    /**
     * @param array $metadata
     *
     * @return $this
     */
    public function withMetadata(array $metadata): ExecutableCommand
    {
        $this->args['Metadata'] = $metadata;

        return $this;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->args['ContentType'] ?? '';
    }

    /**
     * @param string $contentType
     *
     * @return $this
     */
    public function withContentType(string $contentType): ExecutableCommand
    {
        $this->args['ContentType'] = $contentType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiration(): mixed
    {
        return $this->args['Expires'] ?? null;
    }

    /**
     * @param mixed $expires
     *
     * @return $this
     */
    public function withExpiration(mixed $expires): ExecutableCommand
    {
        $this->args['Expires'] = $expires;

        return $this;
    }

    /**
     * @return string
     * @internal used by the handlers
     *
     */
    public function getName(): string
    {
        return 'PutObject';
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
