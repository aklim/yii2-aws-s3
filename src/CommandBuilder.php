<?php

namespace aklim\yii2\aws\s3;

use aklim\yii2\aws\s3\interfaces;
use aklim\yii2\aws\s3\interfaces\commands\Command;
use DateTime;
use Yii;
use yii\base\InvalidConfigException;

/**
 * Class  CommandBuilder.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
class CommandBuilder implements interfaces\CommandBuilder
{
    /** @var string default bucket name */
    protected string $bucket;

    /** @var string default acl */
    protected string $acl;

    /** @var int|string|DateTime default expiration */
    protected int|string|DateTime $expiration;

    /** @var interfaces\Bus */
    protected interfaces\Bus $bus;

    /**
     * CommandBuilder constructor.
     *
     * @param \aklim\yii2\aws\s3\interfaces\Bus $bus
     * @param string                            $bucket
     * @param string                            $acl
     * @param int|string|DateTime               $expiration
     */
    public function __construct(interfaces\Bus $bus, string $bucket = '', string $acl = '', int|string|DateTime $expiration = '')
    {
        $this->bus = $bus;
        $this->bucket = $bucket;
        $this->acl = $acl;
        $this->expiration = $expiration;
    }

    /**
     * @param string $commandClass
     *
     * @return Command
     * @throws InvalidConfigException
     */
    public function build(string $commandClass): Command
    {
        $params = is_subclass_of($commandClass, interfaces\commands\ExecutableCommand::class) ? [ $this->bus ] : [];

        /** @var Command $command */
        $command = Yii::createObject($commandClass, $params);

        $this->prepareCommand($command);

        return $command;
    }

    /**
     * @param Command $command
     */
    protected function prepareCommand(Command $command)
    {
        if ( $command instanceof interfaces\commands\HasBucket ) {
            $command->inBucket($this->bucket);
        }

        if ( $command instanceof interfaces\commands\HasAcl ) {
            $command->withAcl($this->acl);
        }

        if ( $command instanceof interfaces\commands\HasExpiration ) {
            $command->withExpiration($this->expiration);
        }
    }
}
