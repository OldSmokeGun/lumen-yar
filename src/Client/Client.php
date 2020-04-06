<?php


namespace oldSmokeGun\Rpc\Client;


use oldSmokeGun\Rpc\Exceptions\RpcException;

class Client
{
    /**
     * @var \Yar_Client
     */
    private $client;

    /**
     * @var string
     */
    private $remote;

    /**
     * @var string
     */
    private $serviceClass;

    /**
     * @var string
     */
    private $serviceMethod;

    /**
     * Client constructor.
     *
     * @param string $remote 连接服务器地址
     * @param string $serviceClass 调用的类名
     */
    public function __construct(string $remote, string $serviceClass)
    {
        if ( !trim($remote) )
        {
            throw new RpcException(sprintf("service config key is invalid"));
        }

        if ( !$remote )
        {
            throw new RpcException(sprintf("service remote must be configured"));
        }

        if ( !trim($serviceClass) )
        {
            throw new RpcException(sprintf("service class is invalid"));
        }

        $this->setRemote($remote);

        $remote = substr($remote, -1) == '/' ? $remote . $serviceClass : $remote . "/{$serviceClass}";

        $this->setClient(new \Yar_Client($remote));
        $this->setServiceClass($serviceClass);
    }

    /**
     * @param $option
     * @param $value
     *
     * @return $this
     */
    public function setOptions($option, $value): self
    {
        $this->getClient()->setOpt($option, $value);
        return $this;
    }

    /**
     * @param string $serviceMethod 调用的方法名
     * @param array $params 方法参数
     *
     * @return bool|int|null
     * @throws RpcException
     * @throws \Yar_Client_Exception
     */
    public function call(string $serviceMethod, array $params)
    {
        if ( !trim($serviceMethod) )
        {
            throw new RpcException(sprintf("method name is invalid"));
        }

        $this->setServiceMethod($serviceMethod);

        try {

            return $this->getClient()->call($this->getServiceMethod(), $params);

        } catch ( \Yar_Client_Exception $exception ) {

            throw $exception;
        }

    }

    /**
     * @return string
     */
    public function getRemote(): string
    {
        return $this->remote;
    }

    /**
     * @param string $remote
     */
    public function setRemote( string $remote ): void
    {
        $this->remote = $remote;
    }

    /**
     * @return \Yar_Client
     */
    public function getClient(): \Yar_Client
    {
        return $this->client;
    }

    /**
     * @param \Yar_Client $client
     */
    public function setClient( \Yar_Client $client ): void
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getServiceClass(): string
    {
        return $this->serviceClass;
    }

    /**
     * @param string $serviceClass
     */
    public function setServiceClass( string $serviceClass ): void
    {
        $this->serviceClass = $serviceClass;
    }

    /**
     * @return string
     */
    public function getServiceMethod(): string
    {
        return $this->serviceMethod;
    }

    /**
     * @param string $serviceMethod
     */
    public function setServiceMethod( string $serviceMethod ): void
    {
        $this->serviceMethod = $serviceMethod;
    }
}
