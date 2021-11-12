<?php

namespace aklim\yii2\aws\s3\interfaces\commands;

use DateTime;

/**
 * Interface HasExpiration.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
interface HasExpiration
{
    /**
     * @param int|string|DateTime $expiration
     */
    public function withExpiration(int|string|DateTime $expiration);
}
