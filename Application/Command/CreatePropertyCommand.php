<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Application\Command;

/**
 * Class CreatePropertyCommand
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CreatePropertyCommand
{

    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $value;

    /**
     * @var
     */
    protected $protected;

    /**
     * @param $name
     * @param $value
     * @param $protected
     */
    public function __construct($name, $value, $protected)
    {
        $this->name      = $name;
        $this->value     = $value;
        $this->protected = $protected;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getProctected()
    {
        return $this->protected;
    }
} 
