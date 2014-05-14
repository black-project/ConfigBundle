<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Domain\Config;

use Doctrine\ORM\Mapping as ORM;
use Black\Bundle\ConfigBundle\Domain\Model\AbstractConfig;

/**
 * Class Config
 *
 * @ORM\MappedSuperclass()
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class AbstractEntity extends AbstractConfig
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
     * @ORM\Column(name="secure", type="boolean")
     */
    protected $secure;
}
