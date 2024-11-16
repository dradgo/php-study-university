<?php

class Temperature
{
    public string $label;
    public float $value;

    public function __construct(string $label, float $value)
    {
        $this->label = $label;
        $this->value = $value;
    }
}

class TemperatureList
{
    private array $temperatures = [];

    // Method to add a temperature instance to the list
    public function addTemperature(Temperature $temperature): void
    {
        $this->temperatures[] = $temperature;
    }

    // Method to get the top 5 highest temperatures
    public function getTop5Values(): array
    {
        usort($this->temperatures, function ($a, $b) {
            return $b->value <=> $a->value;
        });

        return array_slice($this->temperatures, 0, 5);
    }

    // Method to get the lowest 5 temperatures
    public function getLeast5Values(): array
    {
        usort($this->temperatures, function ($a, $b) {
            return $a->value <=> $b->value;
        });

        return array_slice($this->temperatures, 0, 5);
    }
}

// Example usage
$tempList = new TemperatureList();

$tempList->addTemperature(new Temperature("New York", 30.5));
$tempList->addTemperature(new Temperature("Los Angeles", 25.0));
$tempList->addTemperature(new Temperature("Chicago", 15.0));
$tempList->addTemperature(new Temperature("Houston", 35.2));
$tempList->addTemperature(new Temperature("Phoenix", 40.0));
$tempList->addTemperature(new Temperature("San Diego", 22.1));
$tempList->addTemperature(new Temperature("Dallas", 28.3));
$tempList->addTemperature(new Temperature("San Francisco", 18.5));

$top5 = $tempList->getTop5Values();
$least5 = $tempList->getLeast5Values();

// Display top 5 temperatures
echo "Top 5 Temperatures:<br/>";
foreach ($top5 as $temperature) {
    echo $temperature->label . ": " . $temperature->value . "<br/>";
}
echo "<br/>";

// Display least 5 temperatures
echo "\nLeast 5 Temperatures:<br/>";
foreach ($least5 as $temperature) {
    echo $temperature->label . ": " . $temperature->value . "<br/>";
}
?>
