<?php
namespace CarloNicora\Minimalism\PhpTest\Data\Builders;

use CarloNicora\Minimalism\Interfaces\CacheBuilderFactoryInterface;
use CarloNicora\Minimalism\PhpTest\Data\Databases\Test\Tables\UsersTable;
use CarloNicora\Minimalism\PhpTest\Data\DataReaders\NotesDataReader;
use CarloNicora\Minimalism\Services\JsonApi\Builders\Abstracts\AbstractResourceBuilder;
use CarloNicora\Minimalism\Services\JsonApi\Builders\Interfaces\RelationshipTypeInterface;
use Exception;

class UserBuilder extends AbstractResourceBuilder
{
    /** @var string */
    public string $type = 'user';

    /** @var string|null */
    public ?string $tableName = UsersTable::class;

    /**
     *
     */
    protected function setAttributes(): void
    {
        $this->generateAttribute('id')
            ->setDatabaseFieldName('userId')
            ->setIsEncrypted(true)
            ->setIsRequired(true)
            ->setIsReadOnly(true);

        $this->generateAttribute('firstName');
        $this->generateAttribute('lastName');
        $this->generateAttribute('email');
    }

    /**
     * @throws Exception
     */
    protected function setRelationships(): void {
        /** @see NotesDataReader::byUserId() */
        $this->addRelationship(
            $this->relationshipBuilderInterfaceFactory->create(
                RelationshipTypeInterface::ONE_TO_MANY,
                'notes'
            )->withLoaderFunction(
                NotesDataReader::class,
                NoteBuilder::class,
                'byUserId',
                [
                    'userId' => self::attributeId()
                ]
            )
        );
    }

    /**
     * @param CacheBuilderFactoryInterface $cacheFactory
     */
    public function setCacheFactoryInterface(CacheBuilderFactoryInterface $cacheFactory): void {}
}