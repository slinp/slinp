<?php

namespace spec\Slinp\Bundle\SlinpBundle\Util;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class NodeTypeNameTranslatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\Bundle\SlinpBundle\Util\NodeTypeNameTranslator');
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
        $bundle->getNamespace()->willReturn('Slinp\\Bundle\\SlinpTestBundle');

        $this->toControllerPath('slinpTest:article')->shouldMatch('{Slinp/Bundle/SlinpTestBundle/Controller/ArticleController.php}');
    }

    function it_should_translate_to_a_slinp_object(
        KernelInterface $kernel,
        BundleInterface $bundle
    )
    {
        $kernel->getBundle('SlinpTestBundle')->willReturn($bundle);
        $bundle->getNamespace()->willReturn('Slinp\\Bundle\\SlinpTestBundle');

        $this->toSlinpNode('slinpTest:article')->shouldReturn('Slinp\Bundle\SlinpTestBundle\SlinpNode\Article');
    }

    function it_should_return_the_slinp_bundle_for_nt_node_types(
    )
    {
        $this->toBundleName('nt:foobar')->shouldReturn('SlinpBundle');
    }
}
