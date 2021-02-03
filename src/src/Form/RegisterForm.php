<?php

namespace App\Form;

use App\Messages\RegisterErrors;
use App\Model\UserModel;
use App\Repository\UserRepository;
use App\Validator\Unique\Unique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class RegisterForm extends AbstractType
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'email',
            null,
            [
                'constraints' => [
                    new NotBlank(
                        ['message' => RegisterErrors::getError(RegisterErrors::EMPTY_EMAIL)]
                    ),
                    new Email(
                        [
                            'message' => RegisterErrors::getError(
                                RegisterErrors::INVALID_EMAIL_FORMAT
                            )
                        ]
                    ),
                    new Unique(
                        [
                            'column' => 'email',
                            'repository' => $this->repository,
                            'message' => RegisterErrors::getError(RegisterErrors::EMAIL_IN_USE)
                        ]
                    )
                ]
            ]
        )
            ->add(
                'password',
                RepeatedType::class,
                [
                    'empty_data' => '',
                    'constraints' => [
                        new NotBlank(
                            ['message' => RegisterErrors::getError(RegisterErrors::EMPTY_PASSWORD)]
                        ),
                        new Type(
                            [
                                'type' => 'string',
                                'message' => RegisterErrors::getError(RegisterErrors::INVALID_VALUE)
                            ]
                        ),
                    ],
                    'invalid_message' => RegisterErrors::getError(
                        RegisterErrors::DIFFERENT_PASSWORDS
                    ),
                    'options' => [
                        'error_bubbling' => true
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => UserModel::class
            ]
        );
    }
}
