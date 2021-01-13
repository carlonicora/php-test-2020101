<?php
namespace CarloNicora\Minimalism\PhpTest\Data\DataReaders;

use CarloNicora\Minimalism\Interfaces\CacheInterface;
use CarloNicora\Minimalism\Interfaces\DataInterface;
use CarloNicora\Minimalism\Interfaces\DataLoaderInterface;
use CarloNicora\Minimalism\Interfaces\ServiceInterface;
use CarloNicora\Minimalism\PhpTest\Data\Databases\Test\Tables\NotesTable;
use Exception;

class NotesDataReader implements DataLoaderInterface
{
    /**
     * UsersLoader constructor.
     * @param DataInterface $data
     * @param CacheInterface|null $cache
     * @param ServiceInterface|null $phpTest
     * @throws Exception
     */
    public function __construct(
        protected DataInterface $data,
        ?CacheInterface $cache,
        ?ServiceInterface $phpTest,
    )
    {
    }

    /**
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function byUserId(int $userId): array
    {
        /** @see NotesTable::byUserId() */
        return $this->data->read(
            NotesTable::class,
            'byUserId',
            [
                'userId' => $userId
            ]
        );
    }
}