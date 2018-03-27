<?php

namespace App\Form;

use App\Entity\Posts;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Validator\Constraints\Length;

class PostType extends AbstractType {

  public function buildForm (FormBuilderInterface $builder, array $options) {
    $builder
      ->add('postsEmail', EmailType::class)
      ->add('postsMsg', TextareaType::class, array(
        'constraints' => array(
          new Length(array(
            'min' => 5, 'max' => 255
          ))
        )
      ));
  }

  public function configureOptions (OptionsResolver $resolver) {
    $resolver->setDefaults([
      'data-class' => Posts::class
    ]);
  }
}
