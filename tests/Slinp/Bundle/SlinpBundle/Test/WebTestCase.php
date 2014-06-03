<?php

namespace Slinp\Bundle\SlinpBundle\Test;

use Slinp\SlinpBundle\Test\Container;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use PHPCR\ImportUUIDBehaviorInterface;

abstract class WebTestCase extends BaseWebTestCase
{
    private $container;
    private $session;
    private $managerRegistry;

    public function setUp()
    {
        parent::setUp();

        $this->managerRegistry = $this->getContainer()->get('doctrine_phpcr');
        $this->session = $this->managerRegistry->getConnection();

        $rootNode = $this->session->getRootNode();
        if ($rootNode->hasNode('slinp')) {
            $this->session->removeItem('/slinp');
            $this->session->save();
        }
    }

    public function getSession() 
    {
        return $this->session;
    }

    public function getManagerRegistry() 
    {
        return $this->managerRegistry;
    }

    public function loadFixtures($filename)
    {
        $fixturePath = __DIR__ . '/../../../../Resources/fixtures/' . $filename;

        if (!file_exists($fixturePath)) {
            throw new \InvalidArgumentException('Fixture file ' . $fixturePath . ' does not exist.');
        }

        $this->session->importXml('/', $fixturePath, ImportUUIDBehaviorInterface::IMPORT_UUID_COLLISION_REPLACE_EXISTING);
        $this->session->save();
    }

    /**
     * Gets the container.
     *
     * @return Container
     */
    public function getContainer()
    {
        if (null === $this->container) {
            $client = self::createClient();
            $this->container = $client->getContainer();
        }

        return $this->container;
    }
}
