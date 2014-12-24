<?php  namespace Sorskod\Larasponse;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface Larasponse
{

    /**
     * @param $includes
     */
    public function parseIncludes($includes);

    /**
     * @param mixed $data
     * @param \League\Fractal\TransformerAbstract|\Closure $transformer
     * @param string $resourceKey
     * @return array
     */
    public function item($data, $transformer = null, $resourceKey = null);

    /**
     * @param $data
     * @param \League\Fractal\TransformerAbstract|\Closure $transformer
     * @param string $resourceKey
     * @return array
     */
    public function collection($data, $transformer = null, $resourceKey = null);

    /**
     * @param LengthAwarePaginator $paginator
     * @param \League\Fractal\TransformerAbstract|\Closure $transformer
     * @param string $resourceKey
     * @return mixed
     */
    public function paginatedCollection(LengthAwarePaginator $paginator, $transformer = null, $resourceKey = null);
}