<?php

namespace A5sys\MantisApiBundle\Services;

/**
 *
 */
abstract class AbstractService
{
    protected $clientService = null;

    /**
     *
     * @param MantisClientService $clientService
     */
    public function __construct(MantisClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * Get the client
     *
     * @return MantisClientService
     */
    protected function getClientService()
    {
        return $this->clientService;
    }
}
