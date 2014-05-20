<?php

namespace Functional\Slinp\SlinpBundle\Routing;

use Slinp\SlinpBundle\Routing\SlinpResourceMatcher;
use Symfony\Component\HttpFoundation\Request;
use Slinp\SlinpBundle\Tests\Functional\BaseTestCase;

class SlinpResourceMatcherTest extends BaseTestCase
{
    protected $matcher;

    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures('website.xml');
        $logger = $this->getContainer()->get('logger');
        $this->matcher = new SlinpResourceMatcher($this->getManagerRegistry(), '/slinp/web', $logger);
    }

    public function provideMatchTest()
    {
        return array(
            // should be the homepage
            array('/', 'SlinpBundle:Article:default'),

            // should be an ArticleFolder
            array('/articles', 'SlinpBundle:ArticleFolder:default'),

            // should find this one
            array('/articles/Faster-than-light', 'SlinpBundle:Article:default'),

            // unknown suffix should fall back to first known suffix
            array('/articles/foobar/barfoo', 'SlinpBundle:ArticleFolder:default'),
        );
    }

    /**
     * @dataProvider provideMatchTest
     */
    public function testRoutingMatch($uri, $expectedController)
    {
        $request = Request::create($uri);
        $res = $this->matcher->matchRequest($request);

        $this->assertEquals($expectedController, $res['_controller']);
    }

    /**
     * @expectedException RouteNotFoundException
     */
    public function testRoutingNotMatch()
    {
        $request = Request::create('/foobar');
        $res = $this->matcher->matchRequest($request);
    }
}
