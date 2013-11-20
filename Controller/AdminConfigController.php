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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Black\Bundle\ConfigBundle\Form\Type;
use Black\Bundle\ConfigBundle\Exception\ConfigNotFoundException;
use Black\Bundle\ConfigBundle\Form\Handler\ConfigFormHandler;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;

/**
 * Class AdminConfigController
 *
 * @Route("/admin/config", service="black_config.controller.admin_config")
 *
 * @package Black\Bundle\ConfigBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class AdminConfigController implements ConfigControllerInterface
{
    /**
     * @var ConfigManagerInterface
     */
    protected $configManager;
    /**
     * @var \Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface
     */
    protected $csrf;
    /**
     * @var \Black\Bundle\ConfigBundle\Form\Handler\ConfigFormHandler
     */
    protected $handler;
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;
    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * @param ConfigManagerInterface $configManager
     * @param ConfigFormHandler      $handler
     * @param Request                $request
     * @param CsrfProviderInterface  $csrf
     * @param SessionInterface       $session
     * @param Router                 $router
     */
    public function __construct(
        ConfigManagerInterface $configManager,
        ConfigFormHandler $handler,
        CsrfProviderInterface $csrf,
        Request $request,
        Router $router,
        SessionInterface $session
    )
    {
        $this->configManager    = $configManager;
        $this->handler          = $handler;
        $this->request          = $request;
        $this->csrf             = $csrf;
        $this->session          = $session;
        $this->router           = $router;
    }

    /**
     * @Method({"POST"})
     * @Route("/config/batch", name="admin_config_batch")
     *
     * @return array
     *
     * @throws \Symfony\Component\Serializer\Exception\InvalidArgumentException If method does not exist
     */
    public function batchAction()
    {
        $request    = $this->request;
        $flashBag   = $this->session->getFlashBag();

        $token      = $this->csrf->isCsrfTokenValid('batch', $request->get('token'));

        if (false === $token) {
            $flashBag->add('error', 'black.bundle.config.error.config.admin.config.crsf');

            return new RedirectResponse($this->generateUrl('admin_config'));
        }

        if (!$action = $request->get('batchAction')) {
            $flashBag->add('error', 'black.bundle.config.error.config.admin.config.no.action');

            return new RedirectResponse($this->generateUrl('admin_config'));
        }

        if (!$ids = $request->get('ids')) {
            $flashBag->add('error', 'black.bundle.config.error.config.admin.config.no.item');

            return new RedirectResponse($this->generateUrl('admin_config'));
        }

        if (!method_exists($this, $method = $action . 'Action')) {
            throw new MethodNotAllowedHttpException(
                sprintf('You must create a "%s" method for action "%s"', $method, $action)
            );
        }

        foreach ($ids as $id) {
            $this->$method($id, $token);
        }

        return new RedirectResponse($this->generateUrl('admin_config'));
    }

    /**
     * @Method({"POST", "GET"})
     * @Route("/config/{id}/delete/{token}", name="admin_config_delete")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @param string $id The document ID
     * @param null $token
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function deleteAction($id, $token = null)
    {
        $form       = $this->createDeleteForm($id);

        $form->handleRequest($this->request);

        if (null !== $token) {
            $token = $this->csrf->isCsrfTokenValid('delete' . $id, $token);
        }

        if ($form->isValid() || true === $token) {

            $dm         = $this->configManager;
            $document   = $dm->findPropertyById($id);

            if (!$document) {
                throw new ConfigNotFoundException();
            }

            $dm->removeAndFlush($document);

            $this->session->getFlashbag()->add('success', 'black.bundle.config.success.config.admin.config.delete');

        }

        return new RedirectResponse($this->generateUrl('admin_config'));
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/{id}/edit", name="admin_config_edit")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @Template()
     *
     * @param string $id The document ID
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function editAction($id)
    {
        $document           = $this->configManager->findPropertyById($id);

        if (!$document) {
            throw new ConfigNotFoundException();
        }

        $process        = $this->handler->process($document);

        if ($process) {
            return $this->redirect($this->handler->getUrl());
        }

        return array(
            'document'      => $document,
            'form'          => $this->handler->getForm()->createView()
        );
    }

    /**
     * @Method("GET")
     * @Route("/index.html", name="admin_config")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $rawDocuments  = $this->configManager->findPropertiesBy(array('protected' => false));

        $documents = array();

        foreach ($rawDocuments as $document) {
            $documents[] = array(
                'id'    => $document->getId(),
                'Name'  => $document->getName()
            );
        }

        return array(
            'documents' => $documents,
            'csrf'      => $this->csrf
        );
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/new", name="admin_config_new")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @Template()
     *
     * @return array
     */
    public function newAction()
    {
        $document           = $this->configManager->createInstance();
        $process            = $this->handler->process($document);

        if ($process) {
            return $this->redirect($this->handler->getUrl());
        }

        return array(
            'document' => $document,
            'form'     => $this->handler->getForm()->createView()
        );
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    protected function createDeleteForm($id)
    {
        $form = $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();

        return $form;
    }

    /**
     * @param $url
     * @param $parameters
     */
    protected function generateUrl($url, $parameters)
    {
        $this->router->generate($url, $parameters);
    }
}
