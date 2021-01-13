<?php
namespace CarloNicora\Minimalism\PhpTest\Models;

use CarloNicora\JsonApi\Objects\Link;
use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\PhpTest\Commands\ApiCommand;
use CarloNicora\Minimalism\PhpTest\PhpTest;
use Exception;

class Index extends AbstractModel
{
    /** @var string|null  */
    protected ?string $view = 'index';

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

        $apiCommand = new ApiCommand();

        $response = 0;

        $this->document = $apiCommand->request(
            $response,
            'GET',
            '/api/users'
        );
        $this->document->forceResourceList();

        return $response;
    }

    /**
     * @param PhpTest $phpTest
     * @param string|null $searchedName
     * @return int
     * @throws Exception
     */
    public function post(
        PhpTest $phpTest,
        string $searchedName=null
    ): int
    {
        $this->document->links->add(
            New Link(
                'home',
                $phpTest->getHome()
            )
        );

        $apiCommand = new ApiCommand();

        $response = 0;

        $this->document = $apiCommand->request(
            $response,
            'GET',
            '/api/users/search/' . $searchedName,
        );
        $this->document->forceResourceList();

        $this->document->meta->add(
            'searchedName',
            $searchedName
        );

        return $response;
    }
}