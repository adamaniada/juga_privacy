<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\QuestionCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextareaType::class, [
                'label' => 'Question Text',
                'attr' => ['rows' => 3],
                'required' => true,
            ])
            ->add('category', EnumType::class, [
                'class' => QuestionCategory::class,
                'choice_label' => 'value',
                'label' => 'Category',
                'required' => true,
            ])
            ->add('weight', IntegerType::class, [
                'label' => 'Weight',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}