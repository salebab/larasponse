<?php namespace Sorskod\Larasponse\Adapters;


use Illuminate\Pagination\Paginator;
use League\Fractal\Pagination\PaginatorInterface;

class IlluminatePaginatorAdapter implements PaginatorInterface {


    /**
     * @var Paginator
     */
    private $paginator;

    public function __construct(Paginator $paginator)
    {

        $this->paginator = $paginator;
    }

    /**
     * @return integer
     */
    public function getCurrentPage()
    {
        return $this->paginator->currentPage();
    }

    /**
     * @return integer
     */
    public function getLastPage()
    {
        // NOTE: last page is not available in Paginator
        return 0;
    }

    /**
     * @return integer
     */
    public function getTotal()
    {
        // Note: total number is not available in Paginator
        return 0;
    }

    /**
     * @return integer
     */
    public function getCount()
    {
        return $this->paginator->count();
    }

    /**
     * @return integer
     */
    public function getPerPage()
    {
        return $this->paginator->perPage();
    }

    /**
     * @param integer $page
     *
     * @return string
     */
    public function getUrl($page)
    {
        return $this->paginator->url($page);
    }

    /**
     * @return Paginator
     */
    public function getPaginator()
    {
        return $this->paginator;
    }
}