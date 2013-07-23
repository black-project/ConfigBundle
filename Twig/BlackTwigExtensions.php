<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\ConfigBundle\Twig;

use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;

/**
 * Class BlackTwigExtensions
 *
 * @package Black\Bundle\ConfigBundle\Twig
 */
class BlackTwigExtensions extends \Twig_Extension
{
    /**
     * @var \Black\Bundle\ConfigBundle\Model\ConfigManagerInterface
     */
    protected $manager;

    /**
     * @param ConfigManagerInterface $manager
     */
    public function __construct(ConfigManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return array
     */
    public function getGlobals()
    {
        return array(
            'black'     => $this->getGeneralProperty(),
            'blackmail' => $this->getMailProperty()
        );
    }

    /**
     * @return null
     */
    protected function getGeneralProperty()
    {
        $property = $this->manager->findPropertyByName('General');

        return $property ? $property->getValue() : null;
    }

    /**
     * @return null
     */
    protected function getMailProperty()
    {
        $property = $this->manager->findPropertyByName('Mail');

        return $property ? $property->getValue() : null;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black';
    }
}
