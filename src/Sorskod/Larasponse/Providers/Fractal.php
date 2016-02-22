<?php  namespace Sorskod\Larasponse\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Contracts\ArrayableInterface;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;
use Sorskod\Larasponse\Larasponse;

class Fractal implements Larasponse
{
    /**
     * @var \League\Fractal\Manager
     */
    protected $manager;


    public function __construct(SerializerAbstract $serializer)
    {
        $this->manager = new Manager();
        $this->manager->setSerializer($serializer);
    }

    public function parseIncludes($includes)
    {
        $this->manager->parseIncludes($includes);
    }

    public function collection($data, $transformer = null, $resourceKey = null)
    {
        $resource = new Collection($data, $this->getTransformer($transformer), $resourceKey);

        return $this->manager->createData($resource)->toArray();
    }


    public function item($data, $transformer = null, $resourceKey = null)
    {
        $resource = new Item($data, $this->getTransformer($transformer), $resourceKey);

        return $this->manager->createData($resource)->toArray();
    }


    public function paginatedCollection(Paginator $paginator, $transformer = null, $resourceKey = null)
    {
        $paginator->appends(\Request::query());

        $resource = new Collection($paginator->getCollection(), $this->getTransformer($transformer), $resourceKey);

        $paginatorAdapter = new IlluminatePaginatorAdapter($paginator);

        $queryParams = array_diff_key($_GET, array_flip(['page']));
        foreach ($queryParams as $key => $value) {
            $paginatorAdapter->addQuery($key, $value);
        }

        $resource->setPaginator($paginatorAdapter);

        return $this->manager->createData($resource)->toArray();
    }

    /**
     * @param TransformerAbstract $transformer
     * @return TransformerAbstract|callback
     */
    protected function getTransformer($transformer = null)
    {
        return $transformer ?: function($data) {

            if($data instanceof ArrayableInterface) {
                return $data->toArray();
            }

            return (array) $data;
        };
    }
}