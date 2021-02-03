<?php

namespace App\Form\Measures;

use App\Messages\MeasureErrors;
use App\Model\Measures\Edit;
use App\Repository\MeasureRepository;
use App\Validator\FindForUser\FindForUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class EditForm extends AbstractType
{
    private MeasureRepository $repository;
    private UserInterface $user;

    public function __construct(MeasureRepository $repository, TokenStorageInterface $tokenStorage)
    {
        $this->repository = $repository;
        $this->user = $tokenStorage->getToken()
            ->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            null,
            [
                'label' => 'Nazwa',
                'constraints' => [
                    new NotBlank(
                        ['message' => MeasureErrors::getError(MeasureErrors::NAME_MISSING)]
                    ),
                    new Type(
                        [
                            'type' => 'string',
                            'message' => MeasureErrors::getError(MeasureErrors::INVALID_VALUE)
                        ]
                    ),
                    new Length(
                        [
                            'max' => 30,
                            'maxMessage' => MeasureErrors::getError(MeasureErrors::NAME_TOO_LONG)
                        ]
                    ),
                    new FindForUser(
                        [
                            'user' => $this->user,
                            'repository' => $this->repository,
                            'columnName' => 'name',
                            'id' => $options['id'],
                            'message' => MeasureErrors::getError(MeasureErrors::NAME_IN_USE),
                            'empty' => true,
                            'numeric' => false
                        ]
                    )
                ]
            ]
        )
            ->add(
                'shortcut',
                null,
                [
                    'label' => 'Skrót',
                    'constraints' => [
                        new NotBlank(
                            ['message' => MeasureErrors::getError(MeasureErrors::SHORTCUT_MISSING)]
                        ),
                        new Type(
                            [
                                'type' => 'string',
                                'message' => MeasureErrors::getError(MeasureErrors::INVALID_VALUE)
                            ]
                        ),
                        new Length(
                            [
                                'max' => 10,
                                'maxMessage' => MeasureErrors::getError(
                                    MeasureErrors::SHORTCUT_TOO_LONG
                                )
                            ]
                        ),
                        new FindForUser(
                            [
                                'user' => $this->user,
                                'repository' => $this->repository,
                                'columnName' => 'shortcut',
                                'id' => $options['id'],
                                'message' => MeasureErrors::getError(
                                    MeasureErrors::SHORTCUT_IN_USE
                                ),
                                'empty' => true,
                                'numeric' => false
                            ]
                        )
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Edit::class,
                'id' => 0
            ]
        );
    }
}
