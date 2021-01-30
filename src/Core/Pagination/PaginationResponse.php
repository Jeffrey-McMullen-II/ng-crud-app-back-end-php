<?php

namespace App\Core\Pagination;

class PaginationResponse
{
    private int $totalRecords;
    
    private array $results;
    
    public function __construct($totalRecords, $results)
    {
        $this->totalRecords = $totalRecords;
        $this->results = $results;
    }
    
    public function getTotalRecords()
    {
        return $this->totalRecords;
    }
    
    public function getResults()
    {
        return $this->results;
    }
}