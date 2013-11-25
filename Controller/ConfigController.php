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

use Black\Bundle\CommonBundle\Controller\ControllerInterface;
use Black\Bundle\CommonBundle\Doctrine\ManagerInterface;
use Black\Bundle\CommonBundle\Form\Handler\HandlerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class ConfigController
 *
 * @Route("/config", service="black_config.controller.config")
 *
 * @package Black\Bundle\ConfigBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ConfigController implements ControllerInterface
{
    /**
     * @var \Black\Bundle\CommonBundle\Controller\ControllerInterface
     */
    protected $controller;
    /**
     * @var \Black\Bundle\CommonBundle\Doctrine\ManagerInterface
     */
    protected $manager;
    /**
     * @var \Black\Bundle\CommonBundle\Form\Handler\HandlerInterface
     */
    protected $handler;

    /**
     * @param ControllerInterface $controller
     * @param ManagerInterface    $manager
     * @param HandlerInterface    $handler
     */
    public function __construct(
        ControllerInterface $controller,
        HttpExceptionInterface $exception,
        ManagerInterface $manager,
        HandlerInterface $handler
    )
    {
        $this->controller   = $controller;
        $this->manager      = $manager;
        $this->handler      = $handler;

        $controller->setException($exception);
        $controller->setManager($manager);
        $controller->setHandler($handler);
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/new", name="config_create")
     * @Template()
     *
     * @return array
     */
    public function createAction()
    {
        return $this->controller->createAction();
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
        return $this->controller->deleteAction($value);
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
        return $this->controller->indexAction();
    }

    /**
     * @Method("GET")
     * @Route("/{value}.html", name="config_show")
     * @Template()
     *
     * @param string $slug
     *
     * @return Template
     */
    public function showAction($value)
    {
        return $this->controller->showAction($value);
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
        return $this->controller->updateAction($value);
    }

    /**
     * @return ManagerInterface
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @return HandlerInterface
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return mixed
     */
    public function getException()
    {
        return $this->exception;
    }
}
