<?php

namespace spec\Slinp\SlinpBundle\Util;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class NodeTypeNameTranslatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\SlinpBundle\Util\NodeTypeNameTranslator');
    }

    function let(
        KernelInterface $kernel
    )
    {
        $this->beConstructedWith($kernel);
    }

    function it_should_translate_to_a_bundle_namespace(
        KernelInterface $kernel,
        BundleInterface $bundle
    )
    {
        $kernel->getBundle('MyCmsBundle')->willReturn($bundle);
        $bundle->getNamespace()->willReturn('Foo\\Bar');

        $this->toBundleNamespace('myCms:foo')->shouldReturn('Foo\\Bar');
    }

    function it_should_translate_to_a_controller_path(
        KernelInterface $kernel,
        BundleInterface $bundle
    )
    {
        $kernel->getBundle('SlinpTestBundle')->willReturn($bundle);
        $bundle->getNamespace()->willReturn('Slinp\\SlinpTestBundle');

        $this->toControllerPath('slinpTest:article')->shouldMatch('{Slinp/SlinpTestBundle/Controller/ArticleController.php}');
    }

    function it_should_translate_to_a_slinp_object(
        KernelInterface $kernel,
        BundleInterface $bundle
    )
    {
        $kernel->getBundle('SlinpTestBundle')->willReturn($bundle);
        $bundle->getNamespace()->willReturn('Slinp\\SlinpTestBundle');

        $this->toSlinpObject('slinpTest:article')->shouldReturn('Slinp\SlinpTestBundle\SlinpObject\Article');
    }
}
