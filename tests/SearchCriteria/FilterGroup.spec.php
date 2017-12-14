<?php
namespace tests\unit\Dsheiko\SearchCriteria\FilterGroup;

use Dsheiko\SearchCriteria\FilterGroup;
use Dsheiko\Reflection as Access;

/**
 * Assertions http://peridot-php.github.io/leo/expect.html
 */
describe("Dsheiko\SearchCriteria\FilterGroup", function() {


    describe("::buildClause", function() {
        it("generates intended string", function() {
            $method = Access::staticMethod("\Dsheiko\SearchCriteria\FilterGroup", "buildClause");
            $res = $method("field", "foo", 0, 0);
            expect($res)->to->equal("searchCriteria[filter_groups][0][filters][0][field]=foo");
        });
    });

     describe("->build", function() {
        it("generates an array of intended strings", function() {
            $builder = new FilterGroup();
            $res = $builder->build("foo", "bar", "eq");
            list($field, $value, $operator) = $res;
            expect($field)->to->equal("searchCriteria[filter_groups][0][filters][0][field]=foo");
            expect($value)->to->equal("searchCriteria[filter_groups][0][filters][0][value]=bar");
            expect($operator)->to->equal("searchCriteria[filter_groups][0][filters][0][condition_type]=eq");
        });
        it("iterates index for every criteria", function() {
            $builder = new FilterGroup();
            $builder->build("foo", "bar", "eq");
            $res = $builder->build("foo", "bar", "eq");
            list($field) = $res;
            expect($field)->to->equal("searchCriteria[filter_groups][0][filters][1][field]=foo");
        });
        it("throws InvalidArgumentException on invalid operator", function() {
            $builder = new FilterGroup();
            expect(function () use ($builder) {
                $builder->build("foo", "bar", "invalid");
            })->to->throw("\InvalidArgumentException");
        });
    });
});