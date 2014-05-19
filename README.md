# Slinp

Slinp is a Web Content Framework based on Symfony and PHPCR.

Slinp routes requests to controllers by first finding a *node* that
corresponds to the incoming URL and then the controller is determined
based on the type of the node.

The nodes which are "exposed" to the web are kept in a special folder "web".
The nodes found within this folder can additionally be classed as *resources*.

For example, you have a node in your content repository at `/web/articles/my-article`
it has the type `MyCms:Article`. if we request `/articles/my-article` the
request will be forwarded to the controller `MyCmsBundle:Article:default`,
which can then create a response based upon the node.

````php
<?php

namespace MyCmsBundle\Controller;

class ArticleController
{
    public function defaultAction($node)
    {
        return $this->render('MyCmsBundle:Article:default.html.twig', array(
            'node' => $node
        ));
    }
}
````

## What is a Slinp?

Slip is influenced by the Apache Sling project, originally I wanted to call it
Pling, but that name is already used by various projects. So I put the "P" at
the end instead. Clever no?

## When resources are not enough

This model allows content to be routed to a single action in a controller. But
what do we do when the action relies upon sub-actions? For example, a page to
show all the comments of an article?

Slinp allows you to append additional routes to a resource using Annotations
in the controller:

````
<?php

class ArticleController extends Controller
{
    // ...

    /**
     * @Slinp\Route(pattern=/comments)
     */
    public function commentsAction($node)
    {
        return $this->render('MyCmsBundle:Article:comments.html.twig', array(
            'node' => $node->getChildren('*', 'mycms:comment')
        ));
    }
}
````
