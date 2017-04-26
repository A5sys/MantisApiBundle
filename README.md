# MantisApiBundle
A bundle that provides services  for the Mantis API


# Composer

Use composer to get the bundle

    composer require "a5sys/mantis-api-bundle"

# Requirements

PHP extensions:
 - php_soap


# Activate the bundle

In the AppKernel, activate the bundle

            new A5sys\MantisApiBundle\MantisApiBundle(),

# The configuration

In the config.yml, the configuration for the bundle is:

	mantis_api:
	    login: "%mantis_login%"
	    password: "%mantis_password%"
	    url: "%mantis_url%/api/soap/mantisconnect.php"
	    verify_peer: true #mandatory, the ssl option
	    verify_peer_name: true #mandatory, the ssl option
	    allow_self_signed: false #mandatory, the ssl option