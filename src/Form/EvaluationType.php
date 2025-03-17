<?php

namespace App\Form;

use App\Entity\Evaluation;
use App\Enum\EvaluationStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Company;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => 'name', // Or another property of Company
                'label' => 'Company',
                'required' => true,
            ])
            ->add('evaluationDate', DateTimeType::class, [
                'label' => 'Evaluation Date',
                'widget' => 'single_text', // Or 'choice' if you prefer
                'required' => true,
                'data' => new \DateTimeImmutable(),
            ])
            ->add('overallScore', NumberType::class, [
                'label' => 'Overall Score',
                'required' => true,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Status',
                'required' => true,
                'choices' => array_combine(
                    array_map(fn(EvaluationStatus $status) => $status->value, EvaluationStatus::cases()),
                    array_map(fn(EvaluationStatus $status) => $status->value, EvaluationStatus::cases())
                ),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evaluation::class,
        ]);
    }
}
