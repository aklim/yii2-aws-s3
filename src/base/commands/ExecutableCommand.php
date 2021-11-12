<?php

namespace aklim\yii2\aws\s3\base\commands;

use aklim\yii2\aws\s3\interfaces\Bus;
use aklim\yii2\aws\s3\interfaces\commands\ExecutableCommand as ExecutableCommandInterface;

/**
 * Class ExecutableCommand.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
abstract class ExecutableCommand implements ExecutableCommandInterface
{
    /** @var Bus */
    private Bus $bus;

    /**
     * ExecutableCommand constructor.
     *
     * @param Bus $bus
     */
    public function __construct(Bus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @return mixed
     */
    public function execute(): mixed
    {
        return $this->bus->execute($this);
    }
}
