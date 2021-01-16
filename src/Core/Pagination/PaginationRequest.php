<?php

namespace App\Core\Pagination;

class PaginationRequest
{
    private int $pageNumber;
    
    private int $resultsPerPage;
    
    
    
    public function getPageNumber()
    {
        return $this->pageNumber;
    }
    
    public function setPageNumber(int $pageNumber)
    {
        $this->pageNumber = $pageNumber;
    }
    
    public function getResultsPerPage()
    {
        return $this->resultsPerPage;
    }
    
    public function setResultsPerPage(int $resultsPerPage)
    {
        $this->resultsPerPage = $resultsPerPage;
    }
    
    public function getLimit(int $totalRecords)
    {
        return (($this->pageNumber - 1) * ($this->getPageCount($totalRecords)));
    }
    
    public function getPageCount(int $totalRecords)
    {
        return $totalRecords / $this->resultsPerPage;
    }
}