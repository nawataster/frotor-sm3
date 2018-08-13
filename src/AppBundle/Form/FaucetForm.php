<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType as FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Faucet;
// use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
// use Symfony\Component\Form\Extension\Core\Type\DateType;



class FaucetForm extends FormType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('url', TextType::class, ['attr' => ['class'=> 'form-control'], 'label' => 'Url' ] )
            ->add('info', TextType::class, ['attr' => ['class'=> 'form-control'], 'label' => 'Description' ] )
            ->add('priority', IntegerType::class, ['attr' => ['class'=> 'form-control'], 'label' => 'Priority' ] )


//             ->add('info', DateType::class, ['widget' => 'single_text',  'attr' => ['class'=> 'form-control'] ])
//             ->add('agreeTerms', CheckboxType::class, ['mapped' => false])
            ->add('save', SubmitType::class, ['attr' => ['class' => 'btn btn-default']])
            ;
    }

	public function configureOptions(OptionsResolver $resolver){
	    $resolver->setDefaults([
	        'data_class' => Faucet::class,
	    ]);
	}
}