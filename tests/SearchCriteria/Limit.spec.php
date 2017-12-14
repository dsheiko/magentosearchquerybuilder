<?php
namespace tests\unit\Dsheiko\SearchCriteria\Limit;

use Dsheiko\SearchCriteria\Limit;
use Dsheiko\Reflection as Access;

/**
 * Assertions http://peridot-php.github.io/leo/expect.html
 */
describe("Dsheiko\SearchCriteria\Limit", function() {


    describe("::buildClause", function() {
        it("generates intended string", function() {
            $method = Access::staticMethod("\Dsheiko\SearchCriteria\Limit", "buildClause");
            $res = $method("field", 1);
            expect($res)->to->equal("searchCriteria[field]=1");
        });
    });

    describe("->build", function() {
       it("generates an array of intended strings", function() {
           $builder = new Limit();
           $res = $builder->build(1, 2);
           list($page, $size) = $res;
           expect($page)->to->equal("searchCriteria[current_page]=1");
           expect($size)->to->equal("searchCriteria[page_size]=2");
       });
    });



});