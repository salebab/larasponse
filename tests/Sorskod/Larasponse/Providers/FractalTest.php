<?php namespace Sorskod\Larasponse\Providers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use League\Fractal\Serializer\ArraySerializer;

class FractalTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Fractal
     */
    protected $fractal;
    /**
     * @var Request
     */
    protected $request;

    public function setUp()
    {
        $serializer = new ArraySerializer();
        $this->request = new Request();

        $this->fractal = new Fractal($serializer, $this->request);
    }

    public function dummyDataObject($take = 1)
    {
        $data = [];
        for($i = 0; $i < $take; $i++) {
            $object = new \stdClass();
            $object->key = "123";
            $data[] = $object;
        }

        return $data;
    }

    public function transformer(\stdClass $data)
    {
        return [
            "key" => (int) $data->key
        ];
    }

    public function testItem()
    {
        $result = $this->fractal->item($this->dummyDataObject()[0], [$this, "transformer"]);

        $this->assertSingle($result);
    }

    public function testCollection()
    {
        $result = $this->fractal->collection($this->dummyDataObject(10), [$this, "transformer"]);


        $this->assertArrayHasKey("data", $result);
        $this->assertCount(10, $result["data"]);

        foreach($result["data"] as $r) {
            $this->assertSingle($r);
        }
    }


    public function testPaginatedCollection()
    {
        $pagination = new LengthAwarePaginator($this->dummyDataObject(10), 100, 10, 2);

        $this->request->query->add([
            "sort" => "asc",
        ]);

        $result = $this->fractal->paginatedCollection($pagination, [$this, "transformer"]);

        $this->assertArrayHasKey("data", $result);
        $this->assertArrayHasKey("meta", $result);
        $this->assertCount(10, $result['data']);
        $this->assertEquals(10, $result['meta']['pagination']['count']);
        $this->assertEquals(100, $result['meta']['pagination']['total']);
        $this->assertContains("sort=asc", $result['meta']['pagination']['links']['next']);
    }

    public function assertSingle($result)
    {
        $this->assertArrayHasKey('key', $result);
        $this->assertTrue(is_int($result['key']));
        $this->assertEquals(123, $result['key']);
    }
}
 