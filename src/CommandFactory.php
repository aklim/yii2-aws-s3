<?php

namespace aklim\yii2\aws\s3;

use aklim\yii2\aws\s3\commands\DeleteCommand;
use aklim\yii2\aws\s3\commands\ExistCommand;
use aklim\yii2\aws\s3\commands\GetCommand;
use aklim\yii2\aws\s3\commands\GetPresignedUrlCommand;
use aklim\yii2\aws\s3\commands\GetUrlCommand;
use aklim\yii2\aws\s3\commands\ListCommand;
use aklim\yii2\aws\s3\commands\PutCommand;
use aklim\yii2\aws\s3\commands\RestoreCommand;
use aklim\yii2\aws\s3\commands\UploadCommand;
use aklim\yii2\aws\s3\interfaces;

/**
 * Class CommandFactory.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
class CommandFactory
{
    /** @var \aklim\yii2\aws\s3\interfaces\CommandBuilder */
    protected \aklim\yii2\aws\s3\interfaces\CommandBuilder $builder;

    /**
     * CommandFactory constructor.
     *
     * @param \aklim\yii2\aws\s3\interfaces\CommandBuilder $builder
     */
    public function __construct(interfaces\CommandBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param string $filename
     *
     * @return GetCommand
     */
    public function get(string $filename): GetCommand
    {
        /** @var GetCommand $command */
        $command = $this->builder->build(GetCommand::class);
        $command->byFilename($filename);

        return $command;
    }

    /**
     * @param string $filename
     * @param mixed  $body
     *
     * @return PutCommand
     */
    public function put(string $filename, mixed $body): PutCommand
    {
        /** @var PutCommand $command */
        $command = $this->builder->build(PutCommand::class);
        $command->withFilename($filename)->withBody($body);

        return $command;
    }

    /**
     * @param string $filename
     *
     * @return DeleteCommand
     */
    public function delete(string $filename): DeleteCommand
    {
        /** @var DeleteCommand $command */
        $command = $this->builder->build(DeleteCommand::class);
        $command->byFilename($filename);

        return $command;
    }

    /**
     * @param string $filename
     * @param mixed  $source
     *
     * @return UploadCommand
     */
    public function upload(string $filename, $source): UploadCommand
    {
        /** @var UploadCommand $command */
        $command = $this->builder->build(UploadCommand::class);
        $command->withFilename($filename)->withSource($source);

        return $command;
    }

    /**
     * @param string $filename
     * @param int    $days      lifetime of the active copy in days
     *
     * @return RestoreCommand
     */
    public function restore(string $filename, int $days): RestoreCommand
    {
        /** @var RestoreCommand $command */
        $command = $this->builder->build(RestoreCommand::class);
        $command->byFilename($filename)->withLifetime($days);

        return $command;
    }

    /**
     * @param string $filename
     *
     * @return ExistCommand
     */
    public function exist(string $filename): ExistCommand
    {
        /** @var ExistCommand $command */
        $command = $this->builder->build(ExistCommand::class);
        $command->byFilename($filename);

        return $command;
    }

    /**
     * @param string $prefix
     *
     * @return ListCommand
     */
    public function list(string $prefix): ListCommand
    {
        /** @var ListCommand $command */
        $command = $this->builder->build(ListCommand::class);
        $command->byPrefix($prefix);

        return $command;
    }

    /**
     * @param string $filename
     *
     * @return GetUrlCommand
     */
    public function getUrl(string $filename): GetUrlCommand
    {
        /** @var GetUrlCommand $command */
        $command = $this->builder->build(GetUrlCommand::class);
        $command->byFilename($filename);

        return $command;
    }

    /**
     * @param string $filename
     * @param mixed  $expires
     *
     * @return GetPresignedUrlCommand
     */
    public function getPresignedUrl(string $filename, mixed $expires = null): GetPresignedUrlCommand
    {
        /** @var GetPresignedUrlCommand $command */
        $command = $this->builder->build(GetPresignedUrlCommand::class);
        $command->byFilename($filename)->withExpiration(!$expires ? $command->getExpiration() : $expires);

        return $command;
    }
}
