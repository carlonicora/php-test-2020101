<?php
namespace CarloNicora\Minimalism\PhpTest\Data\Databases\Test\Tables;

use CarloNicora\Minimalism\Exceptions\RecordNotFoundException;
use CarloNicora\Minimalism\Services\MySQL\Abstracts\AbstractMySqlTable;
use CarloNicora\Minimalism\Services\MySQL\Interfaces\FieldInterface;
use Exception;

class UsersTable extends AbstractMySqlTable
{
    /** @var string  */
    protected string $tableName = 'users';

    /** @var array  */
    protected array $fields = [
        'userId'    => FieldInterface::INTEGER
                    +  FieldInterface::PRIMARY_KEY
                    +  FieldInterface::AUTO_INCREMENT,
        'firstName' => FieldInterface::STRING,
        'lastName'  => FieldInterface::STRING,
        'email'     => FieldInterface::STRING
    ];

    /**
     * @return array
     * @throws Exception
     */
    public function all(
    ): array {
        $this->sql = 'SELECT * FROM userss ORDER BY lastName,firstName;';
        $this->parameters = [];

        return $this->functions->runRead();
    }

    /**
     * @param int $userId
     * @return array
     * @throws RecordNotFoundException
     */
    public function byUserId(
        int $userId
    ): array {
        $this->sql = 'SELECT * FROM users WHERE userId=?;';
        $this->parameters = ['i', $userId];

        return $this->functions->runReadSingle();
    }

    /**
     * @param string $searchedName
     * @return array
     * @throws Exception
     */
    public function bySearchedName(
        string $searchedName
    ): array {
        $this->sql = 'SELECT * FROM users WHERE firstName LIKE ? OR lastName LIKE ?;';
        $this->parameters = ['ss', '%' . $searchedName . '%', '%' . $searchedName . '%'];

        return $this->functions->runRead();
    }
}