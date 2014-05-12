<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Form\Type;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ConfigType
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ConfigType extends AbstractType
{
    /**
     * @var type
     */
    protected $class;

    /**
     * @var \Symfony\Component\EventDispatcher\EventSubscriberInterface
     */
    protected $buttonSubscriber;

    /**
     * @param                          $class
     * @param EventSubscriberInterface $buttonSubscriber
     */
    public function __construct($class, EventSubscriberInterface $buttonSubscriber)
    {
        $this->class            = $class;
        $this->buttonSubscriber = $buttonSubscriber;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber($this->buttonSubscriber);

        $builder
            ->add('name', 'text', [
                    'label' => 'black.bundle.config.admin.config.name.label'
                ]
            )
            ->add('value', 'textarea', [
                    'label' => 'black.bundle.config.admin.config.value.label'
                ]
            )
            ->add('protected', 'checkbox', [
                    'required' => false,
                    'label' => 'black.bundle.config.admin.config.protected.label'
                ]
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => $this->class,
                'intention' => 'config_form',
                'translation_domain' => 'form',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_config_config';
    }
}
