<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\ConfigBundle\Doctrine;

use Black\Bundle\ConfigBundle\Model\ConfigInterface;
use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ConfigManager
 *
 * @package Black\Bundle\ConfigBundle\Config
 */
class ConfigManager implements ConfigManagerInterface
{
    /**
     * @var array
     */
    protected $properties = array();

    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor
     *
     * @param ObjectManager $dm
     * @param string        $class
     */
    public function __construct(ObjectManager $dm, $class)
    {
        $this->manager     = $dm;
        $this->repository  = $dm->getRepository($class);

        $metadata          = $dm->getClassMetadata($class);
        $this->class       = $metadata->name;
        $this->loadProperties();
    }

    /**
     * @return DocumentManager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param object $model
     *
     * @throws \InvalidArgumentException
     */
    public function persist($model)
    {
        if (!$model instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($model));
        }

        $this->getManager()->persist($model);
    }

    /**
     * Flush
     */
    public function flush()
    {
        $this->getManager()->flush();
    }

    /**
     * Remove the document
     * 
     * @param object $model
     *
     * @throws \InvalidArgumentException
     */
    public function remove($model)
    {
        if (!$model instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($model));
        }
        $this->getManager()->remove($model);
    }

    /**
     * Save and Flush a new document
     *
     * @param mixed $model
     */
    public function persistAndFlush($model)
    {
        $this->persist($model);
        $this->flush();
    }

    /**
     * Remove and flush
     * 
     * @param mixed $model
     */
    public function removeAndFlush($model)
    {
        $this->getManager()->remove($model);
        $this->getManager()->flush();
    }

    /**
     * Create a new model
     *
     * @return $config object
     */
    public function createInstance()
    {
        $class  = $this->getClass();
        $model = new $class;

        return $model;
    }

    /**
     * @return string
     */
    protected function getClass()
    {
        return $this->class;
    }

    /**
     * @param ConfigInterface $property
     */
    public function updateProperty(ConfigInterface $property)
    {
        $this->getManager()->merge($property);
        $this->getManager()->flush();
    }

    /**
     * @param array $criteria
     *
     * @return array
     */
    public function findPropertiesBy(array $criteria)
    {
        return $this->getRepository()->findBy($criteria);
    }

    /**
     * Find property by it's id
     *
     * @param integer $id
     * 
     * @return \Black\Bundle\ConfigBundle\Model\ConfigInterface|object
     */
    public function findPropertyById($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * Find property by it's name
     *
     * @param string  $name
     * 
     * @return \Black\Bundle\ConfigBundle\Model\ConfigInterface|object
     */
    public function findPropertyByName($name)
    {
        return $this->getRepository()->findOneBy(array('name' => $name));
    }

    /**
     * Get loaded properties
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Load properties
     */
    public function loadProperties()
    {
        if (array() !== $this->properties) {
            return;
        }

        $this->properties = $this->getRepository()->findAll();
    }

    /**
     * Unload properties and load again
     */
    public function reloadProperties()
    {
        $this->unload();
        $this->loadProperties();
    }

    /**
     * Unload properties
     */
    public function unload()
    {
        $this->properties = array();
    }
}
