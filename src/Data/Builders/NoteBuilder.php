<?php
namespace CarloNicora\Minimalism\PhpTest\Data\Builders;

use CarloNicora\Minimalism\Interfaces\CacheBuilderFactoryInterface;
use CarloNicora\Minimalism\PhpTest\Data\Databases\Test\Tables\NotesTable;
use CarloNicora\Minimalism\Services\JsonApi\Builders\Abstracts\AbstractResourceBuilder;
use CarloNicora\Minimalism\Services\JsonApi\Builders\Interfaces\RelationshipTypeInterface;
use Exception;

class NoteBuilder extends AbstractResourceBuilder
{
    /** @var string */
    public string $type = 'note';

    /** @var string|null */
    public ?string $tableName = NotesTable::class;

    /**
     *
     */
    protected function setAttributes(): void
    {
        $this->generateAttribute('id')
            ->setDatabaseFieldName('noteId')
            ->setIsEncrypted(true)
            ->setIsRequired(true)
            ->setIsReadOnly(true);

        $this->generateAttribute('userId');
        $this->generateAttribute('note');
    }

    /**
     * @throws Exception
     */
    protected function setRelationships(): void {
        $this->addRelationship(
            $this->relationshipBuilderInterfaceFactory->create(
                RelationshipTypeInterface::ONE_TO_ONE,
                'owner'
            )->withBuilder(
                UserBuilder::attributeId(),
                'userId'
            )->withoutChildren()
        );
    }

    /**
     * @param CacheBuilderFactoryInterface $cacheFactory
     */
    public function setCacheFactoryInterface(CacheBuilderFactoryInterface $cacheFactory): void {}
}