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

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Black\Bundle\ConfigBundle\Domain\Model\AbstractConfig;

/**
 * Class Config
 *
 * @ODM\MappedSuperclass()
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class AbstractMongo extends AbstractConfig
{
    /**
     * @ODM\String
     */
    protected $name;

    /**
     * @ODM\Raw
     */
    protected $value;

    /**
     * @ODM\Boolean()
     */
    protected $protected;
}
