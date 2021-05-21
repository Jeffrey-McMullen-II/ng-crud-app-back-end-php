<?php declare(strict_types = 1);

namespace App\Core\Pagination;

class PaginationResponse
{
    private int $totalRecords;
    
    private array $results;
    
    public function __construct(int $totalRecords, array $results)
    {
        $this->totalRecords = $totalRecords;
        $this->results = $results;
    }
    
    public function getTotalRecords(): int
    {
        return $this->totalRecords;
    }
    
    public function getResults(): array
    {
        return $this->results;
    }
}