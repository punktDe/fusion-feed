<?php
declare(strict_types=1);

namespace PunktDe\FusionFeed\FusionObject\Enclosure;

/*
 *  (c) 2021 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 *  All rights reserved.
 */

use Exception;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Routing\Exception\MissingActionNameException;
use Neos\Media\Domain\Model\AssetInterface;
use Neos\Media\Domain\Model\Thumbnail;
use Neos\Media\Domain\Model\ThumbnailConfiguration;
use Neos\Media\Domain\Service\ThumbnailService;
use Neos\Media\Exception\AssetServiceException;
use Neos\Media\Exception\ThumbnailServiceException;
use Neos\Neos\Fusion\ImageUriImplementation;
use PunktDe\FusionFeed\Dto\Enclosure;

class ImageEnclosureImplementation extends ImageUriImplementation
{

    /**
     * @Flow\Inject
     * @var ThumbnailService
     */
    protected $thumbnailService;

    /**
     * @return Enclosure|null
     * @throws \Neos\Flow\Http\Exception
     * @throws MissingActionNameException
     * @throws AssetServiceException
     * @throws ThumbnailServiceException
     */
    public function evaluate(): ?Enclosure
    {
        $asset = $this->getAsset();
        $preset = $this->getPreset();

        if (!$asset instanceof AssetInterface) {
            throw new Exception('No asset given for rendering.', 1615314381);
        }
        if (!empty($preset)) {
            $thumbnailConfiguration = $this->thumbnailService->getThumbnailConfigurationForPreset($preset);
        } else {
            $thumbnailConfiguration = new ThumbnailConfiguration($this->getWidth(), $this->getMaximumWidth(), $this->getHeight(), $this->getMaximumHeight(), $this->getAllowCropping(), $this->getAllowUpScaling(), $this->getAsync(), $this->getQuality(), $this->getFormat());
        }
        $request = $this->getRuntime()->getControllerContext()->getRequest();

        $thumbnailImage = $this->thumbnailService->getThumbnail($asset, $thumbnailConfiguration);

        if (!$thumbnailImage instanceof Thumbnail) {
            return null;
        }

        $thumbnailData = $this->assetService->getThumbnailUriAndSizeForAsset($asset, $thumbnailConfiguration, $request);

        $enclosure = new Enclosure(
            $thumbnailData['src'],
            (int)$thumbnailImage->getResource()->getFileSize(),
            $thumbnailImage->getResource()->getMediaType(),
        );

        return $enclosure;
    }
}
