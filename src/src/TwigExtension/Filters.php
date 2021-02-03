<?php

namespace App\TwigExtension;

use App\Entity\ListInterface;
use App\Entity\Product\Position;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Filters extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('checkButton', [new self(),'checkButton']),
            new TwigFilter('checkIcon', [new self(),'checkIcon']),
            new TwigFilter('checkInput', [new self(),'checkInput']),
            new TwigFilter('checkPosition', [new self(),'checkPosition']),
            new TwigFilter('printProgress', [new self(), 'printProgress']),
            new TwigFilter('typeIcon', [new self(), 'typeIcon']),
        ];
    }

    public function checkButton($value):string
    {
        return $value ? 'btn-danger' : 'btn-success';
    }

    public function checkIcon($value):string
    {
        return $value ? 'uncheck-icon' : 'check-icon';
    }
    public function checkInput(int $value, bool $checked=false):string
    {
        if(!$checked){
            return '';
        }
        return $value>0 ? 'is-invalid' : 'is-valid';
    }

    public function checkPosition($value):string
    {
        return $value ? 'checked-element' : '';
    }

    public function printProgress(ListInterface $list, bool $empty=false):string
    {
        $checkedCount=$list->getChecked()->count();
        if($empty && $checkedCount===0){
            return sprintf('%u/%u',$checkedCount,$list->getPositions()->count());
        }
        if(!$empty && $checkedCount!==0){
            return sprintf('%u/%u',$checkedCount,$list->getPositions()->count());
        }
        return '';
    }

    public function typeIcon(Position $position):string
    {
        return $position->getProduct() === null ? 'stuff-icon' : 'products-icon';
    }
}