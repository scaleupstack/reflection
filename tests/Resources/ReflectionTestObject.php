<?php

/**
 * This file is part of ScaleUpStack/Reflection.
 *
 * For the full copyright and license information, please view the README.md and LICENSE.md files that were distributed
 * with this source code.
 *
 * @copyright 2019 - present ScaleUpVentures GmbH, https://www.scaleupventures.com
 * @link      https://github.com/scaleupstack/reflection
 */

namespace ScaleUpStack\Reflection\Tests\Resources;

class ReflectionTestObject
{
    private $firstProperty = 'just relevant for sorting of all properties';

    private $myPrivateProperty = 'some private value';

    protected $myProtectedProperty = 'some protected value';

    public $myLastAndPublicProperty = 'and last, some public value';

    private static $someStaticProperty = 'my static value';

    public function setFirstProperty($value)
    {
        $this->firstProperty = $value;
    }

    public function getMyPrivateProperty() : string
    {
        return $this->myPrivateProperty;
    }
}
