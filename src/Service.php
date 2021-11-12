<?php

namespace aklim\yii2\aws\s3;

use aklim\yii2\aws\s3\interfaces\commands\Command;
use aklim\yii2\aws\s3\interfaces\HandlerResolver;
use aklim\yii2\aws\s3\interfaces\Service as ServiceInterface;
use Aws\Credentials\CredentialsInterface;
use Aws\ResultInterface;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Class Service.
 *
 * @property HandlerResolver $resolver
 *
 * @method ResultInterface  get( string $filename )
 * @method ResultInterface  put( string $filename, $body )
 * @method ResultInterface  delete( string $filename )
 * @method ResultInterface  upload( string $filename, $source )
 * @method ResultInterface  restore( string $filename, int $days )
 * @method ResultInterface  list( string $prefix )
 * @method bool             exist( string $filename )
 * @method string           getUrl( string $filename )
 * @method string           getPresignedUrl( string $filename, $expires )
 *
 * @author Andrey Klimenko <andrey@cyberwrite.com>
 */
class Service extends Component implements ServiceInterface
{
    /** @var string */
    public string $defaultBucket = '';

    /** @var string */
    public string $defaultAcl = '';

    /** @var int|string|DateTime */
    public int|string|DateTime $defaultPresignedExpiration = '';

    /** @var array S3Client config */
    protected array $clientConfig = [ 'version' => 'latest' ];

    /** @var array */
    private array $components = [];

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ( empty($this->clientConfig['region']) ) {
            throw new InvalidConfigException('Region is not set.');
        }

        if ( empty($this->defaultBucket) ) {
            throw new InvalidConfigException('Default bucket name is not set.');
        }

        foreach ( $this->defaultComponentDefinitions() as $name => $definition ) {
            $this->components[ $name ] = $this->components[ $name ] ?? $definition;
        }
    }

    /**
     * Executes a command.
     *
     * @param Command $command
     *
     * @return mixed
     */
    public function execute(Command $command): mixed
    {
        return $this->getComponent('bus')->execute($command);
    }

    /**
     * Creates a command with default params.
     *
     * @param string $commandClass
     *
     * @return Command
     */
    public function create(string $commandClass): Command
    {
        return $this->getComponent('builder')->build($commandClass);
    }

    /**
     * Returns command factory.
     *
     * @return CommandFactory
     */
    public function commands(): CommandFactory
    {
        return $this->getComponent('factory');
    }

    /**
     * Returns handler resolver.
     *
     * @return HandlerResolver
     */
    public function getResolver(): HandlerResolver
    {
        return $this->getComponent('resolver');
    }

    /**
     * @param string $name
     * @param array  $params
     *
     * @return mixed
     */
    public function __call($name, $params)
    {
        if ( method_exists($this->commands(), $name) ) {
            $result = call_user_func_array([ $this->commands(), $name ], $params);

            return $result instanceof Command ? $this->execute($result) : $result;
        }

        return parent::__call($name, $params);
    }

    /**
     * @param CredentialsInterface|array|callable $credentials
     */
    public function setCredentials(CredentialsInterface|array|callable $credentials)
    {
        $this->clientConfig['credentials'] = $credentials;
    }

    /**
     * @param string $region
     */
    public function setRegion(string $region)
    {
        $this->clientConfig['region'] = $region;
    }

    /**
     * @param array|bool $debug
     */
    public function setDebug(array|bool $debug)
    {
        $this->clientConfig['debug'] = $debug;
    }

    /**
     * @param array $options
     */
    public function setHttpOptions(array $options)
    {
        $this->clientConfig['http'] = $options;
    }

    /**
     * @param string|array|object $resolver
     */
    public function setResolver(string|array|object $resolver)
    {
        $this->setComponent('resolver', $resolver);
    }

    /**
     * @param string|array|object $bus
     */
    public function setBus(string|array|object $bus)
    {
        $this->setComponent('bus', $bus);
    }

    /**
     * @param string|array|object $builder
     */
    public function setBuilder(string|array|object $builder)
    {
        $this->setComponent('builder', $builder);
    }

    /**
     * @param string|array|object $factory
     */
    public function setFactory(string|array|object $factory)
    {
        $this->setComponent('factory', $factory);
    }

    /**
     * @param string $name
     *
     * @return object
     */
    protected function getComponent(string $name)
    {
        if ( !is_object($this->components[ $name ]) ) {
            $this->components[ $name ] = $this->createComponent($name);
        }

        return $this->components[ $name ];
    }

    /**
     * @param string              $name
     * @param array|object|string $definition
     */
    protected function setComponent(string $name, $definition)
    {
        if ( !is_object($definition) ) {
            $definition = !is_array($definition) ? [ 'class' => $definition ] : $definition;
            $definition = ArrayHelper::merge($this->defaultComponentDefinitions()[ $name ], $definition);
        }

        $this->components[ $name ] = $definition;
    }

    /**
     * @param string $name
     *
     * @return object
     * @throws InvalidConfigException
     */
    protected function createComponent(string $name)
    {
        $definition = $this->components[ $name ];
        $params = $this->getComponentParams($name);

        return Yii::createObject($definition, $params);
    }

    /**
     * @return array
     */
    #[ArrayShape( [ 'client'  => "string[]", 'resolver' => "string[]", 'bus' => "string[]", 'builder' => "string[]",
                    'factory' => "string[]" ] )]
    protected function defaultComponentDefinitions(): array
    {
        return [
            'client'   => [ 'class' => 'Aws\S3\S3Client' ],
            'resolver' => [ 'class' => 'aklim\yii2\aws\s3\HandlerResolver' ],
            'bus'      => [ 'class' => 'aklim\yii2\aws\s3\Bus' ],
            'builder'  => [ 'class' => 'aklim\yii2\aws\s3\CommandBuilder' ],
            'factory'  => [ 'class' => 'aklim\yii2\aws\s3\CommandFactory' ],
        ];
    }

    /**
     * @param string $name
     *
     * @return array
     */
    protected function getComponentParams(string $name): array
    {
        return match ( $name ) {
            'client' => [ $this->clientConfig ],
            'resolver' => [ $this->getComponent('client') ],
            'bus' => [ $this->getComponent('resolver') ],
            'builder' => [ $this->getComponent('bus'), $this->defaultBucket, $this->defaultAcl,
                $this->defaultPresignedExpiration ],
            'factory' => [ $this->getComponent('builder') ],
            default => [],
        };
    }
}
