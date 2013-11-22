<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Form\Handler;

use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Black\Bundle\ConfigBundle\Model\ConfigInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Black\Bundle\CommonBundle\Form\Handler\HandlerInterface;

/**
 * Class ConfigFormHandler
 *
 * @package Black\Bundle\ConfigBundle\Form\Handler
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ConfigFormHandler implements HandlerInterface
{
    /**
     * @var \Black\Bundle\ConfigBundle\Model\ConfigManagerInterface
     */
    protected $configManager;

    /**
     * @var \Symfony\Component\Form\FormInterface
     */
    protected $form;

    /**
     * @var
     */
    protected $factory;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    protected $router;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * @var
     */
    protected $url;

    /**
     * @param FormInterface          $form
     * @param ConfigManagerInterface $configManager
     * @param Request                $request
     * @param RouterInterface        $router
     * @param SessionInterface       $session
     */
    public function __construct(FormInterface $form, ConfigManagerInterface $configManager, Request $request, RouterInterface $router, SessionInterface $session)
    {
        $this->form             = $form;
        $this->configManager    = $configManager;
        $this->request          = $request;
        $this->router           = $router;
        $this->session          = $session;
    }

    /***
     * @param ConfigInterface $config
     *
     * @return bool
     */
    public function process($config)
    {
        $this->form->setData($config);

        if ('POST' === $this->request->getMethod()) {

            $this->form->handleRequest($this->request);

            if ($this->form->has('delete') && $this->form->get('delete')->isClicked()) {
                return $this->onDelete($config);
            }

            if ($this->form->isValid()) {
                return $this->onSave($config);
            } else {
                return $this->onFailed();
            }
        }
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param ConfigInterface $config
     *
     * @return mixed
     */
    protected function onSave(ConfigInterface $config)
    {
        $config->upload();

        if (!$config->getId()) {
            $this->configManager->persist($config);
        }

        $this->configManager->flush();

        if (true === $config->getProtected()) {
            $this->setUrl($this->request->headers->get('referer'));

            return true;
        }

        if ($this->form->get('save')->isClicked()) {
            $this->setUrl($this->generateUrl('config_update', array('value' => $config->getId())));

            return true;
        }

        if ($this->form->get('saveAndAdd')->isClicked()) {
            $this->setUrl($this->generateUrl('config_create'));

            return true;
        }
    }

    /**
     * @param $config
     *
     * @return bool
     */
    protected function onDelete($config)
    {
        $this->configManager->remove($config);
        $this->configManager->flush();

        $this->setFlash('success', 'success.page.admin.page.delete');
        $this->setUrl($this->generateUrl('config_index'));

        return true;
    }

    /**
     * @return bool
     */
    protected function onFailed()
    {
        $this->setFlash('error', 'error.page.admin.page.not.valid');

        return false;
    }

    /**
     * @param $name
     * @param $msg
     *
     * @return mixed
     */
    protected function setFlash($name, $msg)
    {
        return $this->session->getFlashBag()->add($name, $msg);
    }

    /**
     * @param       $route
     * @param array $parameters
     * @param       $referenceType
     *
     * @return mixed
     */
    public function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->router->generate($route, $parameters, $referenceType);
    }
}
