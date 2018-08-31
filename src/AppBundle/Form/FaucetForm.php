<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType as FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Faucet;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class FaucetForm extends FormType{

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('url', TextType::class, ['attr' => ['class'=> 'form-control'], 'label' => 'Url' ] )
			->add('info', TextType::class, ['attr' => ['class'=> 'form-control'], 'label' => 'Description', 'required' => false ] )
			->add('priority', IntegerType::class, ['attr' => ['class'=> 'form-control'], 'label' => 'Priority' ] )
			->add('duration', IntegerType::class, ['attr' => ['class'=> 'form-control'], 'label' => 'Duration (мин)' ] )
			->add('bandays', IntegerType::class, ['attr' => ['class'=> 'form-control'], 'label' => 'Days to ban' ] )
			->add('is_tab', CheckboxType::class, ['attr' => ['class'=> 'form-control'], 'label' => 'New window', 'required' => false ] )

			->add('save', SubmitType::class, ['attr' => ['class' => 'btn btn-default glyphicon glyphicon-floppy-save', 'title' => 'Save'], 'label' => false])
			->add('btn_home', ButtonType::class, ['attr' => ['class'=> 'btn btn-default glyphicon glyphicon-home', 'title' => 'Return to home page'], 'label' => false ] )
			->add('btn_add',   ButtonType::class, ['attr' => ['class'=> 'btn btn-default glyphicon glyphicon-plus-sign', 'title' => 'Add faucet'], 'label' => false ] )
			->add('btn_del',   ButtonType::class, ['attr' => ['class'=> 'btn btn-default glyphicon glyphicon-trash', 'title' => 'Delete faucet'], 'label' => false ] )
			;
	}
//______________________________________________________________________________

	public function configureOptions(OptionsResolver $resolver){
		$resolver->setDefaults([
			'data_class' => Faucet::class,
		]);
	}
//______________________________________________________________________________

}// Class end