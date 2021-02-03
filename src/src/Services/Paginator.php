<?php

namespace App\Services;

use Doctrine\ORM\QueryBuilder;

class Paginator
{
    private int $maxPage;
    private int $page;
    private QueryBuilder $builder;
    private int $limit;
    private string $url;

    public function __construct(
        int $count, QueryBuilder $builder, int $page, int $limit = 10
    )
    {
        $this->url = '';
        $this->builder = $builder;
        $this->limit = $limit;
        $this->maxPage = (int)ceil($count / $this->limit);
        if ($page < 1) {
            $this->page = 1;
        } elseif ($page > $this->maxPage) {
            $this->page = $this->maxPage;
        } else {
            $this->page = $page;
        }
    }

    public function getPage(): array
    {
        $firstResult = $this->limit * ($this->page - 1) < 1 ? 0 : $this->limit * ($this->page - 1);
        return $this->builder->setFirstResult($firstResult)
            ->setMaxResults($this->limit)
            ->getQuery()
            ->getResult();
    }

    public function getPageNumber(): int
    {
        return $this->page;
    }

    public function getMaxPage(): int
    {
        return $this->maxPage;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getUrl(int $page): string
    {
        return $this->url . '?page=' . $page;
    }
}