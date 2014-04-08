<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Controller;

use Black\Bundle\CommonBundle\Controller\CommonController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class ConfigController
 *
 * @Route("/config", service="black_config.controller.config")
 *
 * @package Black\Bundle\ConfigBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ConfigController
{
    /**
     * @Method({"GET", "POST"})
     * @Route("/new", name="config_create")
     * @Template()
     *
     * @return array
     */
    public function createAction()
    {
        return array();
    }

    /**
     * @Method({"POST", "GET"})
     * @Route("/{value}/delete", name="config_delete")
     *
     * @param $value
     *
     * @return mixed
     */
    public function deleteAction($value)
    {
        return array();
    }

    /**
     * @Method("GET")
     * @Route("/index.html", name="config_index")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Method("GET")
     * @Route("/{value}.html", name="config_read")
     * @Template()
     *
     * @param string $slug
     *
     * @return Template
     */
    public function readAction($value)
    {
        return array();
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/{value}/update", name="config_update")
     * @Template()
     *
     * @param $value
     *
     * @return mixed
     */
    public function updateAction($value)
    {
        return array();
    }
}
