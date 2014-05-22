# Slinp

[![Build
Status](https://travis-ci.org/dantleech/slinp.svg?branch=master)](https://travis-ci.org/dantleech/slinp)

**WARNING**: This is under heavy development!

Slinp is a Web Content Framework based on Symfony and PHPCR.

Slinp **maps incoming requests** to a path in the PHPCR content repository.  The
**node type** of the resource (i.e. node) at the path is then used to determine
which controller to use.

The routing works like this:

- Incoming HTTP request: `/foobar`
- Map request to PHPCR path: `/slinp/root/foobar`
- Get node type of node at `/slinp/root/foobar` => `slinp:article`
- Determine bundle and controller name: `SlinpBundle:Article`
- Read the routes from annotations in the controller
- Route the request!

An example controller looks like this:

````php
<?php

namespace Slinp\SlinpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Slinp\SlinpBundle\Annotation\Route;

// controller for node type "slinp:article"
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

I had been thinking about node-type based routing for some time I think, and
after 2 aborted projects I heard about the Apahce Sling project. Sling
corresponded very closely to what I wanted to achieve, so after reading about
Sling and implementing some of its ideas Slinp was born.

Originally I wanted to call it Pling, but that name is already used by various 
projects. So I put the "P" at the end instead. Clever no?

## Why use Slinp?

- **Low development time** -- Define some node types, create a controller, some
  templates, and your done -- or just use the built-in node types and
  controllers and create some content!
- **Node type based routing** -- Slinp is content-centric. You can put your
  content where you want and it will always be rendered by the same
  controller. The ability to add routes to resources via. annotations makes
  Slinp web application friendly.
- **Schematic CMS design** -- You can define your content the way you want
  using PHPCRs node types -- be as strict or as loose as you like! Also you can
  create automatically created nodes and properties.

## Why should I use Slinp in the future?

Slinp isn't finished yet..

- **Admin Generation** -- Node types provide perfect meta data for generating
  admin forms. And because of the inheritance of node types admin forms will
  always fallback to the admin form defined for `slinp:resource`. Basically -
  instant admin, no fuss.
