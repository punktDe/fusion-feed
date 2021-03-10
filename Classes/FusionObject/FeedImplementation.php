<?php
declare(strict_types=1);

namespace PunktDe\FusionFeed\FusionObject;

/*
 *  (c) 2021 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 *  All rights reserved.
 */

use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;

class FeedImplementation extends AbstractFeedElement
{

    protected string $elementClassName = Feed::class;

    protected function getChannel(): void
    {
        $channel = $this->fusionValue('channel');
        assert($channel instanceof Channel);

        $channel->appendTo($this->getFeedElement());
    }
}
