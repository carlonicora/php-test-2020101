<?php
namespace CarloNicora\Minimalism\PhpTest;

use CarloNicora\Minimalism\Interfaces\ServiceInterface;
use CarloNicora\Minimalism\Services\JsonApi\JsonApi;
use CarloNicora\Minimalism\Services\Path;
use Exception;

class PhpTest implements ServiceInterface
{
    /**
     * PhpTest constructor.
     * @param Path $path
     * @param JsonApi $jsonApi
     * @param string $MINIMALISM_PHPTEST_ROOT
     * @throws Exception
     */
    public function __construct(
        Path $path,
        JsonApi $jsonApi,
        private string $MINIMALISM_PHPTEST_ROOT
    )
    {
        $jsonApi->preLoadBuilders(
            $path->getRoot()
            . DIRECTORY_SEPARATOR
            . 'src' . DIRECTORY_SEPARATOR
            . 'Data' . DIRECTORY_SEPARATOR
            . 'Builders'
        );
    }

    /**
     * @return string
     */
    public function getHome(): string
    {
        return $this->MINIMALISM_PHPTEST_ROOT;
    }

    /**
     *
     */
    public function initialise(): void {}

    /**
     *
     */
    public function destroy(): void {}
}