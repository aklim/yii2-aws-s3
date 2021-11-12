<?php

namespace aklim\yii2\aws\s3\base\handlers;

use aklim\yii2\aws\s3\interfaces\handlers\Handler as HandlerInterface;
use Aws\S3\S3Client;

/**
 * Class Handler.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
abstract class Handler implements HandlerInterface
{
    /** @var S3Client */
    protected S3Client $s3Client;

    /**
     * Handler constructor.
     *
     * @param S3Client $s3Client
     */
    public function __construct(S3Client $s3Client)
    {
        $this->s3Client = $s3Client;
    }
}
