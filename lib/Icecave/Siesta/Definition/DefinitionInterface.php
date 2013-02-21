<?php
namespace Icecave\Siesta\Definition;

interface DefinitionInterface
{
    /**
     * @param integer $majorVersion
     */
    public function setMajorVersion($majorVersion);

    /**
     * @return integer
     */
    public function incrementMajorVersion();

    /**
     * @return integer
     */
    public function majorVersion();

    /**
     * @param integer $minorVersion
     */
    public function setMinorVersion($minorVersion);

    /**
     * @return integer
     */
    public function incrementMinorVersion();

    /**
     * @return integer
     */
    public function minorVersion();

    /**
     * @param string $path
     * @param object $endpoint
     */
    public function add($path, $endpoint);

    /**
     * @param string $path
     */
    public function remove($path);
}
