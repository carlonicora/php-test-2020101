<?php
namespace CarloNicora\Minimalism\PhpTest\Models;

use CarloNicora\JsonApi\Objects\Link;
use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Exceptions\RecordNotFoundException;
use CarloNicora\Minimalism\Factories\ServiceFactory;
use CarloNicora\Minimalism\Interfaces\DataInterface;
use CarloNicora\Minimalism\Parameters\PositionedParameter;
use CarloNicora\Minimalism\PhpTest\Commands\ApiCommand;
use CarloNicora\Minimalism\PhpTest\Data\Builders\UserBuilder;
use CarloNicora\Minimalism\PhpTest\Data\Databases\Test\Tables\UsersTable;
use CarloNicora\Minimalism\PhpTest\PhpTest;
use CarloNicora\Minimalism\Services\JsonApi\JsonApi;
use Exception;
use RuntimeException;

class User extends AbstractModel
{
    /** @var string|null  */
    protected ?string $view = 'user';

    /** @var UsersTable  */
    private UsersTable $usersTable;

    /**
     * User constructor.
     * @param ServiceFactory $services
     * @param string|null $function
     * @throws Exception
     */
    public function __construct(ServiceFactory $services, ?string $function = null)
    {
        parent::__construct($services, $function);

        $data = $services->create(DataInterface::class);
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $this->usersTable = $data->create(UsersTable::class);
    }

    /**
     * @param JsonApi $jsonApi
     * @param PhpTest $phpTest
     * @param PositionedParameter $userId
     * @return int
     * @throws Exception
     */
    public function get(
        JsonApi $jsonApi,
        PhpTest $phpTest,
        PositionedParameter $userId,
    ): int
    {
        $this->document->links->add(
            New Link(
                'home',
                $phpTest->getHome()
            )
        );

        try {
            $user = $this->usersTable->byUserId($userId->getValue());
        } catch (RecordNotFoundException) {
            throw new RuntimeException('user not found', 404);
        }

        $this->document->resources = $jsonApi->generateResourceObjectByData(
            builderName: UserBuilder::class,
            cache: null,
            dataList: [$user],
            loadRelationshipsLevel: 1
        );

        return 200;
    }

    /**
     * @param PhpTest $phpTest
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $email
     * @return int
     * @throws Exception
     */
    public function post(
        PhpTest $phpTest,
        ?string $firstName='',
        ?string $lastName='',
        ?string $email='',
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
            'POST',
            '/api/users',
            'firstName=' . $firstName . '&lastName=' . $lastName . '&email=' . $email
        );

        return 200;
    }
}