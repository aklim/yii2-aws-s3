<?php

namespace aklim\yii2\aws\s3\interfaces\commands;

/**
 * Interface Asynchronous.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
interface Asynchronous
{
    /**
     * @return mixed
     */
    public function async();

    /**
     * @return bool
     */
    public function isAsync(): bool;
}
