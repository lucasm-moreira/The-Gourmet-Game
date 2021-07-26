<?php 
require('NodeTree.php');
require('SystemControl.php');

class GourmetGame
{
    private bool $loop;
    private string $title;
    private NodeTree $nodeTree;
    private SystemControl $systemControl;

    public function __construct()
    {
        $this->loop = true;
        $this->title = 'Pense em um prato que gosta.';
        $this->nodeTree = new NodeTree();
        $this->systemControl = new SystemControl();
    }

    private function validateNameAndFeatureString(string $name, string $feature)
    {
        $validatedName = preg_match('/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/', $name);
        $validatedFeature = preg_match('/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/', $feature);

        if($validatedName && $validatedFeature) {
            return true;
        }

        return false;
    }

    private function validateYesOrNoResponse($response): bool|null
    {
        if(strtolower($response) == 's' || strtolower($response) == 'sim') {
            return true;
        }

        else if (strtolower($response) == 'n' || strtolower($response) == 'não') {
            return false;
        }

        else {
            return null;
        }
    }    

    private function setupGame(): void
    {
        $this->nodeTree->insert(null, 'Bolo de Chocolate', true);
        $this->changeNodeToFeatureValue($this->nodeTree->getRoot(), 'Massa', 'Lasanha');
    }

    public function startGame():void
    {
        if($this->nodeTree->isEmpty()) {
            $this->setupGame();
        }

        $this->showInitialDialog();

        while($this->loop) {
            $this->guessFood($this->nodeTree->getRoot());
        }
    }

    private function guessFood(Node $node):void
    {
        $this->systemControl->clearScreen();
        $response = readline("O prato que você pensou é ". $node->getValue() . "? - (S - sim / N - não): ");        
        
        if ($this->validateYesOrNoResponse($response)) {
            if($node->isLeaf()) {
                $this->win();
            }

            else {
                $this->guessFood($node->getRightChild());
            }
        }

        else if (!$this->validateYesOrNoResponse($response)) {
            if($node->getRightChild() == null) {
                $this->askInformationAboutFood($node);
                $this->startGame();
            }

            else {
                $this->guessFood($node->getLeftChild());
            }
        }

        else {
            $this->guessFood($node);
        }
    }

    private function showInitialDialog(): void
    {
        $this->systemControl->clearScreen();
        print_r($this->title);
        print_r("\n\nUse S ou Sim para confirmar e N ou Não para negar.\nDemais casos serão considerados como não.");
        readline("\n\nPressione qualquer tecla para continuar...");
        $this->systemControl->clearScreen();
    }

    private function win(): void 
    {
        $this->systemControl->clearScreen();
        print_r('Acertei de novo!');
        readline("\n\nPressione qualquer tecla para continuar...");
    }

    private function askInformationAboutFood(Node $node): void 
    {
        $this->systemControl->clearScreen();
        print_r("\nDesisto!\n\n");
        $name = readline("Qual prato você pensou? -> Resposta: ");
        print_r("\nComplete\n\n");
        $feature = readline($name . " é __________ mas " . $node->getValue() . " não. -> Resposta: ");

        if($this->validateNameAndFeatureString($name, $feature)) {
            $this->changeNodeToFeatureValue($node, $feature, $name);
        }

        else {
            $this->askInformationAboutFood($node);
        }
    }

    private function changeNodeToFeatureValue(Node $node, string $feature, string $name):void
    {
        $wrongTry = $node->getValue();
        $node->setValue($feature);
        $node->setLeftChild(new Node($wrongTry));
        $node->setRightChild(new Node($name));
    }
}

?>