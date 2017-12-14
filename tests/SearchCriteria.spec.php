<?php
namespace tests\unit\Dsheiko\SearchCriteria;

use Dsheiko\SearchCriteria;

/**
 * Assertions http://peridot-php.github.io/leo/expect.html
 */
describe("Dsheiko\SearchCriteria", function() {
    describe("->toString", function() {
        it("generates query string", function() {
            $builder = new SearchCriteria();
            $res = $builder
                    ->filterGroup([
                        [ "name", "%25Leggings%25", "like" ],
                        [ "name", "%25Parachute%25", "like" ],
                    ])
                    ->filterGroup([
                        [ "sku", "WSH%2531%25", "like" ],
                        [ "price", 30, "lt" ],
                    ])
                    ->sortOrder( "created_at", "DESC")
                    ->limit(1, 10)
                    ->toString();

            expect($res)->to->equal("searchCriteria[filter_groups][0][filters][0][field]=name"
                . "&searchCriteria[filter_groups][0][filters][0][value]=%25Leggings%25"
                . "&searchCriteria[filter_groups][0][filters][0][condition_type]=like"
                . "&searchCriteria[filter_groups][0][filters][1][field]=name"
                . "&searchCriteria[filter_groups][0][filters][1][value]=%25Parachute%25"
                . "&searchCriteria[filter_groups][0][filters][1][condition_type]=like"
                . "&searchCriteria[filter_groups][1][filters][0][field]=sku"
                . "&searchCriteria[filter_groups][1][filters][0][value]=WSH%2531%25"
                . "&searchCriteria[filter_groups][1][filters][0][condition_type]=like"
                . "&searchCriteria[filter_groups][1][filters][1][field]=price"
                . "&searchCriteria[filter_groups][1][filters][1][value]=30"
                . "&searchCriteria[filter_groups][1][filters][1][condition_type]=lt"
                . "&searchCriteria[sort_orders][0][field]=created_at"
                . "&searchCriteria[sort_orders][0][direction]=DESC"
                . "&searchCriteria[current_page]=1"
                . "&searchCriteria[page_size]=10");
        });
    });
    describe("->toArray", function() {
        it("generates an array of strings", function() {
            $builder = new SearchCriteria();
            $res = $builder
                    ->filterGroup([
                        [ "name", "%25Leggings%25", "like" ],
                        [ "name", "%25Parachute%25", "like" ],
                    ])
                    ->filterGroup([
                        [ "sku", "WSH%2531%25", "like" ],
                        [ "price", 30, "lt" ],
                    ])
                    ->sortOrder( "created_at", "DESC")
                    ->limit(1, 10)
                    ->toArray();

            expect($res)->to->be->an("array");
        });
    });
});