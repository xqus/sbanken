<?php
/**
 * Created by PhpStorm.
 * User: petterkjelkenes
 * Date: 25.01.2018
 * Time: 20:28
 */

namespace Pkj\Sbanken\Values;


/**
 * Class Collection
 *
 *
 * @package Pkj\Sbanken\Values
 */
class Collection implements \Iterator
{
    /**
     * @var int
     */
    private $availableItems;

    /**
     * @var array
     */
    private $items;

    private $index = 0;

    public function __construct(int $availableItems, array $items)
    {
        $this->availableItems = $availableItems;
        $this->items = $items;
    }

    public function getAvailableItems () : int
    {
        return $this->availableItems;
    }

    public function current()
    {
        return $this->items[$this->index];
    }

    public function next()
    {
        $this->index++;
    }

    public function key()
    {
        return $this->index;
    }

    public function valid()
    {
        return isset($this->items[$this->key()]);
    }

    public function rewind()
    {
        $this->index = 0;
    }


}