<?php
namespace CarloNicora\Minimalism\PhpTest\Models;

use CarloNicora\JsonApi\Objects\Link;
use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\PhpTest\PhpTest;
use Exception;

class NewUser extends AbstractModel
{
    /** @var string|null  */
    protected ?string $view = 'new';

    /**
     * @param PhpTest $phpTest
     * @return int
     * @throws Exception
     */
    public function get(
        PhpTest $phpTest
    ): int
    {
        $this->document->links->add(
            New Link(
                'home',
                $phpTest->getHome()
            )
        );

        return 200;
    }
}