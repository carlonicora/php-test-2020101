<?php
namespace CarloNicora\Minimalism\PhpTest\Models;

use CarloNicora\JsonApi\Objects\Link;
use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\PhpTest\Commands\ApiCommand;
use CarloNicora\Minimalism\PhpTest\PhpTest;
use Exception;

class Note extends AbstractModel
{
    /**
     * @param PhpTest $phpTest
     * @param int $userId
     * @param string|null $note
     * @return int
     * @throws Exception
     */
    public function post(
        PhpTest $phpTest,
        int $userId,
        ?string $note='',
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

        $apiCommand->request(
            $response,
            'POST',
            '/api/notes',
            'userId=' . $userId . '&note=' . $note
        );

        if ($response === 201) {
            return $this->redirect(
                modelClass: User::class,
                function: 'get',
                positionedParameters: [$userId]
            );
        }

        return 200;
    }
}