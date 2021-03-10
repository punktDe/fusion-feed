<?php
declare(strict_types=1);

namespace PunktDe\FusionFeed\FusionObject\Enclosure;

/*
 *  (c) 2021 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 *  All rights reserved.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\ResourceManagement\PersistentResource;
use Neos\Flow\ResourceManagement\ResourceManager;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use PunktDe\FusionFeed\Dto\Enclosure;

class AssetEnclosureImplementation extends AbstractFusionObject
{

    /**
     * @Flow\Inject
     * @var ResourceManager
     */
    protected $resourceManager;

    public function evaluate(): ?Enclosure
    {
        $resource = $this->getResource();
        $uri = $this->resourceManager->getPublicPersistentResourceUri($resource);

        if (!$resource instanceof PersistentResource) {
            return null;
        }

        return new Enclosure(
            $uri,
            (int)$resource->getFileSize(),
            $resource->getMediaType(),
        );
    }

    public function getResource(): PersistentResource
    {
        return $this->fusionValue('resource');
    }
}
