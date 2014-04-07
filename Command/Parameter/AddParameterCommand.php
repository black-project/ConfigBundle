<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Command\Parameter;

use Black\Bundle\CommonBundle\Command\CommandInterface;
use Black\Bundle\ConfigBundle\Model\ConfigInterface;

/**
 * Class AddParameterCommand
 *
 * AddParameterCommand return the Config object and values
 *
 * @package Black\Bundle\ConfigBundle\Command\Parameter
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class AddParameterCommand implements CommandInterface
{
    /**
     * @var \Black\Bundle\ConfigBundle\Model\ConfigInterface
     */
    protected $config;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * Construct the command
     *
     * @param ConfigInterface $config
     * @param array           $parameters
     */
    public function __construct(ConfigInterface $config, array $parameters = array())
    {
        $this->config     = $config;
        $this->parameters = $parameters;
    }

    /**
     * Return the Config object
     *
     * @return ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Return an array of parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
} 
