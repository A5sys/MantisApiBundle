<?php

namespace A5sys\MantisApiBundle\Services;

use A5sys\MantisApiBundle\Exception\UnknownIssueException;
use A5sys\MantisApiBundle\Exception\VersionExistException;

/**
 *
 *
 * ref: mantis_api_bundle.service.mantis_client
 */
class MantisClientService
{
    const FAULT_ISSUE_UNKNOWN = 'SOAP-ENV:Client: Issue does not exist';

    protected $client;
    protected $soapUrl;
    protected $soapWsdlUrl;
    protected $username;
    protected $password;

    /**
     *
     * @param type $url
     * @param type $username
     * @param type $password
     */
    public function __construct($url, $username, $password)
    {
        $this->soapUrl = $url;
        $this->soapWsdlUrl = false;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     *
     * @param string $wsFunction
     * @param array  $params
     * @throws \Exception
     * @return unknown
     */
    public function callWs($wsFunction, $params = array())
    {
        $client = $this->getSoapClient();

        $result = $client->call($wsFunction, $params);

        if ($client->fault) {
            if ($result['faultstring'] === 'Version exists for project') {
                throw new VersionExistException();
            }
        }

        $err = $client->getError();
        if ($err) {
            if ($err === static::FAULT_ISSUE_UNKNOWN) {
                throw new UnknownIssueException($err);
            }
            throw new \LogicException($err);
        }

        return $result;
    }

    /**
     *
     * @param string $wsFunction
     * @param array  $params
     * @throws \Exception
     * @return unknown
     */
    public function callAuthenticatedWs($wsFunction, $params = array())
    {
        $params['username'] = $this->username;
        $params['password'] = $this->password;

        return $this->callWs($wsFunction, $params);
    }

    /**
     * Get the soap client
     *
     * @return \nusoap_client
     */
    protected function getSoapClient()
    {
        if ($this->client === null) {
            $client = new \nusoap_client($this->soapUrl, $this->soapWsdlUrl, false, false, false, false, 0, 300);

            //no debug for better performance
            $client->setGlobalDebugLevel(0);
            //use utf8
            $client->soap_defencoding = 'UTF-8';
            $client->decode_utf8 = false;

            $err = $client->getError();
            if ($err) {
                echo '<h2>Constructor error</h2><pre>'.$err.'</pre>';
                echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES).'</pre>';
                exit();
            }

            $client->useHTTPPersistentConnection();

            $this->client = $client;
        }

        return $this->client;
    }
}
