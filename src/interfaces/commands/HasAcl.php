<?php

namespace aklim\yii2\aws\s3\interfaces\commands;

/**
 * Interface HasAcl.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
interface HasAcl
{
    /**
     * @param string $acl
     */
    public function withAcl(string $acl);
}
