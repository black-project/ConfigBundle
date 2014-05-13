<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\ConfigBundle\Infrastructure\Persistence;

use Black\Bundle\ConfigBundle\Domain\Model\ConfigRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class ConfigEntityRepository
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ConfigEntityRepository extends EntityRepository implements ConfigRepositoryInterface
{
}
