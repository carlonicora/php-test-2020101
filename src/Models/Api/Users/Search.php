<?php
namespace CarloNicora\Minimalism\PhpTest\Models\Api\Users;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Interfaces\DataInterface;
use CarloNicora\Minimalism\Parameters\PositionedParameter;
use CarloNicora\Minimalism\PhpTest\Data\Builders\UserBuilder;
use CarloNicora\Minimalism\PhpTest\Data\Databases\Test\Tables\UsersTable;
use CarloNicora\Minimalism\Services\JsonApi\JsonApi;
use Exception;

class Search extends AbstractModel
{
    /**
     * @param JsonApi $jsonApi
     * @param DataInterface $data
     * @param PositionedParameter $name
     * @return int
     * @throws Exception
     */
    public function get(
        JsonApi $jsonApi,
        DataInterface $data,
        PositionedParameter $name
    ): int
    {
        /** @var UsersTable $usersTable */
        $usersTable = $data->create(UsersTable::class);

        $users = $usersTable->bySearchedName($name->getValue());

        $this->document->resources = $jsonApi->generateResourceObjectByData(
            builderName: UserBuilder::class,
            cache: null,
            dataList: $users
        );

        $this->document->forceResourceList();

        return 200;
    }
}