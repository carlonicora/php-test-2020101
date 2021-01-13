<?php
namespace CarloNicora\Minimalism\PhpTest\Models\Api;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Interfaces\DataInterface;
use CarloNicora\Minimalism\PhpTest\Data\Builders\UserBuilder;
use CarloNicora\Minimalism\PhpTest\Data\Databases\Test\Tables\UsersTable;
use CarloNicora\Minimalism\Services\JsonApi\JsonApi;
use Exception;

class Users extends AbstractModel
{
    /**
     * @param JsonApi $jsonApi
     * @param DataInterface $data
     * @return int
     * @throws Exception
     */
    public function get(
        JsonApi $jsonApi,
        DataInterface $data,
    ): int
    {
        /** @var UsersTable $usersTable */
        $usersTable = $data->create(UsersTable::class);

        $users = $usersTable->all();

        $this->document->resources = $jsonApi->generateResourceObjectByData(
            builderName: UserBuilder::class,
            cache: null,
            dataList: $users,
            loadRelationshipsLevel: 1
        );

        $this->document->forceResourceList();

        return 200;
    }

    /**
     * @param JsonApi $jsonApi
     * @param DataInterface $data
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $email
     * @return int
     * @throws Exception
     */
    public function put(
        JsonApi $jsonApi,
        DataInterface $data,
        ?string $firstName='',
        ?string $lastName='',
        ?string $email='',
    ): int
    {
        $user = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
        ];

        $newUser = $data->insert(
            UsersTable::class,
            $user,
        );

        $this->document->resources = $jsonApi->generateResourceObjectByData(
            builderName: UserBuilder::class,
            cache: null,
            dataList: [$newUser]
        );

        return 201;
    }
}