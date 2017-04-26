<?php

namespace A5sys\MantisApiBundle\Services;

use A5sys\MantisApiBundle\Exception\UnknownIssueException;

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
    protected $verifyPeer;
    protected $verifyPeerName;
    protected $allowSelfSigned;

    /**
     *
     * @param string  $url
     * @param string  $username
     * @param string  $password
     * @param boolean $verifyPeer
     * @param boolean $verifyPeerName
     * @param boolean $allowSelfSigned
     */
    public function __construct($url, $username, $password, $verifyPeer, $verifyPeerName, $allowSelfSigned)
    {
        $this->soapUrl = $url;
        $this->soapWsdlUrl = $this->soapUrl.'?wsdl';
        $this->username = $username;
        $this->password = $password;
        $this->verifyPeer = $verifyPeer;
        $this->verifyPeerName = $verifyPeerName;
        $this->allowSelfSigned = $allowSelfSigned;
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
        $result = null;

        try {
            $result = $client->__soapCall($wsFunction, $params);
        } catch (\SoapFault $err) {
            if (preg_match('/Issue .+ does not exist./ui', $err->getMessage())) {
                throw new UnknownIssueException($err->getMessage());
            }
            throw $err;
        }

        // Convert stdclass to array
        $result = json_decode(json_encode($result), true);

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
        // Username and password must be the first keys of the array
        $params = array_merge(array(
            'username' => $this->username,
            'password' => $this->password,
        ), $params);

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
             $context = stream_context_create([
                'ssl' => [
                    'verify_peer' => $this->verifyPeer,
                    'verify_peer_name' => $this->verifyPeerName,
                    'allow_self_signed' => $this->allowSelfSigned,
                ]
            ]);

            $this->client = new \SoapClient($this->soapWsdlUrl, array(
                'style' => SOAP_RPC,
                'use' => SOAP_ENCODED,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'connection_timeout' => 300,
                'encoding' => 'UTF-8',
                'exceptions' => true,
                'stream_context' => $context,
            ));
        }

        return $this->client;
    }
}
