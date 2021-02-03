<?php

namespace App\Services\Lists;

use App\Entity\Product\ProductsList;
use App\Entity\User;
use App\Field\MaterialSelect;
use App\Form\ShoppingForm;
use App\Messages\ShoppingErrors;
use App\Model\Shopping;
use App\Repository\MeasureRepository;
use App\Repository\Product\ListRepository;
use App\Services\Collection\MeasureCollection;
use App\Services\PositionFactory\PositionFactory;
use App\Services\Presentation\ListPositionPresentation;
use App\Transformer\MeasureTransformer;
use App\Validator\BelongsToUser\BelongsToUser;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ListCreator
{
    private ListRepository $listRepository;
    private MeasureRepository $measureRepository;
    private PositionFactory $factory;
    private ProductsList $list;
    private FormInterface $form;
    private User $user;

    public function __construct(
        ListRepository $listRepository, MeasureRepository $measureRepository,
        PositionFactory $factory, FormFactoryInterface $formFactory,
        TokenStorageInterface $tokenStorage
    )
    {
        $this->listRepository = $listRepository;
        $this->measureRepository = $measureRepository;
        $this->factory = $factory;
        $this->user = $tokenStorage->getToken()
            ->getUser();
        $this->form = $formFactory->create(ShoppingForm::class);
    }

    public function findList(int $id): bool
    {
        $this->list = $this->listRepository->findById($id, $this->user);
        return $this->list !== null;
    }

    public function setForm(): void
    {
        $data = ['positions' => []];
        foreach ($this->list->getPositions() as $position) {
            $data['positions'][] = new Shopping(
                ListPositionPresentation::fromEntity($position), $this->factory
            );
        }

        $this->form->setData($data);
        /** @var Form $position */
        foreach ($this->form->get('positions') as $position) {
            $measure = $position->getViewData()['measure'];
            $position->remove('measure');
            $default = $measure->getId();
            $items = MeasureCollection::fromEntity($measure);
            $position->add(
                'measure',
                MaterialSelect::class,
                $this->getMeasureOptions($items, $default)
            );
        }
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }

    private function getMeasureOptions(array $items = [], int $default = 0): array
    {
        return [
            'error_bubbling' => true,
            'label' => 'Jednostka',
            'transformer' => new MeasureTransformer($this->measureRepository),
            'constraints' => [
                new NotBlank(
                    ['message' => ShoppingErrors::getError(ShoppingErrors::MEASURE_MISSING)]
                ),
                new BelongsToUser(['user' => $this->user]),
            ],
            'default' => $default,
            'items' => $items
        ];
    }
}