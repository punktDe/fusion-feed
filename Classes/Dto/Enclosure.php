<?php
declare(strict_types=1);

namespace PunktDe\FusionFeed\Dto;

/*
 *  (c) 2021 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 *  All rights reserved.
 */

class Enclosure
{

    protected string $url = '';

    protected int $length = 0;

    protected string $mimeType = '';

    /**
     * Enclosure constructor.
     * @param string $url
     * @param int $length
     * @param string $mimeType
     */
    public function __construct(string $url, int $length, string $mimeType)
    {
        $this->url = $url;
        $this->length = $length;
        $this->mimeType = $mimeType;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function toArray(): array
    {
        return [$this->getUrl(), $this->getLength(), $this->getMimeType()];
    }
}
