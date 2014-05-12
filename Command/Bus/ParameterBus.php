<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Command\Bus;

use Black\Bundle\CommonBundle\Command\BusInterface;
use Black\Bundle\ConfigBundle\Command\Parameter\AddParameterCommand;
use Black\Bundle\ConfigBundle\Command\Parameter\AddParameterHandler;
use Black\Bundle\ConfigBundle\Model\ConfigInterface;
use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;

/**
 * Class ParameterBus
 *
 * ParameterBus get a Config object and add parameters.
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ParameterBus implements BusInterface
{
    /**
     * @var
     */
    protected $manager;

    /**
     * @var
     */
    protected $parameterHandler;

    /**
     * Construct the bus
     *
     * @param ConfigManagerInterface $manager
     * @param AddParameterHandler    $parameterHandler
     */
    public function __construct(
        ConfigManagerInterface $manager,
        AddParameterHandler $parameterHandler
    ) {
        $this->manager          = $manager;
        $this->parameterHandler = $parameterHandler;
    }

    /**
     * Handle the parameters
     *
     * @param ConfigInterface $config
     * @param array           $parameters
     *
     * @return bool
     */
    public function handle(ConfigInterface $config, array $parameters)
    {
        $config = $this->addParameter($config, $parameters);

        if ($config) {
            return $config;
        }
    }

    /**
     * Create the command
     *
     * @param ConfigInterface $config
     * @param array           $parameters
     *
     * @return bool
     */
    protected function addParameter(ConfigInterface $config, array $parameters)
    {
        $command = new AddParameterCommand($config, $parameters);

        $this->parameterHandler->invoke($command);
        $config = $this->parameterHandler->execute();

        return $config;
    }
}
