<?php

namespace ShandyPatrol\CommandBus\Middleware;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * Middleware collection
 *
 * @package ShandyPatrol\CommandBus\Middleware
 */
class MiddlewareCollection implements ArrayAccess, Iterator, Countable
{

    protected $middleware = [];

    protected $position = 0;


    /**
     * Get the middleware in prioritised order.
     *
     * @return Middleware[]
     */
    public function getPrioritisedOrder()
    {
        // prioritisation logic
        return $this->middleware;
    }


    /**
     * Get the raw array.
     *
     * @return Middleware[]
     */
    public function toArray()
    {
        return $this->middleware;
    }


    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value) {

        if (is_null($offset)) {
            $this->middleware[] = $value;
        } else {
            $this->middleware[$offset] = $value;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset) {
        return isset($this->middleware[$offset]);
    }


    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset) {
        unset($this->middleware[$offset]);
    }


    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset) {
        return isset($this->middleware[$offset]) ? $this->middleware[$offset] : null;
    }


    /**
     * {@inheritdoc}
     */
    function rewind() {
        $this->position = 0;
    }


    /**
     * {@inheritdoc}
     */
    function current() {
        return $this->middleware[$this->position];
    }


    /**
     * {@inheritdoc}
     */
    function key() {
        return $this->position;
    }


    /**
     * {@inheritdoc}
     */
    function next() {
        ++$this->position;
    }


    /**
     * {@inheritdoc}
     */
    function valid() {
        return isset($this->middleware[$this->position]);
    }


    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->middleware);
    }
}