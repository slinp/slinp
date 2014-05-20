<?php

namespace Functional\Slinp\SlinpBundle\Routing;

use Slinp\SlinpBundle\Routing\SlinpMatcher;
use Symfony\Component\HttpFoundation\Request;
use Slinp\SlinpBundle\Tests\Functional\BaseTestCase;

class SlinpMatcherTest extends BaseTestCase
{
    protected $matcher;

    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures('website.xml');

        $this->matcher = $this->getContainer()->get('slinp.routing.matcher');
    }

    public function provideMatchTest()
    {
        return array(
            // should be the homepage
            array('/', 'Slinp\SlinpBundle\Controller\ArticleController::showAction'),

            // should be an ArticleFolder
            array('/articles', 'Slinp\SlinpBundle\Controller\ArticleFolderController::indexAction'),

            // should find this one
            array('/articles/Faster-than-light', 'Slinp\SlinpBundle\Controller\ArticleController::showAction'),

            // unknown suffix should fall back to first known suffix
            array('/articles/foobar/barfoo', 'Slinp\SlinpBundle\Controller\ArticleFolderController::indexAction', true),
        );
    }

    /**
     * @dataProvider provideMatchTest
     */
    public function testRoutingMatch($uri, $expectedController, $notFound = false)
    {
        if ($notFound) {
            $this->setExpectedException('Symfony\Component\Routing\Exception\ResourceNotFoundException');
        }

        $request = Request::create($uri);
        $res = $this->matcher->matchRequest($request);

        $this->assertEquals($expectedController, $res['_controller']);
    }

    /**
     * @expectedException Symfony\Component\Routing\Exception\ResourceNotFoundException
     */
    public function testRoutingNotMatch()
    {
        $request = Request::create('/foobar');
        $res = $this->matcher->matchRequest($request);
    }
}
