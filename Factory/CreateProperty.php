<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Factory;

use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class CreateProperty
 *
 * Create a new Config property
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CreateProperty
{
    /**
     * @var \Black\Bundle\ConfigBundle\Model\ConfigManagerInterface
     */
    protected $manager;

    /**
     * Construct the factory
     *
     * @param ConfigManagerInterface $manager
     */
    public function __construct(ConfigManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Execute the factory and create a new Config property
     *
     * @param string  $name
     * @param boolean $protected
     * @param string  $value
     *
     * @return mixed
     */
    public function execute($name, $protected, $value)
    {
        $property = $this->manager->createInstance();

        $property
            ->setName($name)
            ->setProtected($protected)
            ->setValue($value);

        $this->manager->persist($property);
        $this->manager->flush();

        return $property;
    }
}
