<?php

namespace MakinaCorpus\ElasticSearch\Tests;

use MakinaCorpus\Lucene\TermQuery;

class TermQueryTest extends \PHPUnit_Framework_TestCase
{
    // Tests for class TermQuery 
    
    public function testSetValue()
    {
        $query = new TermQuery();
        $query->setValue("foo");

        $this->assertSame(
            'foo',
            trim((string)$query)
        );
    }
    
    public function testEscapesSpecialChars()
    {
        $query = new TermQuery();
        $query->setValue("foo^");

        $this->assertSame(
            '"foo\^"',
            trim((string)$query)
        );
    }
    
    public function testIsEmptyTrueOnTermInstantiation()
    {
        $query = new TermQuery();

        $this->assertTrue($query->isEmpty());
    }
    
    public function testIsEmptyTrueWhenValueIsEmptyString()
    {
        $query = new TermQuery();
        $query->setValue("");

        // should?
        $this->assertTrue($query->isEmpty());
    }

    public function testIsEmptyFalseWhenValueIsNotEmptyString()
    {
        $query = new TermQuery();
        $query->setValue("foo");

        $this->assertFalse($query->isEmpty());
    }
    
    // Tests for class AbstractFuzzyQuery    
    
    public function testSetFuzzyness()
    {
        $query = new TermQuery();
        $query
            ->setValue("foo")
            ->setFuzzyness(5.2);

        $this->assertSame(
            'foo~5.2',
            trim((string)$query)
        );
    }
    
    public function testSetFuzzynessEqualsSetRoaming()
    {
        $query1 = new TermQuery();
        $query1
            ->setValue("foo")
            ->setFuzzyness(5.2);

        $query2 = new TermQuery();
        $query2
            ->setValue("foo")
            ->setRoaming(5.2);

        $this->assertSame(
            trim((string)$query1),
            trim((string)$query2)
        );
    }
    
    public function testNullFuzzyness()
    {
        $query = new TermQuery();
        $query
            ->setValue("foo")
            ->setFuzzyness(null);

        $this->assertSame(
            'foo',
            trim((string)$query)
        );
    }
    
    // Tests for class AbstractQuery

    public function testSetBoost()
    {
        $query = new TermQuery();
        $query
            ->setValue("foo")
            ->setBoost(5.2);

        $this->assertSame(
            'foo^5.2',
            trim((string)$query)
        );
    }

    public function testSetField()
    {
        $query = new TermQuery();
        $query
            ->setValue("foo")
            ->setField("thisField");

        $this->assertSame(
            'thisField:foo',
            trim((string)$query)
        );
    }

    public function testSetAnythingButValue()
    {
        $query = new TermQuery();
        $query
            ->setField("thisField")
            ->setBoost(5.2)
            ->setFuzzyness(5.2);

        $this->assertSame(
            '',
            trim((string)$query)
        );
    }
    
}
