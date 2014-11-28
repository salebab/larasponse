<?php  namespace Sorskod\Larasponse\Providers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;
use Sorskod\Larasponse\Adapters\IlluminatePaginatorAdapter;
use Sorskod\Larasponse\Larasponse;

class Fractal implements Larasponse
{
    /**
     * @var \League\Fractal\Manager
     */
    protected $manager;
    /**
     * @var Request
     */
    private $request;


    public function __construct(SerializerAbstract $serializer, Request $request)
    {
        $this->manager = new Manager();
        $this->manager->setSerializer($serializer);
        $this->request = $request;
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


    public function paginatedCollection(LengthAwarePaginator $paginator, $transformer = null, $resourceKey = null)
    {
        $paginator->appends($this->request->query());

        $resource = new Collection($paginator->items(), $this->getTransformer($transformer), $resourceKey);

        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->manager->createData($resource)->toArray();
    }

    /**
     * @param TransformerAbstract $transformer
     * @return TransformerAbstract|callback
     */
    protected function getTransformer($transformer = null)
    {
        return $transformer ?: function($data) {

            if($data instanceof Arrayable) {
                return $data->toArray();
            }

            return (array) $data;
        };
    }
}