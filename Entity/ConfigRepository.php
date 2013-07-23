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

use Black\Bundle\ConfigBundle\Model\ConfigRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class ConfigRepository
 *
 * @package Black\Bundle\ConfigBundle\Entity\Config
 */
class ConfigRepository extends EntityRepository implements ConfigRepositoryInterface
{
}
