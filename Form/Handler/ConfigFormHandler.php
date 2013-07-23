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

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Black\Bundle\ConfigBundle\Model\ConfigInterface;

/**
 * Class ConfigFormHandler
 *
 * @package Black\Bundle\ConfigBundle\Form\Handler
 */
class ConfigFormHandler
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Symfony\Component\Form\FormInterface
     */
    protected $form;

    /**
     * @var
     */
    protected $factory;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * @param FormInterface    $form
     * @param Request          $request
     * @param SessionInterface $session
     */
    public function __construct(FormInterface $form, Request $request, SessionInterface $session)
    {
        $this->form     = $form;
        $this->request  = $request;
        $this->session  = $session;
    }

    /***
     * @param ConfigInterface $config
     * @return bool
     */
    public function process(ConfigInterface $config)
    {
        $this->form->setData($config);

        if ('POST' === $this->request->getMethod()) {

            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $config->upload();
                $this->setFlash('success', 'success.config.admin.config.edit');

                return true;
            } else {
                $this->setFlash('error', 'error.config.admin.config.edit');
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
     * @param $name
     * @param $msg
     *
     * @return mixed
     */
    protected function setFlash($name, $msg)
    {
        return $this->session->getFlashBag()->add($name, $msg);
    }
}
