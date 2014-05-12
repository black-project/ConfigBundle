<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Command;

use Black\Bundle\ConfigBundle\Command\Bus\ParameterBus;
use Black\Bundle\ConfigBundle\Exception\ConfigNotFoundException;
use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AddParameterCommand
 *
 * Create new property with command tools
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class AddParameterCommand extends Command
{
    /**
     * @var
     */
    protected $bus;

    /**
     * @var \Black\Bundle\ConfigBundle\Model\ConfigManagerInterface
     */
    protected $configManager;

    /**
     * Construct the command
     *
     * @param ParameterBus           $bus
     * @param ConfigManagerInterface $configManager
     */
    public function __construct(
        ParameterBus $bus,
        ConfigManagerInterface $configManager
    ) {
        parent::__construct();

        $this->bus           = $bus;
        $this->configManager = $configManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('black:property:parameter')
            ->setDescription('Add a parameter to the property')
            ->setDefinition(array(
                new InputArgument('name', InputArgument::REQUIRED, 'The name of the property'),
                new InputArgument('parameter_name', InputArgument::REQUIRED, 'The name of the parameter'),
                new InputArgument('parameter_value', InputArgument::REQUIRED, 'The value of the parameter')
            ));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name           = $input->getArgument('name');
        $parameterName  = $input->getArgument('parameter_name');
        $parameterValue = $input->getArgument('parameter_value');

        $config = $this->configManager->findPropertyByName($name);

        if (!$config) {
            return new ConfigNotFoundException();
        }

        $process = $this->bus->handle($config, [$parameterName => $parameterValue]);

        if ($process) {
            $this->configManager->flush();

            $output->writeln(sprintf('Parameters <comment>%s</comment> is created', $name));
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException Throw if argument not exist
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('name')) {
            $name = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a property name:',
                function ($name) {
                    if (empty($name)) {
                        throw new \InvalidArgumentException('Name can not be empty!');
                    }

                    return $name;
                }
            );

            $input->setArgument('name', $name);
        }

        if (!$input->getArgument('parameter_name')) {
            $value = $this->getHelper('dialog')->askAndValidate(
                $output,
                'What\'s the name of the parameter?',
                function ($value) {
                    if (empty($value)) {
                        throw new \InvalidArgumentException('Value can not be empty!');
                    }

                    return $value;
                }
            );

            $input->setArgument('parameter_name', $value);
        }

        if (!$input->getArgument('parameter_value')) {
            $value = $this->getHelper('dialog')->askAndValidate(
                $output,
                'What\'s the value of the parameter?',
                function ($value) {
                    if (empty($value)) {
                        throw new \InvalidArgumentException('Value can not be empty!');
                    }

                    return $value;
                }
            );

            $input->setArgument('parameter_value', $value);
        }
    }
}
