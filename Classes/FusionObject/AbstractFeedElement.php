<?php
declare(strict_types=1);

namespace PunktDe\FusionFeed\FusionObject;

/*
 *  (c) 2021 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 *  All rights reserved.
 */

use Neos\Fusion\FusionObjects\DataStructureImplementation;
use PunktDe\FusionFeed\Exception\FeedElementException;

class AbstractFeedElement extends DataStructureImplementation
{

    protected string $elementClassName = '';

    protected ?object $feedElement = null;

    /**
     * @throws FeedElementException
     */
    public function evaluate()
    {
        $data = parent::evaluate();

        foreach ($data as $key => $value) {
            $formattedElementGetter = 'get' . ucfirst($key);
            if (method_exists($this, $formattedElementGetter)) {
                $value = $this->$formattedElementGetter();
            }

            if (empty($value) || !method_exists($this->getFeedElement(), $key)) {
                continue;
            }

            if (is_array($value)) {
                $this->getFeedElement()->$key(...$value);
            } else {
                $this->getFeedElement()->$key($value);
            }
        }

        return $this->getFeedElement();
    }

    protected function getFeedElement(): object
    {
        if ($this->feedElement === null) {
            $this->feedElement = new $this->elementClassName();
        }

        return $this->feedElement;
    }
}
