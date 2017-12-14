<?php
namespace Dsheiko;

use Dsheiko\SearchCriteria\AbstractBuilder;
use Dsheiko\SearchCriteria\FilterGroup;
use Dsheiko\SearchCriteria\SortOrder;
use Dsheiko\SearchCriteria\Limit;
use Dsheiko\SearchCriteria\Custom;

class SearchCriteria extends AbstractBuilder
{
    const OP_EQ = "eq"; // Equals
    const OP_FINSET = "finset"; // A value within a set of values
    const OP_FROM = "from"; //  he beginning of a range. Must be used with to
    const OP_GT = "gt"; //Greater than
    const OP_GTEQ = "gteq"; // Greater than or equal
    const OP_IN = "in"; // In. The value can contain a comma-separated list of values.
    const OP_LIKE = "like"; // Like. The value can contain the SQL wildcard characters when like is specified.
    const OP_LT = "lt"; // Less than
    const OP_LTEQ = "lteq"; // Less than or equal
    const OP_MOREQ = "moreq"; // More or equal
    const OP_NEQ = "neq"; // Not equal
    const OP_NIN = "nin"; // Not in. The value can contain a comma-separated list of values.
    const OP_NOTNULL = "notnull"; // Not null
    const OP_NULL = "null"; // Null
    const OP_TO = "to"; // The end of a range. Must be used with from
    /**
     *
     * @var int
     */
    private $filterGroupIndex = 0;
    /**
     * @var array
     */
    private $filterGroups = [];
    /**
     * @var SortOrder
     */
    private $sortOrderBuilder;
    /**
     *
     * @var Limit
     */
    private $limitBuilder;
    /**
     *
     * @var Custom
     */
    private $customBuilder;

    public function __construct()
    {
        $this->sortOrderBuilder = new SortOrder();
        $this->limitBuilder = new Limit();
        $this->customBuilder = new Custom();
    }
    /**
     * Append FilterGroup results
     * @param array $options - like [[$field, $value, $operator], ..]
     * @param string $field
     * @param string|int $value
     * @param string $operator
     * @return self
     */
    public function filterGroup(array $options)
    {
        $builder = new FilterGroup($this->filterGroupIndex++);
        array_walk($options, function ($params) use (&$builder) {
            list($field, $value, $operator) = $params;
            if (!isset($field) || !isset($value) || !isset($operator)) {
                throw new \InvalidArgumentException("Invalid Magento filter group. "
                    . "Shall be [[field, value, operator], ..], given " . json_encode([$params]));
            }
            $builder->build($field, $value, $operator);
        });
        $this->filterGroups = array_merge($this->filterGroups, $builder->toArray());
        return $this;
    }
    /**
     * Append SortOrder results
     * @param string $field
     * @param string $direction
     * @return self
     */
    public function sortOrder($field, $direction)
    {
        $this->sortOrderBuilder->build($field, $direction);
        return $this;
    }

    /**
     * Append SortOrder results
     * @param string $page
     * @param string $size
     * @return self
     */
    public function limit($page, $size)
    {
        $this->limitBuilder->build($page, $size);
        return $this;
    }

    /**
     * Append Custom
     * @param string $key
     * @param string $val
     * @return self
     */
    public function custom($key, $val)
    {
        $this->customBuilder->build($key, $val);
        return $this;
    }


    /**
     * Access the builder query
     * @return array
     */
    protected function getQuery()
    {
        return array_merge(
            $this->filterGroups,
            $this->sortOrderBuilder->toArray(),
            $this->limitBuilder->toArray()
        );
    }
}
