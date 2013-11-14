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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Black\Bundle\ConfigBundle\Form\Type;
use Symfony\Component\Serializer\Exception;

/**
 * Class AdminConfigController
 *
 * @Route("/admin/config")
 *
 * @package Black\Bundle\ConfigBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class AdminConfigController extends Controller
{
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
        $dm = $this->getManager();

        $rawDocuments  = $dm->findPropertiesBy(array('protected' => false));
        $csrf       = $this->get('form.csrf_provider');

        $documents = array();

        foreach ($rawDocuments as $document) {
            $documents[] = array(
                'id'    => $document->getId(),
                'Name'  => $document->getName()
            );
        }

        return array(
            'documents' => $documents,
            'csrf'      => $csrf
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
        $documentManager    = $this->getManager();
        $document           = $documentManager->createInstance();

        $formHandler        = $this->get('black_config.config.form.main.handler');
        $process            = $formHandler->process($document);

        if ($process) {
            return $this->redirect($formHandler->getUrl());
        }

        return array(
            'document' => $document,
            'form'     => $formHandler->getForm()->createView()
        );


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
        $documentManager    = $this->getManager();
        $document           = $documentManager->findPropertyById($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Config document.');
        }

        $formHandler    = $this->get('black_config.config.form.main.handler');
        $process        = $formHandler->process($document);

        if ($process) {
            return $this->redirect($formHandler->getUrl());
        }

        return array(
            'document'      => $document,
            'form'          => $formHandler->getForm()->createView()
        );
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
        $request    = $this->getRequest();

        $form->bind($request);
        #  $form->submit($request);

        if (null !== $token) {
            $token = $this->get('form.csrf_provider')->isCsrfTokenValid('delete' . $id, $token);
        }

        if ($form->isValid() || true === $token) {

            $dm = $this->getManager();
            $document = $dm->findPropertyById($id);

            if (!$document) {
                throw $this->createNotFoundException('Unable to find Config document.');
            }

            $dm->removeAndFlush($document);

            $this->get('session')->getFlashbag()->add('success', 'black.bundle.config.success.config.admin.config.delete');

        }

        return $this->redirect($this->generateUrl('admin_config'));
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
        $request    = $this->getRequest();
        $token      = $this->get('form.csrf_provider')->isCsrfTokenValid('batch', $request->get('token'));

        if (!$ids = $request->get('ids')) {
            $this->get('session')->getFlashbag()->add('error', 'black.bundle.config.error.config.admin.config.no.item');
            return $this->redirect($this->generateUrl('admin_config'));
        }

        if (!$action = $request->get('batchAction')) {
            $this->get('session')->getFlashBag()->add('error', 'black.bundle.config.error.config.admin.config.no.action');
            return $this->redirect($this->generateUrl('admin_config'));
        }

        if (!method_exists($this, $method = $action . 'Action')) {
            throw new Exception\InvalidArgumentException(
                sprintf('You must create a "%s" method for action "%s"', $method, $action)
            );
        }

        if (false === $token) {
            $this->get('session')->getFlashBag()->add('error', 'black.bundle.config.error.config.admin.config.crsf');

            return $this->redirect($this->generateUrl('admin_config'));
        }

        foreach ($ids as $id) {
            $this->$method($id, $token);
        }

        return $this->redirect($this->generateUrl('admin_config'));

    }

    private function createDeleteForm($id)
    {
        $form = $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();

        return $form;
    }

    /**
     * @return DocumentManager
     */
    protected function getManager()
    {
        return $this->get('black_config.manager.config');
    }
}
