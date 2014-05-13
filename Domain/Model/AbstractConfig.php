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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->protected = false;
    }

    /**
     * {@inheritdoc}
     *
     * @return int|mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of the document
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of the document
     *
     * @param string $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Set the protected status of your document
     *
     * @param boolean $protected
     *
     * @return $this
     */
    public function setProtected($protected)
    {
        $this->protected = $protected;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return bool|mixed|string
     */
    public function getProtected()
    {
        return $this->protected;
    }
}
