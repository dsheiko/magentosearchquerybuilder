<?php
namespace Dsheiko\SearchCriteria;

/**
 * For building custom criteria
 */
class Custom extends AbstractBuilder
{
    const CLAUSE_TPL = "searchCriteria[{key}]={value}";
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
     * @param int $key
     * @param int $val
     * @return array
     * @throws \InvalidArgumentException
     */
    public function build($key, $val)
    {
        $queryArr = [];
        $queryArr[] = static::buildClause($key, $val);
        $this->query = $queryArr;
        return $queryArr;
    }
}
