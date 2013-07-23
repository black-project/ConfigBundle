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
 */
interface ConfigInterface
{
    /**
     * Return the id
     *
     * @return  mixed
     */
    public function getId();

    /**
     * Return the name
     *
     * @return  mixed
     */
    public function getName();

    /**
     * Set the name
     *
     * @param   $name
     * @return  mixed
     */
    public function setName($name);

    /**
     * Return the value
     *
     * @return  mixed
     */
    public function getValue();

    /**
     * Set the value
     *
     * @param   $value
     * @return  mixed
     */
    public function setValue($value);

    /**
     * If the property is protected
     *
     * @param $protected
     * @return mixed
     */
    public function setProtected($protected);

    /**
     * Return protected value
     *
     * @return mixed
     */
    public function getProtected();
}
