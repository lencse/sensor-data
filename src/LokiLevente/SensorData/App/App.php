<?php


namespace LokiLevente\SensorData\App;


use LokiLevente\SensorData\Exception\SensorDataException;
use LokiLevente\SensorData\Geo\Path;
use LokiLevente\SensorData\Parser\Parser;


class App
{

    /**
     * @var string
     */
    private $scriptName;

    /**
     * @var string
     */
    private $scriptDir;

    /**
     * @var string
     */
    private $dataFile;

    /**
     * @var Path
     */
    private $path;

    /**
     * @var Path
     */
    private $noFiltered;

    /**
     * @param string[] $arguments
     */
    public function run(array $arguments)
    {
        // @TODO
        // if (null === $argv) {
        //     $argv = $_SERVER['argv'];
        // }
        try {
            $this->execute($arguments);
        }
        catch (SensorDataException $e) {
            echo $e->getMessage();

            exit($e->getCode());
        }
    }

    /**
     * @param string[] $arguments
     * @throws SensorDataException
     */
    private function parseArguments(array $arguments)
    {
        $path = explode(DIRECTORY_SEPARATOR, $arguments[0]);
        $this->scriptName = array_pop($path);
        $this->scriptDir = implode(DIRECTORY_SEPARATOR, $path);
        if (count($arguments) < 2) {
            throw new SensorDataException(sprintf('Usage: php %s DATA_KML_FILE', $this->scriptName));
        }
        $this->dataFile = $this->scriptDir . DIRECTORY_SEPARATOR . $arguments[1];
        if (!is_file($this->dataFile)) {
            throw new SensorDataException(sprintf('Missing file: %s', $arguments[1]), 1);
        }
    }

    /**
     * @param array $arguments
     * @throws SensorDataException
     */
    private function execute(array $arguments)
    {
        $this->parseArguments($arguments);
        $parser = new Parser($this->dataFile);
        $this->path = $parser->parse();
        $this->noFiltered = $this->path->copy();
        $this->path->filterWrongData();
    }

    public function printOutput()
    {
        printf("Length of the path: %.3f km\n", $this->path->getLength() / 1000);
    }

    public function printOutputForNoFiltered()
    {
        printf("Length of the path: %.3f km\n", $this->noFiltered->getLength() / 1000);
    }

    /**
     * @return Path
     */
    public function getFilteredPath()
    {
        return $this->path;
    }

    /**
     * @return Path
     */
    public function getNoFilteredPath()
    {
        return $this->noFiltered;
    }

}