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
 * Class GeneralConfigType
 *
 * @package Black\Bundle\ConfigBundle\Form\Type
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class GeneralConfigType extends AbstractType
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param string $class The Person class name
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
                            'label'         => 'config.admin.generalConfig.name.text'
                        )
                    )
                    ->add(
                        'site_name',
                        'text',
                        array(
                            'label'     => 'config.admin.generalConfig.site.name.text',
                            'required'  => true
                        )
                    )
                    ->add(
                        'site_baseline',
                        'text',
                        array(
                            'label'     => 'config.admin.generalConfig.site.baseline.text',
                            'required'  => false
                        )
                    )
                    ->add(
                        'site_url',
                        'url',
                        array(
                            'label'     => 'config.admin.generalConfig.site.url.text',
                            'required'  => true
                        )
                    )
                    ->add(
                        'site_footer',
                        'text',
                        array(
                            'label'     => 'config.admin.generalConfig.site.footer.text',
                            'required'  => false
                        )
                    )
                    ->add(
                        'picture',
                        'file',
                        array(
                            'label'     => 'config.admin.generalConfig.site.logo.text',
                            'required'  => false
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
                'intention'     => 'general_config_form'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_config_config_general';
    }
}
