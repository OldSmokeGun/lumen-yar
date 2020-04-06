<?php

namespace oldSmokeGun\Rpc\Server;

class Server
{
    public function handle($service)
    {
        $class = '\\App\\Services\\' . ucfirst($service);
        $server = new \Yar_Server(new $class);
        $server->handle();
    }
}
