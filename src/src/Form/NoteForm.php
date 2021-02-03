<?php

namespace App\Form;

use App\Messages\NoteErrors;
use App\Model\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class NoteForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'content',
            TextareaType::class,
            [
                'label' => 'Treść',
                'constraints' => [
                    new NotBlank(['message' => NoteErrors::getError(NoteErrors::CONTENT_MISSING)]),
                    new Type(
                        [
                            'type' => 'string',
                            'message' => NoteErrors::getError(NoteErrors::INVALID_VALUE)
                        ]
                    )
                ]
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Note::class]);
    }
}
