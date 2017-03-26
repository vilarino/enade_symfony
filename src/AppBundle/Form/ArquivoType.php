<?php

namespace AppBundle\Form;

use AppBundle\Entity\Exame;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArquivoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tipo', EntityType::class, array(
            'class' => 'AppBundle\Entity\Tipo',
            'choice_label' => 'descricao',
            'required' => true
        ))->add('arquivoVich', FileType::class, array(
            'label' => 'Planiha',
            'required' => true
        ));

        $builder->add('save', SubmitType::class, array(
            'label' => 'Salvar'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Arquivo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_arquivo';
    }


}
