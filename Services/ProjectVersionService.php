<?php

namespace A5sys\MantisApiBundle\Services;

/**
 *
 * ref: mantis_api_bundle.service.project_version
 */
class ProjectVersionService extends AbstractService
{
    const DATE_FORMAT = 'Y-m-d';

    /**
     * Get the versions
     * @param int $projectId
     * @return array The versions
     */
    public function getVersions($projectId)
    {
        $client = $this->getClientService();
        $wsFunction = 'mc_project_get_versions';

        $params = [
            'project_id' => $projectId,
        ];

        return $client->callAuthenticatedWs($wsFunction, $params);
    }

    /**
     * Add version
     * @param int    $projectId
     * @param string $version   The version
     */
    public function addVersion($projectId, $version)
    {
        $client = $this->getClientService();
        $wsFunction = 'mc_project_version_add';

        $dateOrder = new \DateTime();

        $versionData = [
            'name' => $version,
            'project_id' => $projectId,
            'date_order' => $dateOrder->format(static::DATE_FORMAT),
            'description' => '',
            'released' => false,
        ];

        $params = [
            'version' => $versionData,
        ];

        $client->callAuthenticatedWs($wsFunction, $params);
    }
}
