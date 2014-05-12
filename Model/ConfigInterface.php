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
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
interface ConfigInterface
{
    /**
     * Return The id of the document
     *
     * @return  mixed
     */
    public function getId();

    /**
     * Return the name of the document
     *
     * @return  mixed
     */
    public function getName();

    /**
     * Return the value of the document
     *
     * @return  mixed
     */
    public function getValue();

    /**
     * Return the protected status of the document
     *
     * @return mixed
     */
    public function getProtected();
}
