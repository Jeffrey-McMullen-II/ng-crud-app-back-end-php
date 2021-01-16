<?php

namespace App\Core\Pagination;

class PaginationResponse
{
    private int $pageCount;
    
    private array $results;
    
    public function __construct($pageCount, $results)
    {
        $this->pageCount = $pageCount;
        $this->results = $results;
    }
    
    public function getPageCount()
    {
        return $this->pageCount;
    }
    
    public function getResults()
    {
        return $this->results;
    }
}