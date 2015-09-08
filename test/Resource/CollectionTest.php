<?php namespace League\Fractal\Test;

use League\Fractal\Pagination\Cursor;
use League\Fractal\Resource\Collection;
use Mockery;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    protected $simpleCollection = array(
        array('foo' => 'bar'),
        array('baz' => 'ban'),
    );

    public function testGetData()
    {
        $resource = new Collection($this->simpleCollection, function (array $data) {
            return $data;
        });

        $this->assertSame($resource->getData(), $this->simpleCollection);
    }

    /**
     * @covers League\Fractal\Resource\Collection::setData
     */
    public function testSetData()
    {
        $collection = Mockery::mock('League\Fractal\Resource\Collection')->makePartial();
        $collection->setData('foo');
        $this->assertSame('foo', $collection->getData());
    }

    public function testGetTransformer()
    {
        $resource = new Collection($this->simpleCollection, function () {
        });
        $this->assertTrue(is_callable($resource->getTransformer()));

        $resource = new Collection($this->simpleCollection, 'SomeClass');
        $this->assertSame($resource->getTransformer(), 'SomeClass');
    }

    /**
     * @covers League\Fractal\Resource\Collection::setTransformer
     */
    public function testSetTransformer()
    {
        $collection = Mockery::mock('League\Fractal\Resource\Collection')->makePartial();
        $collection->setTransformer('foo');
        $this->assertSame('foo', $collection->getTransformer());
    }

    /**
     * @covers League\Fractal\Resource\Collection::setCursor
     */
    public function testSetCursor()
    {
        $cursor = Mockery::mock('League\Fractal\Pagination\Cursor');
        $collection = Mockery::mock('League\Fractal\Resource\Collection')->makePartial();
        $this->assertInstanceOf('League\Fractal\Resource\Collection', $collection->setCursor($cursor));
    }

    /**
     * @covers League\Fractal\Resource\Collection::getCursor
     */
    public function testGetCursor()
    {
        $cursor = new Cursor();
        $collection = Mockery::mock('League\Fractal\Resource\Collection')->makePartial();
        $collection->setCursor($cursor);
        $this->assertInstanceOf('League\Fractal\Pagination\Cursor', $collection->getCursor());
    }

    /**
     * @covers League\Fractal\Resource\Collection::setPaginator
     * @covers League\Fractal\Resource\Collection::getPaginator
     */
    public function testGetSetPaginator()
    {
        $paginator = Mockery::mock('League\Fractal\Pagination\IlluminatePaginatorAdapter');
        $collection = Mockery::mock('League\Fractal\Resource\Collection')->makePartial();
        $this->assertInstanceOf('League\Fractal\Resource\Collection', $collection->setPaginator($paginator));
        $this->assertInstanceOf('League\Fractal\Pagination\PaginatorInterface', $collection->getPaginator());
    }

    /**
     * @covers League\Fractal\Resource\Collection::setMetaValue
     * @covers League\Fractal\Resource\Collection::getMetaValue
     */
    public function testGetSetMeta()
    {
        $collection = Mockery::mock('League\Fractal\Resource\Collection')->makePartial();
        $this->assertInstanceOf('League\Fractal\Resource\Collection', $collection->setMetaValue('foo', 'bar'));
        $this->assertSame(array('foo' => 'bar'), $collection->getMeta());
        $this->assertSame('bar', $collection->getMetaValue('foo'));
        $collection->setMeta(array('baz' => 'bat'));
        $this->assertSame(array('baz' => 'bat'), $collection->getMeta());
    }

    /**
     * @covers League\Fractal\Resource\Collection::setResourceKey
     */
    public function testSetResourceKey()
    {
        $collection = Mockery::mock('League\Fractal\Resource\Collection')->makePartial();
        $this->assertInstanceOf('League\Fractal\Resource\Collection', $collection->setResourceKey('foo'));
    }

    /**
     * @covers League\Fractal\Resource\Collection::getResourceKey
     */
    public function testGetResourceKey()
    {
        $collection = Mockery::mock('League\Fractal\Resource\Collection')->makePartial();
        $collection->setResourceKey('foo');
        $this->assertSame('foo', $collection->getResourceKey());
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
