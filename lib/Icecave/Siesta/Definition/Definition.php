<?php
namespace Icecave\Siesta\Definition;

class Definition implements DefinitionInterface
{
    /**
     * @param integer $majorVersion
     */
    public function setMajorVersion($majorVersion)
    {
        $this->majorVersion = $majorVersion;
        $this->minorVersion = 0;
    }

    /**
     * @return integer
     */
    public function incrementMajorVersion()
    {
        return ++$this->majorVersion;
    }

    /**
     * @return integer
     */
    public function majorVersion()
    {
        return $this->majorVersion;
    }

    /**
     * @param integer $minorVersion
     */
    public function setMinorVersion($minorVersion)
    {
        $this->minorVersion = $minorVersion;
    }

    /**
     * @return integer
     */
    public function incrementMinorVersion()
    {
        return ++$this->minorVersion;
    }

    /**
     * @return integer
     */
    public function minorVersion()
    {
        return $this->minorVersion;
    }

    public function extendPreviousVersion()
    {
        $this->extendsPreviousVersion = true;
    }

    /**
     * @param string $path
     * @param object $endpoint
     */
    public function add($path, $endpoint)
    {
        $this->routes[] = array(
            $this->majorVersion,
            $this->minorVersion,
            $path,
            $endpoint
        );
    }

    /**
     * @param string $path
     */
    public function remove($path)
    {
        $this->routes[] = array(
            $this->majorVersion,
            $this->minorVersion,
            $path,
            null
        );
    }

    private $router;
    private $extendsPreviousVersion = false;
    private $majorVersion = 1;
    private $minorVersion = 0;
    private $routes = array();
}
