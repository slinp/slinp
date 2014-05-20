# Slinp

Slinp is a Web Content Framework based on Symfony and PHPCR.

Slinp maps incoming requests to a path in the PHPCR content repository.  The
node type of the corresponding resource (i.e. node) is then used to determine
which controller to use.

Route annotations in the controller decide which URLs are available for the
located resource and the request is routed accordingly.

All web facing nodes are located in `/slinp/web`. The "root" page (i.e. the
one that corresponds to the URL `/`) has a special name: `root`.

For example, you have a node in your repository at `/slinp/web/root/about-me`
which has the node type `slinp:article`. Slinp will determine that the
controller to use should be `SlinpBundle:Article`. Slinp will then scan
this controller for `@Route` annotations and route the request accordingly.


````php
<?php

namespace Slinp\SlinpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Slinp\SlinpBundle\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route(pattern="/")
     */
    public function showAction($node)
    {
        return $this->render('SlinpBundle:Article:show', $node);
    }

    /**
     * @Route(pattern="/edit")
     */
    public function editAction($node)
    {
        // process some editing
        return $this->render('SlinpBundle:Article:edit', $node);
    }
}
````

## What is a Slinp?

Slip is influenced by the Apache Sling project, originally I wanted to call it
Pling, but that name is already used by various projects. So I put the "P" at
the end instead. Clever no?
