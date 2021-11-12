<?php

namespace aklim\yii2\aws\s3\interfaces\commands;

/**
 * Interface HasBucket.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
interface HasBucket
{
    /**
     * @param string $name
     */
    public function inBucket(string $name);
}
