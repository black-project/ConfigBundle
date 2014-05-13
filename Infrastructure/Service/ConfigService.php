<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Infrastructure\Service;

use Black\Bundle\ConfigBundle\Application\Command\ModifyPropertyCommand;
use Black\Bundle\ConfigBundle\Application\Command\CreatePropertyCommand;
use Black\Bundle\ConfigBundle\Application\Command\UpdateParameterCommand;
use Black\Bundle\ConfigBundle\Domain\Exception\ConfigNotFoundException;
use Black\Bundle\ConfigBundle\Infrastructure\Doctrine\ConfigManager;

/**
 * Class ConfigService
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ConfigService
{
    /**
     * @var \Black\Bundle\ConfigBundle\Infrastructure\Doctrine\ConfigManager
     */
    protected $manager;

    /**
     * @param ConfigManager $manager
     */
    public function __construct(ConfigManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param CreatePropertyCommand $command
     */
    public function createProperty(CreatePropertyCommand $command)
    {
        $property = $this->manager->createInstance();

        $property->create($command->getName(), $command->getValue(), $command->getProctected());

        $this->manager->persist($property);
        $this->manager->flush();
    }

    /**
     * @param ModifyPropertyCommand $command
     *
     * @return ConfigNotFoundException
     */
    public function modifyProperty(ModifyPropertyCommand $command)
    {
        if (!$property = $this->manager->find($command->getId())) {
            return new ConfigNotFoundException();
        }

        $property->modify($command->getName(), $command->getValue());

        $this->manager->flush();
    }

    /**
     * @param UpdateParameterCommand $command
     *
     * @return ConfigNotFoundException
     */
    public function updateParameter(UpdateParameterCommand $command)
    {
        if (!$property = $this->manager->find($command->getId())) {
            return new ConfigNotFoundException();
        }

        $property->updateParameter($command->getValue());
        $this->manager->flush();
    }
}
