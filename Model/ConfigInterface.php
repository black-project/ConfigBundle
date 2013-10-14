<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Model;

/**
 * Class ConfigInterface
 *
 * @package Black\Bundle\ConfigBundle\Model
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
interface ConfigInterface
{
    /**
     * @return  mixed
     */
    public function getId();

    /**
     * @return  mixed
     */
    public function getName();

    /**
     * @return  mixed
     */
    public function getValue();

    /**
     * @return mixed
     */
    public function getProtected();
}
