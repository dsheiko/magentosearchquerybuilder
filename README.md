# Magento SearchCriteriaBuilder

[![Latest Stable Version](https://poser.pugx.org/dsheiko/magentosearchquerybuilder/v/stable)](https://packagist.org/packages/dsheiko/magentosearchquerybuilder)
[![Total Downloads](https://poser.pugx.org/dsheiko/magentosearchquerybuilder/downloads)](https://packagist.org/packages/dsheiko/magentosearchquerybuilder)
[![License](https://poser.pugx.org/dsheiko/magentosearchquerybuilder/license)](https://packagist.org/packages/dsheiko/magentosearchquerybuilder)
[![Build Status](https://travis-ci.org/dsheiko/magentosearchquerybuilder.png)](https://travis-ci.org/dsheiko/magentosearchquerybuilder)

Tool to build search criteria query for Magento REST Web API

- [Documentation](http://devdocs.magento.com/guides/v2.1/howdoi/webapi/search-criteria.html)
- [Examples](http://devdocs.magento.com/guides/v2.1/howdoi/webapi/filter-response.html)

## Installation

Require as a composer dependency:

``` bash
composer require "dsheiko/magentosearchquerybuilder"
```

## Building query
```php
<?php
use Dsheiko\SearchCriteria;
$builder = new SearchCriteria();
$builder
    ->filterGroup([
        [ "name", "%25Leggings%25", "like" ],
        [ "name", "%25Parachute%25", "like" ],
    ])
    ->filterGroup([
        [ "price", 30, "lt" ],
    ])
    ->sortOrder( "created_at", "DESC")
    ->limit(1, 10);

```

## Obtaining query string
```php
<?php
$builder->toString();
```
The result:
```
"searchCriteria[filter_groups][0][filters][0][field]=name"
  . "&searchCriteria[filter_groups][0][filters][0][value]=%25Leggings%25"
  . "&searchCriteria[filter_groups][0][filters][0][condition_type]=like"
  . "&searchCriteria[filter_groups][0][filters][1][field]=name"
  . "&searchCriteria[filter_groups][0][filters][1][value]=%25Parachute%25"
  . "&searchCriteria[filter_groups][0][filters][1][condition_type]=like"
  . "&searchCriteria[filter_groups][1][filters][1][field]=price"
  . "&searchCriteria[filter_groups][1][filters][1][value]=30"
  . "&searchCriteria[filter_groups][1][filters][1][condition_type]=lt"
  . "&searchCriteria[sort_orders][0][field]=created_at"
  . "&searchCriteria[sort_orders][0][direction]=DESC"
  . "&searchCriteria[current_page]=1"
  . "&searchCriteria[page_size]=10"
```

## Obtaining query array
```php
<?php
$builder->toArray();
```
