<?php
namespace Dsheiko\SearchCriteria;

/**
 * Docs
 * @see http://devdocs.magento.com/guides/v2.1/howdoi/webapi/search-criteria.html
 *
 * Examples:
 * http://devdocs.magento.com/guides/v2.1/howdoi/webapi/filter-response.html
 */
class Limit extends AbstractBuilder
{
    const CLAUSE_TPL = "searchCriteria[{key}]={value}";
    const MAGE_SC_KEY = "current_page";
    const MAGE_SC_VAL = "page_size";

    /**
     * Build a clause
     * @param string $key
     * @param string|int $value
     * @return string
     */
    private static function buildClause($key, $value)
    {
        return strtr(static::CLAUSE_TPL, [
            "{key}" => $key,
            "{value}" => $value,
        ]);
    }
    /**
     * Build a criteria
     * @param int $page
     * @param int $size
     * @return array
     * @throws \InvalidArgumentException
     */
    public function build($page, $size)
    {
        $queryArr = [];
        $queryArr[] = static::buildClause(static::MAGE_SC_KEY, $page);
        $queryArr[] = static::buildClause(static::MAGE_SC_VAL, $size);
        $this->query = $queryArr;
        return $queryArr;
    }
}
