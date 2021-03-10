<?php
declare(strict_types=1);

namespace PunktDe\FusionFeed\FusionObject;

/*
 *  (c) 2021 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 *  All rights reserved.
 */


use PunktDe\FusionFeed\Exception\FeedElementException;

class ChannelImplementation extends AbstractFeedElement
{

    protected string $elementClassName = \Suin\RSSWriter\Channel::class;

    protected function getPubDate(): int
    {
        /** @var \DateTime $pubDate */
        $pubDate = $this->fusionValue('pubDate');
        assert($pubDate instanceof \DateTime);
        return $pubDate->getTimestamp();
    }

    protected function getLastBuildDate(): int
    {
        /** @var \DateTime $lastBuildDate */
        $lastBuildDate = $this->fusionValue('lastBuildDate');
        assert($lastBuildDate instanceof \DateTime);
        return $lastBuildDate->getTimestamp();
    }

    /**
     * @throws FeedElementException
     */
    protected function getItems(): void
    {
        foreach ($this->fusionValue('items') as $item) {
            if (!$item instanceof \Suin\RSSWriter\Item) {
                throw new FeedElementException('Items need to be of type ' . Item::class, 1615239818);
            }

            $item->appendTo($this->getFeedElement());
        }
    }
}
