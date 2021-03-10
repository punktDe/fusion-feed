<?php
declare(strict_types=1);

namespace PunktDe\FusionFeed\FusionObject;

/*
 *  (c) 2021 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 *  All rights reserved.
 */

use DateTime;
use PunktDe\FusionFeed\Dto\Enclosure;
use Suin\RSSWriter\Item;

class ItemImplementation extends AbstractFeedElement
{

    protected string $elementClassName = Item::class;

    protected function getPubDate(): int
    {
        /** @var DateTime $pubDate */
        $pubDate = $this->fusionValue('pubDate');
        if (empty($pubDate)) {
            return 0;
        }

        assert($pubDate instanceof DateTime, 'pubDate needs to be \DateTime but is ' . gettype($pubDate));
        return $pubDate->getTimestamp();
    }

    protected function getEnclosure(): array
    {
        $enclosure = $this->fusionValue('enclosure');
        if (!$enclosure instanceof Enclosure) {
            return [];
        }

        return $enclosure->toArray();
    }

    /**
     * Add several categories by passing a plain array
     */
    protected function getCategories(): void
    {
        $categories = $this->fusionValue('categories');

        if (empty($categories)) {
            return;
        }

        assert(is_iterable($categories), 'You need to pass an iteraable value');

        foreach ($categories as $category) {
            $this->getFeedElement()->category($category);
        }
    }
}
