<?php

namespace aklim\yii2\aws\s3;

use aklim\yii2\aws\s3\handlers\PlainCommandHandler;
use aklim\yii2\aws\s3\interfaces;
use aklim\yii2\aws\s3\interfaces\commands\Command;
use aklim\yii2\aws\s3\interfaces\handlers\Handler;
use Aws\S3\S3Client;
use Yii;
use yii\base\Configurable;
use yii\base\Exception;
use yii\base\InvalidConfigException;

/**
 * Class HandlerResolver.
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
class HandlerResolver implements interfaces\HandlerResolver, Configurable
{
    /** @var array */
    protected array $handlers = [];

    /** @var string */
    protected string $plainCommandHandlerClassName = PlainCommandHandler::class;

    /** @var S3Client */
    protected S3Client $s3Client;

    /**
     * HandlerResolver constructor.
     *
     * @param S3Client $s3Client
     * @param array    $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct(S3Client $s3Client, array $config = [])
    {
        $this->configure($config);
        $this->s3Client = $s3Client;
    }

    /**
     * @param array $properties
     *
     * @return void
     */
    private function configure(array $properties): void
    {
        foreach ($properties as $name => $value) {
            $this->{$name} = $value;
        }
    }

    /**
     * @param Command $command
     *
     * @return Handler
     * @throws Exception
     */
    public function resolve(Command $command): Handler
    {
        $commandClass = get_class($command);

        if (isset($this->handlers[$commandClass])) {
            $handler = $this->handlers[$commandClass];

            return is_object($handler) ? $handler : $this->createHandler($handler);
        }

        if ($command instanceof interfaces\commands\PlainCommand) {
            return $this->createHandler($this->plainCommandHandlerClassName);
        }

        $handlerClass = $commandClass . 'Handler';
        if (class_exists($handlerClass)) {
            return $this->createHandler($handlerClass);
        }

        $handlerClass = str_replace('\\commands\\', '\\handlers\\', $handlerClass);
        if (class_exists($handlerClass)) {
            return $this->createHandler($handlerClass);
        }

        throw new Exception("Could not terminate the handler of a command of type \"{$commandClass}\"");
    }

    /**
     * @param string $commandClass
     * @param mixed  $handler
     */
    public function bindHandler(string $commandClass, $handler): void
    {
        $this->handlers[$commandClass] = $handler;
    }

    /**
     * @param array $handlers
     */
    public function setHandlers(array $handlers): void
    {
        foreach ($handlers as $commandClass => $handler) {
            $this->bindHandler($commandClass, $handler);
        }
    }

    /**
     * @param string $className
     */
    public function setPlainCommandHandler(string $className): void
    {
        $this->plainCommandHandlerClassName = $className;
    }

    /**
     * @param string|array $type
     *
     * @return Handler
     * @throws InvalidConfigException
     */
    protected function createHandler(string|array $type): Handler
    {
        return Yii::createObject($type, [$this->s3Client]);
    }
}
