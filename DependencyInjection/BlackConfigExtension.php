<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class BlackConfigExtension
 *
 * @package Black\Bundle\ConfigBundle\DependencyInjection
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class BlackConfigExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor      = new Processor();
        $configuration  = new Configuration();
        $config         = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (!isset($config['db_driver'])) {
            throw new \InvalidArgumentException('You must provide the black_config.db_driver configuration');
        }

        try {
            $loader->load(sprintf('%s.xml', $config['db_driver']));
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException(
                sprintf('The db_driver "%s" is not supported by config', $config['db_driver'])
            );
        }

        foreach (array('twig', 'services') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $this->remapParametersNamespaces(
            $config,
            $container,
            array(
                '' => array(
                    'db_driver'             => 'black_config.db_driver',
                    'config_class'          => 'black_config.config.model.class',
                    'config_manager'        => 'black_config.config.manager'
                )
            )
        );

        if (!empty($config['config'])) {
            $this->loadConfig($config['config'], $container, $loader);
        }

        if (!empty($config['controller'])) {
            $this->loadController($config['controller'], $container, $loader);
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param XmlFileLoader    $loader
     */
    private function loadConfig(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('config.xml');

        $this->remapParametersNamespaces(
            $config,
            $container,
            array(
                'form'  => 'black_config.config.form.%s',
            )
        );
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param XmlFileLoader    $loader
     */
    private function loadController(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('controller.xml');

        $this->remapParametersNamespaces(
            $config,
            $container,
            array(
                'class'    => 'black_config.controller.class.%s',
            )
        );
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param array            $map
     */
    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
    {
        foreach ($map as $name => $paramName) {
            if (array_key_exists($name, $config)) {
                $container->setParameter($paramName, $config[$name]);
            }
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param array            $namespaces
     */
    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
    {
        foreach ($namespaces as $ns => $map) {
            if ($ns) {
                if (!array_key_exists($ns, $config)) {
                    continue;
                }
                $namespaceConfig = $config[$ns];
            } else {
                $namespaceConfig = $config;
            }
            if (is_array($map)) {
                $this->remapParameters($namespaceConfig, $container, $map);
            } else {
                foreach ($namespaceConfig as $name => $value) {
                    $container->setParameter(sprintf($map, $name), $value);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'black_config';
    }
}
