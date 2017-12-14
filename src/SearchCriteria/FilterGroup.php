<?php
namespace Dsheiko\SearchCriteria;

/**
 * Docs
 * @see http://devdocs.magento.com/guides/v2.1/howdoi/webapi/search-criteria.html
 *
 * Examples:
 * http://devdocs.magento.com/guides/v2.1/howdoi/webapi/filter-response.html
 */
class FilterGroup extends AbstractBuilder
{
    const CLAUSE_TPL = "searchCriteria[filter_groups][{group}][filters][{index}][{key}]={value}";
    const VALID_OPERATORS = [
        "eq",
        "finset",
        "from",
        "gt",
        "gteq",
        "in",
        "like",
        "lt",
        "lteq",
        "moreq",
        "neq",
        "nin",
        "notnull",
        "null",
        "to"
        ];

    const MAGE_SC_FIELD = "field";
    const MAGE_SC_VALUE = "value";
    const MAGE_SC_CT = "condition_type";

    private $index = 0;
    private $groupIndex = 0;

    /**
     *
     * @param int $groupIndex
     */
    public function __construct($groupIndex = 0)
    {
        $this->groupIndex = $groupIndex;
    }
    /**
     * Build a clause
     * @param string $key
     * @param string|int $value
     * @param int $index
     * @param int $groupIndex
     * @return string
     */
    private static function buildClause($key, $value, $index, $groupIndex)
    {
        return strtr(static::CLAUSE_TPL, [
            "{index}" => $index,
            "{key}" => $key,
            "{value}" => $value,
            "{group}" => $groupIndex,
        ]);
    }
    /**
     * Build a criteria
     * @param string $field
     * @param string|int $value
     * @param string $operator
     * @return array
     * @throws \InvalidArgumentException
     */
    public function build($field, $value, $operator)
    {
        if (!in_array($operator, static::VALID_OPERATORS)) {
            throw new \InvalidArgumentException("Invalid Magento search operator `{$operator}`");
        }
        $queryArr = [];
        $queryArr[] = static::buildClause(static::MAGE_SC_FIELD, $field, $this->index, $this->groupIndex);
        $queryArr[] = static::buildClause(static::MAGE_SC_VALUE, $value, $this->index, $this->groupIndex);
        $queryArr[] = static::buildClause(static::MAGE_SC_CT, $operator, $this->index, $this->groupIndex);
        $this->query = array_merge($this->query, $queryArr);
        $this->index++;
        return $queryArr;
    }
}
