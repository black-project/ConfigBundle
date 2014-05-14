<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractConfig
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class AbstractConfig implements ConfigInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @Assert\NotNull
     *
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $secure;

    /**
     *
     */
    public function __construct()
    {
        $this->secure = false;
    }

    /**
     * @param $name
     * @param $value
     * @param $secure
     */
    public function create($name, $value, $secure)
    {
        $this->name   = $name;
        $this->value  = $value;
        $this->secure = $secure;
    }

    /**
     * @param $name
     * @param $value
     */
    public function modify($name, $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    /**
     * @param array $value
     */
    public function updateParameter(array $value)
    {
        $this->value = $value;
    }

}
