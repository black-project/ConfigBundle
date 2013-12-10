<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Black\Bundle\ConfigBundle\Model\AbstractConfig;

/**
 * Class Config
 *
 * @ODM\MappedSuperclass()
 *
 * @package Black\Bundle\ConfigBundle\Document
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class Config extends AbstractConfig
{
    /**
     * @ODM\String
     * @Assert\NotNull
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
