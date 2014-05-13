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
    protected $protected;

    public function __construct()
    {
        $this->protected = false;
    }

    public function create($name, $value, $protected)
    {
        $this->name      = $name;
        $this->value     = $value;
        $this->protected = $protected;
    }

    public function modify($name, $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    public function updateParameter(array $value)
    {
        $this->value = $value;
    }

}
