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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class MailConfigType
 *
 * @package Black\Bundle\ConfigBundle\Form\Type
 */
class MailConfigType extends AbstractType
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('name')
            ->add(
                $builder
                    ->create(
                        'value',
                        'form',
                        array(
                            'by_reference'  => false,
                            'label'         => 'config.admin.mailConfig.name.text'
                        )
                    )
                    ->add(
                        'mail_root',
                        'text',
                        array(
                            'label' => 'config.admin.mailConfig.mail.root.text'
                        )
                    )
                    ->add(
                        'mail_noreply',
                        'text',
                        array(
                            'label' => 'config.admin.mailConfig.mail.noreply.text'
                        )
                    )
                    ->add(
                        'mail_register_header',
                        'text',
                        array(
                            'label' => 'config.admin.mailConfig.mail.register.subject.text'
                        )
                    )
                    ->add(
                        'mail_register_text',
                        'textarea',
                        array(
                            'label' => 'config.admin.mailConfig.mail.register.message.text'
                        )
                    )
                    ->add(
                        'mail_suspend_header',
                        'text',
                        array(
                            'label' => 'config.admin.mailConfig.mail.suspend.subject.text'
                        )
                    )
                    ->add(
                        'mail_suspend_text',
                        'textarea',
                        array(
                            'label' => 'config.admin.mailConfig.mail.suspend.message.text'
                        )
                    )
                    ->add(
                        'mail_lost_header',
                        'text',
                        array(
                            'label' => 'config.admin.mailConfig.mail.lost.subject.text'
                        )
                    )
                    ->add(
                        'mail_lost_text',
                        'textarea',
                        array(
                            'label' => 'config.admin.mailConfig.mail.lost.message.text'
                        )
                    )
                    ->add(
                        'mail_back_header',
                        'text',
                        array(
                            'label' => 'config.admin.mailConfig.mail.back.subject.text'
                        )
                    )
                    ->add(
                        'mail_back_text',
                        'textarea',
                        array(
                            'label' => 'config.admin.mailConfig.mail.back.message.text'
                        )
                    )
                    ->add(
                        'mail_byebye_header',
                        'text',
                        array(
                            'label' => 'config.admin.mailConfig.mail.byebye.subject.text'
                        )
                    )
                    ->add(
                        'mail_byebye_text',
                        'textarea',
                        array(
                            'label' => 'config.admin.mailConfig.mail.byebye.message.text'
                        )
                    )
                    ->add(
                        'mail_contact_header',
                        'text',
                        array(
                            'label' => 'config.admin.mailConfig.mail.contact.subject.text'
                        )
                    )
                    ->add(
                        'mail_contact_text',
                        'textarea',
                        array(
                            'label' => 'config.admin.mailConfig.mail.contact.message.text'
                        )
                    )
                    ->add(
                        'mail_contact_reply_header',
                        'text',
                        array(
                            'label' => 'config.admin.mailConfig.mail.reply.subject.text'
                        )
                    )
                    ->add(
                        'mail_contact_reply_text',
                        'textarea',
                        array(
                            'label' => 'config.admin.mailConfig.mail.reply.message.text'
                        )
                    )
                    ->add(
                        'mail_footer_note',
                        'textarea',
                        array(
                            'label' => 'config.admin.mailConfig.mail.footer.text'
                        )
                    )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'    => $this->class,
                'intention'     => 'mail_config_form'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_config_config_mail';
    }
}
