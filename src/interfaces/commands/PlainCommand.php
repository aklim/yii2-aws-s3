<?php

namespace aklim\yii2\aws\s3\interfaces\commands;

/**
 * Interface PlainCommand.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
interface PlainCommand extends Command
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function toArgs(): array;
}
