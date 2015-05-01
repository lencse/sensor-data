<?php


namespace LokiLevente\SensorData\App;


use LokiLevente\SensorData\Exception\SensorDataException;
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
     * @param string[] $arguments
     */
    public function run(array $arguments)
    {
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
        $path = $parser->parse();
        $path->filterWrongData();
        printf("Length of the path: %.3f km\n", $path->getLength() / 1000);
    }

}