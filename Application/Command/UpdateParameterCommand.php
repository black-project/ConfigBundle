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
 * Class UpdateParameterCommand
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class UpdateParameterCommand
{

    /**
     * @var
     */
    protected $id;

    /**
     * @var
     */
    protected $value;

    /**
     * @param $id
     * @param $value
     */
    public function __construct($id, $value)
    {
        $this->id    = $id;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
} 
