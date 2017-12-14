<?php
namespace Dsheiko\SearchCriteria;

/**
 * Docs
 * @see http://devdocs.magento.com/guides/v2.1/howdoi/webapi/search-criteria.html
 *
 * Examples:
 * http://devdocs.magento.com/guides/v2.1/howdoi/webapi/filter-response.html
 */
class SortOrder extends AbstractBuilder
{
    const CLAUSE_TPL = "searchCriteria[sort_orders][{index}][{key}]={value}";
    const VALID_DIRECTIONS = [
        "DESC",
        "ASC",
        ];

    const MAGE_SC_FIELD = "field";
    const MAGE_SC_DIRECTION = "direction";

    private $index = 0;

    /**
     * Build a clause
     * @param string $key
     * @param string|int $value
     * @param int $index
     * @return string
     */
    private static function buildClause($key, $value, $index)
    {
        return strtr(static::CLAUSE_TPL, [
            "{index}" => $index,
            "{key}" => $key,
            "{value}" => $value,
        ]);
    }
    /**
     * Build a criteria
     * @param string $field
     * @param string $direction
     * @return array
     * @throws \InvalidArgumentException
     */
    public function build($field, $direction)
    {
        if (!in_array($direction, static::VALID_DIRECTIONS)) {
            throw new \InvalidArgumentException("Invalid Magento search direction `{$direction}`");
        }
        $queryArr = [];
        $queryArr[] = static::buildClause(static::MAGE_SC_FIELD, $field, $this->index);
        $queryArr[] = static::buildClause(static::MAGE_SC_DIRECTION, $direction, $this->index);
        $this->query = array_merge($this->query, $queryArr);
        $this->index++;
        return $queryArr;
    }
}
