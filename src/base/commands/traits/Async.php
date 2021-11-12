<?php

namespace aklim\yii2\aws\s3\base\commands\traits;

/**
 * Trait Async.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
trait Async
{
    /** @var bool */
    private bool $isAsync = false;

    /**
     * @return $this
     */
    final public function async()
    {
        $this->isAsync = true;

        return $this;
    }

    /**
     * @return bool
     */
    final public function isAsync(): bool
    {
        return $this->isAsync;
    }
}
