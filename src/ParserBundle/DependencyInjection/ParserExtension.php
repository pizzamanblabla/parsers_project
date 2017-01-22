<?php

namespace ParserBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ParserExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        foreach ($this->getConfigurationList() as $config) {
            $loader->load($config);
        }
    }

    /**
     * @return string[]
     */
    private function getConfigurationList()
    {
        return [
            'parsers.yml',
            'command.yml',
            'services.yml',
        ];
    }
}

