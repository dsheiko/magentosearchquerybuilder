<?php
namespace tests\unit\Dsheiko\SearchCriteria\SortOrder;

use Dsheiko\SearchCriteria\SortOrder;
use Dsheiko\Reflection as Access;

/**
 * Assertions http://peridot-php.github.io/leo/expect.html
 */
describe("Dsheiko\SearchCriteria\SortOrder", function() {


    describe("::buildClause", function() {
        it("generates intended string", function() {
            $method = Access::staticMethod("\Dsheiko\SearchCriteria\SortOrder", "buildClause");
            $res = $method("field", "foo", 0);
            expect($res)->to->equal("searchCriteria[sort_orders][0][field]=foo");
        });
    });

    describe("->build", function() {
       it("generates an array of intended strings", function() {
           $builder = new SortOrder();
           $res = $builder->build("foo", "ASC");
           list($field, $value) = $res;
           expect($field)->to->equal("searchCriteria[sort_orders][0][field]=foo");
           expect($value)->to->equal("searchCriteria[sort_orders][0][direction]=ASC");
       });
       it("iterates index for every criteria", function() {
           $builder = new SortOrder();
           $builder->build("foo", "ASC");
           $res = $builder->build("foo", "ASC");
           list($field) = $res;
           expect($field)->to->equal("searchCriteria[sort_orders][1][field]=foo");
       });
       it("throws InvalidArgumentException on invalid operator", function() {
           $builder = new SortOrder();
           expect(function () use ($builder) {
               $builder->build("foo", "invalid");
           })->to->throw("\InvalidArgumentException");
       });
    });



});