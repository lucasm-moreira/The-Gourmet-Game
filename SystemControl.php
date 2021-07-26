<?php 

class SystemControl
{
    private string $command;

    public function getCommand()
    {
        return $this->command;
    }

    public function setCommand(string $command)
    {
        $this->command = $command;
    }

    public function clearScreen()
    {
        echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
    }
}

?>