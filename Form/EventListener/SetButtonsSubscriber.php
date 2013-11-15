<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;


/**
 * Class SetButtonsSubscriber
 *
 * @package Black\Bundle\AdminBundle\EventListener
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class SetButtonsSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    /**
     * @param FormEvent $event
     */     
    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();

        $this->addCreateButtons($form);
    }

    /**
     * @param $form
     */
    private function addCreateButtons($form)
    {
        $form
            ->add('save', 'submit', array(
                    'label' => 'black.bundle.config.admin.eventListener.setButtonsSubscriber.button.save.label',
                    'attr' => array(
                        'class' => 'buttonL bBlue floatL mb10 mr10',

                    )
                )
            )
            ->add('reset', 'reset', array(
                    'label' => 'black.bundle.config.admin.eventListener.setButtonsSubscriber.button.reset.label',
                    'attr' => array(
                        'class' => 'buttonL bDefault floatL mb10 mr10',
                    )
                )
            );
    }
}
