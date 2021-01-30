<?php

namespace App\Core\Pagination;

class PaginationRequest
{
    private int $first;
    
    private int $rows;
    
    public function getFirst()
    {
        return $this->first;
    }
    
    public function setFirst(int $first)
    {
        $this->first = $first;
    }
    
    public function getRows()
    {
        return $this->rows;
    }
    
    public function setRows(int $rows)
    {
        $this->rows = $rows;
    }
}