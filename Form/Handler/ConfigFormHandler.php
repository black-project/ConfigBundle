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
use Black\Bundle\CommonBundle\Configuration\Configuration;
use Black\Bundle\CommonBundle\Form\Handler\HandlerInterface;
use Black\Bundle\ConfigBundle\Model\ConfigInterface;

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
     * @var \Symfony\Component\Form\FormInterface
     */
    protected $form;
    /**
     * @var
     */
    protected $configuration;
    /**
     * @var
     */
    protected $url;

    /**
     * @param FormInterface $form
     * @param Configuration $configuration
     */
    public function __construct(
        FormInterface $form,
        Configuration $configuration
    )
    {
        $this->form             = $form;
        $this->configuration    = $configuration;
    }

    /**
     * @param ConfigInterface $config
     *
     * @return bool
     */
    public function process($config)
    {
        $this->form->setData($config);

        if ('POST' === $this->configuration->getRequest()->getMethod()) {

            $this->form->handleRequest($this->configuration->getRequest());

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
        if (!$config->getId()) {
            $this->configuration->getManager()->persist($config);
        }

        $this->configuration->getManager()->flush();

        if (true === $config->getProtected()) {
            $this->setUrl($this->configuration->getRequest()->headers->get('referer'));
            $this->configuration->setFlash('success', 'black.bundle.config.handler.flash.protected');

            return true;
        }

        if (!$config->getId()) {
            $this->configuration->setFlash('success', 'black.bundle.config.handler.flash.create');
        } else {
            $this->configuration->setFlash('success', 'black.bundle.config.handler.flash.update');
        }

        if ($this->form->get('save')->isClicked()) {
            $this->setUrl($this->configuration->generateUrl($this->configuration->getParameter('route')['update'], array('value' => $config->getId())));

            return true;
        }

        if ($this->form->get('saveAndAdd')->isClicked()) {
            $this->setUrl($this->configuration->generateUrl($this->configuration->getParameter('route')['create']));

            return true;
        }
    }

    /**
     * @param ConfigInterface $config
     *
     * @return mixed
     */
    protected function onDelete(ConfigInterface $config)
    {
        $this->configuration->getManager()->remove($config);
        $this->configuration->getManager()->flush();

        $this->configuration->setFlash('success', 'black.bundle.config.handler.flash.delete');
        $this->setUrl($this->configuration->generateUrl($this->configuration->getParameter('route')['index']));

        return true;
    }

    /**
     * @return bool
     */
    protected function onFailed()
    {
        $this->configuration->setFlash('error', 'black.bundle.config.handler.flash.failed');

        return false;
    }
}
