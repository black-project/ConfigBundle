<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle;

use Black\Bundle\ConfigBundle\DependencyInjection\BlackConfigExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class BlackConfigBundle
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class BlackConfigBundle extends Bundle
{
    /**
     * @return BlackConfigExtension|null|\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
     */
    public function getContainerExtension()
    {
        return new BlackConfigExtension();
    }
}
