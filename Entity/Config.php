<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Black\Bundle\ConfigBundle\Model\AbstractConfig;

/**
 * Class Config
 *
 * @package Black\Bundle\ConfigBundle\Entity\Config
 */
abstract class Config extends AbstractConfig
{
    /**
     * @ORM\Column(name="name", type="string")
     * @Assert\NotNull
     */
    protected $name;

    /**
     * @ORM\Column(name="value",type="array")
     */
    protected $value;

    /**
     * @ORM\Column(name="protected", type="boolean")
     */
    protected $protected;

    /**
     * Upload
     */
    public function upload()
    {
        if (!isset($this->value['picture'])) {
            return;
        }

        if (null === $this->value['picture']) {
            return;
        }

        $this->value['site_logo'] = sha1(uniqid(mt_rand(), true)) . '.' . $this->value['picture']->guessExtension();
        $this->value['picture']->move($this->getUploadRootDir(), $this->value['site_logo']);

        unset($this->value['picture']);
    }

    /**
     * @ODM\PostRemove()
     */
    public function removeUpload()
    {
        if ($image = $this->getAbsolutePath()) {
            unlink($image);
        }
    }

    /**
     * @ODM\PreRemove
     */
    public function onRemove()
    {
    }
}
