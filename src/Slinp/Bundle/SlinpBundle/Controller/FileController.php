<?php

namespace Slinp\Bundle\SlinpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Slinp\Bundle\SlinpBundle\Annotation\Route;
use Slinp\Component\NodeMapper\SlinpNodeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Handler for displaying JCR nt:file nodes
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class FileController extends Controller
{
    /**
     * @Route("/")
     */
    public function defaultAction(SlinpNodeInterface $resource)
    {
        $content = $resource->node()->getNode('jcr:content');
        $data = $content->getPropertyValue('jcr:data');
        $mimeType = $content->getPropertyValue('jcr:mimeType');

        return new StreamedResponse(function () use ($data) {
            while ($line = fgets($data)) {
                echo $line;
            }
        }, 200, array('Content-Type' => $mimeType));
    }
}
