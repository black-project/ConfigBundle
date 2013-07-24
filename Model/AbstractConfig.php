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
 * Class AbstractConfig
 *
 * @package Black\Bundle\ConfigBundle\Model
 */
abstract class AbstractConfig implements ConfigInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
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
    protected $protected = false;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setProtected($protected)
    {
        $this->protected = $protected;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProtected()
    {
        return $this->protected;
    }

    /**
     *
     */
    public function upload()
    {
        if (null === $this->value['picture']) {
            return;
        }

        $this->value['site_logo'] = sha1(uniqid(mt_rand(), true)) . '.' . $this->value['picture']->guessExtension();
        $this->value['picture']->move($this->getUploadRootDir(), $this->value['site_logo']);

        unset($this->value['picture']);
    }

    /**
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->value['site_logo'] ? null : $this->getUploadRootDir() . '/' . $this->value['site_logo'];
    }

    /**
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->value['site_logo'] ? null : $this->getUploadDir() . '/' . $this->value['site_logo'];
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../../../web/' . $this->getUploadDir();
    }

    /**
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads/settings';
    }
}
