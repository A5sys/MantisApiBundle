<?php

namespace A5sys\MantisApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 *
 */
class MantisApiExtension extends Extension
{
    /**
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter('mantis_api.login', $configuration['login']);
        $container->setParameter('mantis_api.password', $configuration['password']);
        $container->setParameter('mantis_api.url', $configuration['url']);

        $container->setParameter('mantis_api.verify_peer', $configuration['verify_peer']);
        $container->setParameter('mantis_api.verify_peer_name', $configuration['verify_peer_name']);
        $container->setParameter('mantis_api.allow_self_signed', $configuration['allow_self_signed']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
