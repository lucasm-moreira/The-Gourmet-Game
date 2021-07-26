<?php 
require('Node.php');

class NodeTree
{
    private Node|null $root;

    public function __construct()
    {
        $this->root = null;
    }

    public function getRoot(): Node
    {
        return $this->root;
    }

    public function setRoot(Node $root): void
    {
        $this->root = $root;
    }

    public function insert(Node|null $parentNode, string $value, bool $choice): void
    {
        $this->root = $this->insertNewNode($parentNode, $value, $choice);
    }

    public function isEmpty(): bool
    {
        if($this->root == null) {
            return true;
        }

        return false;
    }

    private function insertNewNode(Node|null $parentNode, string $value, bool $choice): Node
    {
        if($parentNode == null) {
            $parentNode = new Node($value);
            return $parentNode;
        }

        else if ($choice) {
            $parentNode->setRightChild($this->insertNewNode($parentNode->getRightChild(), $value, $choice));
        }

        else {
            $parentNode->setLeftChild($this->insertNewNode($parentNode->getLeftChild(), $value, $choice));
        }

        return $parentNode;
    }
}

?>