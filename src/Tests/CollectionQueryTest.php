<?php

namespace MakinaCorpus\ElasticSearch\Tests;

use MakinaCorpus\Lucene\CollectionQuery;
use MakinaCorpus\Lucene\TermQuery;
use MakinaCorpus\Lucene\Query;

class CollectionQueryTest extends \PHPUnit_Framework_TestCase
{
    // Tests for class CollectionQuery 

    /**
     * @expectedException InvalidArgumentException
     */     
    public function testAddInvalidArgumentException()
    {
        $query = new CollectionQuery();
        $query->add("notAnAbstractQuery");
    }


    public function testAddOneTerm()
    {
        $term = (new TermQuery())
            ->setValue("foo");

        $query = (new CollectionQuery())
            ->setOperator(Query::OP_AND)
            ->add($term);

        $this->assertSame(
            'foo',
            trim((string)$query)
        );        
    }

    public function testAddTerm()
    {
        $term1 = (new TermQuery())
            ->setValue("foo");

        $term2 = (new TermQuery())
            ->setValue("bar");
        
        $query = (new CollectionQuery())
            ->add($term1)
            ->add($term2);

        $this->assertSame(
            '(foo bar)',
            trim((string)$query)
        );

        $query->setOperator(Query::OP_AND);

        $this->assertSame(
            '(foo AND bar)',
            trim((string)$query)
        );
    }
    
}
