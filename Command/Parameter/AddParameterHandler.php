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

use Black\Bundle\CommonBundle\Command\HandlerInterface;
use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;

/**
 * Class AddParameterHandler
 *
 * AddParameterHandler add parameters to a Config object
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class AddParameterHandler implements HandlerInterface
{
    /**
     * @var AddParameterCommand
     */
    protected $command;

    /**
     * Execute the command
     *
     * @return bool
     */
    public function execute()
    {
        $command = $this->command;
        $current = (array) $command->getConfig()->getValue();

        $parameters = array_merge($current, $command->getParameters());

        $config = $command->getConfig()->setValue($parameters);

        return $config;
    }

    /**
     * Invoke the AddParameterCommand
     *
     * @param AddParameterCommand $command
     */
    public function invoke(AddParameterCommand $command)
    {
        $this->command = $command;
    }
}
