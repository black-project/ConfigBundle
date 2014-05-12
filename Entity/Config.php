<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Black\Bundle\ConfigBundle\Model\AbstractConfig;

/**
 * Class Config
 *
 * @ORM\MappedSuperclass()
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class Config extends AbstractConfig
{
    /**
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @ORM\Column(name="value", type="array")
     */
    protected $value;

    /**
     * @ORM\Column(name="protected", type="boolean")
     */
    protected $protected;
}
