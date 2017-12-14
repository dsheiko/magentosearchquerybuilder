<?php
namespace Dsheiko\SearchCriteria;

abstract class AbstractBuilder
{
    /**
     * Query array
     * @var array
     */
    protected $query = [];
    /**
     * Access the builder query
     * @return array
     */
    protected function getQuery()
    {
        return $this->query;
    }
    /**
     * Get as array of string
     * @return array
     */
    public function toArray()
    {
        return $this->getQuery();
    }
    /**
     * Get as query string
     * @return string
     */
    public function toString()
    {
        return implode("&", $this->getQuery());
    }
}
