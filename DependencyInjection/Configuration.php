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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Black\Bundle\ConfigBundle\DependencyInjection
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('black_config');

        $supportedDrivers = array('mongodb', 'orm');

        $rootNode
            ->children()

                ->scalarNode('db_driver')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The database driver must be either \'mongodb\', \'orm\'.')
                    ->end()
                ->end()

                ->scalarNode('config_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('config_manager')
                    ->defaultValue('Black\\Bundle\\ConfigBundle\\Doctrine\\ConfigManager')
                ->end()
            ->end();

        $this->addConfigSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addConfigSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('config')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('main_name')->defaultValue('black_config')->end()
                                ->scalarNode('main_type')->defaultValue(
                                    'Black\\Bundle\\ConfigBundle\\Form\\Type\\ConfigType'
                                )->end()
                                ->scalarNode('main_handler')->defaultValue(
                                    'Black\\Bundle\\ConfigBundle\\Form\\Handler\\ConfigFormHandler'
                                )->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
