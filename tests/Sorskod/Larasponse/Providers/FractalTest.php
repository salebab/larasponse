<?php namespace Sorskod\Larasponse\Providers;

use Illuminate\Pagination\Paginator;
use League\Fractal\Serializer\ArraySerializer;

class FractalTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Fractal
     */
    protected $fractal;

    public function setUp()
    {
        $serializer = new ArraySerializer();

        $this->fractal = new Fractal($serializer);
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


    public function testItem()
    {
        $result = $this->fractal->item($this->dummyDataObject()[0], function (\stdClass $data)
        {
            return [
                "key" => (int) $data->key
            ];
        });

        $this->assertSingle($result);
    }

    public function testCollection()
    {
        $result = $this->fractal->collection($this->dummyDataObject(10), function (\stdClass $data)
    {
        return [
            "key" => (int) $data->key
        ];
    });

        $this->assertArrayHasKey("data", $result);
        $this->assertCount(10, $result["data"]);

        foreach($result["data"] as $r) {
            $this->assertSingle($r);
        }
    }


    public function testPaginatedCollection()
    {
        $pagination = new Paginator($this->dummyDataObject(10), 5, 1);

        $result = $this->fractal->paginatedCollection($pagination);

        $this->assertArrayHasKey("data", $result);
    }


    public function assertSingle($result)
    {
        $this->assertArrayHasKey('key', $result);
        $this->assertTrue(is_int($result['key']));
        $this->assertEquals(123, $result['key']);
    }
}
 