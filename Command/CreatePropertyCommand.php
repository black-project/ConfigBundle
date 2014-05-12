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

use Black\Bundle\ConfigBundle\Factory\CreateProperty;
use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreatePropertyCommand
 *
 * Create new property with command tools
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CreatePropertyCommand extends Command
{
    /**
     * @var \Black\Bundle\ConfigBundle\Factory\CreateProperty
     */
    protected $createProperty;

    /**
     * @var \Black\Bundle\ConfigBundle\Model\ConfigManagerInterface
     */
    protected $configManager;

    /**
     * Construct the command
     *
     * @param CreateProperty         $createProperty
     * @param ConfigManagerInterface $configManager
     */
    public function __construct(CreateProperty $createProperty, ConfigManagerInterface $configManager)
    {
        parent::__construct();

        $this->createProperty = $createProperty;
        $this->configManager  = $configManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('black:property:create')
            ->setDescription('Create a new property')
            ->setDefinition([
                new InputArgument('name', InputArgument::REQUIRED, 'The name of the property'),
                new InputArgument('protected', InputArgument::REQUIRED, 'The status of the property'),
                new InputArgument('value', InputArgument::REQUIRED, 'The value of the property')
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name      = $input->getArgument('name');
        $protected = $input->getArgument('protected');
        $value     = $input->getArgument('value');

        $factory  = $this->createProperty;
        $property = $factory->execute($name, $protected, $value);

        $this->configManager->persist($property);
        $this->configManager->flush();

        $output->writeln(sprintf('Property <comment>%s</comment> is created', $name));
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

        if (!$input->getArgument('protected')) {
            $status    = [true => 'yes', false => 'no'];
            $protected = $this->getHelper('dialog')->select($output, 'Is your property is protected?', $status);

            $input->setArgument('protected', $protected);
        }

        if (!$input->getArgument('value')) {
            $value = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a property value:',
                function ($value) {
                    if (empty($value)) {
                        throw new \InvalidArgumentException('Value can not be empty!');
                    }

                    return $value;
                }
            );

            $input->setArgument('value', $value);
        }
    }
}
