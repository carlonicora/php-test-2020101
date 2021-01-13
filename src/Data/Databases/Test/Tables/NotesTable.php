<?php
namespace CarloNicora\Minimalism\PhpTest\Data\Databases\Test\Tables;

use CarloNicora\Minimalism\Services\MySQL\Abstracts\AbstractMySqlTable;
use CarloNicora\Minimalism\Services\MySQL\Interfaces\FieldInterface;
use Exception;

class NotesTable extends AbstractMySqlTable
{
    /** @var string  */
    protected string $tableName = 'notes';

    /** @var array  */
    protected array $fields = [
        'noteId'    => FieldInterface::INTEGER
                    +  FieldInterface::PRIMARY_KEY
                    +  FieldInterface::AUTO_INCREMENT,
        'userId'    => FieldInterface::STRING,
        'note'      => FieldInterface::STRING
    ];

    /**
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function byUserId(
        int $userId
    ): array {
        $this->sql = 'SELECT * FROM notes WHERE userId=?;';
        $this->parameters = ['i', $userId];

        return $this->functions->runRead();
    }
}