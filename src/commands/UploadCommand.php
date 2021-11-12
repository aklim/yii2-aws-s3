<?php

namespace aklim\yii2\aws\s3\commands;

use aklim\yii2\aws\s3\base\commands\ExecutableCommand;
use aklim\yii2\aws\s3\base\commands\traits\Async;
use aklim\yii2\aws\s3\interfaces\commands\Asynchronous;
use aklim\yii2\aws\s3\interfaces\commands\HasAcl;
use aklim\yii2\aws\s3\interfaces\commands\HasBucket;
use Aws\ResultInterface;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Class UploadCommand.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
class UploadCommand extends ExecutableCommand implements HasBucket, HasAcl, Asynchronous
{
    use Async;

    /** @var string */
    protected string $bucket;

    /** @var string */
    protected string $acl;

    /** @var mixed */
    protected mixed $source;

    /** @var string */
    protected string $filename;

    /** @var array */
    protected array $options = [];

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
    public function getAcl(): string
    {
        return $this->acl;
    }

    /**
     * @param string $acl
     *
     * @return $this
     */
    public function withAcl(string $acl): ExecutableCommand
    {
        $this->acl = $acl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSource(): mixed
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     *
     * @return $this
     */
    public function withSource($source): ExecutableCommand
    {
        $this->source = $source;

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
    public function withFilename(string $filename): ExecutableCommand
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return int
     */
    public function getPartSize(): int
    {
        return $this->options['part_size'] ?? 0;
    }

    /**
     * @param int $partSize
     *
     * @return $this
     */
    public function withPartSize(int $partSize): ExecutableCommand
    {
        $this->options['part_size'] = $partSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getConcurrency(): int
    {
        return $this->options['concurrency'] ?? 0;
    }

    /**
     * @param int $concurrency
     *
     * @return $this
     */
    public function withConcurrency(int $concurrency): ExecutableCommand
    {
        $this->options['concurrency'] = $concurrency;

        return $this;
    }

    /**
     * @return int
     */
    public function getMupThreshold(): int
    {
        return $this->options['mup_threshold'] ?? 0;
    }

    /**
     * @param int $mupThreshold
     *
     * @return $this
     */
    public function withMupThreshold(int $mupThreshold): ExecutableCommand
    {
        $this->options['mup_threshold'] = $mupThreshold;

        return $this;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->getParam('ContentType', '');
    }

    /**
     * @param string $contentType
     *
     * @return $this
     */
    public function withContentType(string $contentType): ExecutableCommand
    {
        return $this->withParam('ContentType', $contentType);
    }

    /**
     * @return string
     */
    public function getContentDisposition(): string
    {
        return $this->getParam('ContentDisposition', '');
    }

    /**
     * @param string $contentDisposition
     *
     * @return $this
     */
    public function withContentDisposition(string $contentDisposition): ExecutableCommand
    {
        return $this->withParam('ContentDisposition', $contentDisposition);
    }

    /**
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getParam(string $name, mixed $default = null): mixed
    {
        return $this->options['params'][ $name ] ?? $default;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function withParam(string $name, mixed $value): ExecutableCommand
    {
        $this->options['params'][ $name ] = $value;

        return $this;
    }

    /**
     * @param callable $beforeUpload
     *
     * @return $this
     */
    public function beforeUpload(callable $beforeUpload): ExecutableCommand
    {
        $this->options['before_upload'] = $beforeUpload;

        return $this;
    }

    /**
     * @return array
     * @internal used by the handlers
     *
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
