<?php

namespace Slinp\SlinpBundle\Tests\Functional;

class BaseTestCase extends WebTestCase
{
    protected $container;

    /**
     * Gets the container.
     *
     * @return Container
     */
    public function getContainer()
    {
        if (null === $this->container) {
            $client = $this->createClient($this->getKernelConfiguration());
            $this->container = $client->getContainer();
        }

        return $this->container;
    }

}
