<?php
declare(strict_types=1);

namespace PunktDe\FusionFeed\FusionObject;

/*
 *  (c) 2021 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 *  All rights reserved.
 */

use GuzzleHttp\Psr7\Message;
use Neos\Flow\Annotations as Flow;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;

class FeedImplementation extends AbstractFeedElement
{
    /**
     * @Flow\Inject
     * @var StreamFactoryInterface
     */
    protected $contentStreamFactory;

    /**
     * @Flow\Inject
     * @var ResponseFactoryInterface
     */
    protected $responseFactory;

    protected string $elementClassName = Feed::class;

    public function evaluate()
    {
        /** @var Feed $feed */
        $feed = parent::evaluate();

        $response = $this->responseFactory->createResponse()
            ->withHeader('content-type', 'application/rss+xml; charset=UTF-8');

        $contentStream = $this->contentStreamFactory->createStream($feed->render());
        $response = $response->withBody($contentStream);

        return Message::toString($response);
    }


    protected function getChannel(): void
    {
        $channel = $this->fusionValue('channel');
        assert($channel instanceof Channel);

        $channel->appendTo($this->getFeedElement());
    }
}
