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
        $configuration = new Configuration();
        $configuration = $this->processConfiguration($configuration, $configs);

        $container->setParameter('mantis_api.login', $configuration['login']);
        $container->setParameter('mantis_api.password', $configuration['password']);
        $container->setParameter('mantis_api.url', $configuration['url']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
