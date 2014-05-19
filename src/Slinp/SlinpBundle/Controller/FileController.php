<?php

namespace Slinp\SlinpBundle\Controller;

class FileController extends Controller
{
    /**
     * @Slinp\Route(node-type="nt:file", pattern="/")
     */
    public function defaultAction($node)
    {
    }

    /**
     * @Slinp\Route(node-type="nt:unstructured", pattern="/delete")
     */
    public function deleteAction($node)
    {

    }
}
