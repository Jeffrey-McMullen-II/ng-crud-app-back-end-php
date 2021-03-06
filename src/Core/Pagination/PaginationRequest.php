<?php declare(strict_types = 1);

namespace App\Core\Pagination;

class PaginationRequest
{
    private int $first;
    
    private int $rows;
    
    public function getFirst(): int
    {
        return $this->first;
    }
    
    public function setFirst(int $first)
    {
        $this->first = $first;
    }
    
    public function getRows(): int
    {
        return $this->rows;
    }
    
    public function setRows(int $rows)
    {
        $this->rows = $rows;
    }
}