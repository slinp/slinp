<?php

namespace Slinp\Bridge\LiipImagineBundle\Binary\Loader;

use Liip\ImagineBundle\Exception\Binary\Loader\NotLoadableException;
use PHPCR\SessionInterface;
use PHPCR\NodeInterface;
use Liip\ImagineBundle\Binary\Loader\LoaderInterface;

/**
 * Load images from a PHPCR repository.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PhpcrLoader implements LoaderInterface
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var string
     */
    protected $webRoot;

    /**
     * @param SessionInterface $session
     */
    public function __construct($webRoot, SessionInterface $session)
    {
        $this->session = $session;
        $this->webRoot = $webRoot;
    }

    /**
     * {@inheritDoc}
     */
    public function find($path)
    {
        $imageNode = $this->session->getNode($this->webRoot . '/' . $path);

        if ($imageNode instanceof NodeInterface) {
            if ('nt:file' === $imageNode->getPrimaryNodeType()->getName()) {
                $content = $imageNode->getPrimaryItem();
                $stream = $content->getPropertyValue('jcr:data');

                return stream_get_contents($stream);
            }
        }

        throw new NotLoadableException(sprintf(
            'Item at path "%s" must have the "nt:file" supertype.', $path
        ));
    }
}
