<?php  namespace Sorskod\Larasponse;

use Illuminate\Pagination\Paginator;

interface Larasponse
{

    /**
     * @param array|string $includes Array or csv string of resources to include
     * @internal param $connection
     * @return mixed
     */
    public function parseIncludes($includes);

    /**
     * @param mixed $data
     * @param \League\Fractal\TransformerAbstract|callable $transformer
     * @param string $resourceKey
     * @return array
     */
    public function item($data, $transformer = null, $resourceKey = null);

    /**
     * @param $data
     * @param \League\Fractal\TransformerAbstract|callable $transformer
     * @param string $resourceKey
     * @return array
     */
    public function collection($data, $transformer = null, $resourceKey = null);

    /**
     * @param Paginator $paginator
     * @param \League\Fractal\TransformerAbstract|callable $transformer
     * @param string $resourceKey
     * @return mixed
     */
    public function paginatedCollection(Paginator $paginator, $transformer = null, $resourceKey = null);
}
