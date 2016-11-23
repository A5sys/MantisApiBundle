<?php

namespace A5sys\MantisApiBundle\Services;

/**
 *
 * ref: mantis_api_bundle.service.version
 */
class VersionService extends AbstractService
{
    /**
     * Get the version
     *
     * @return string The version
     */
    public function getVersion()
    {
        $client = $this->getClientService();
        $wsFunction = 'mc_version';

        return $client->callWs($wsFunction);
    }
}
