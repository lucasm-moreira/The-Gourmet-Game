<?php 

class Node
{
    private string $value;
    private Node|null $leftChild;
    private Node|null $rightChild;

    public function __construct(string $data)
    {
        $this->value = $data;
        $this->setLeftChild(null);
        $this->setRightChild(null);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getLeftChild(): Node|null
    {
        return $this->leftChild;
    }

    public function setLeftChild(Node|null $leftChild): void
    {
        $this->leftChild = $leftChild;
    }

    public function getRightChild(): Node|null
    {
        return $this->rightChild;
    }

    public function setRightChild(Node|null $rightChild): void
    {
        $this->rightChild = $rightChild;
    }

    public function isLeaf(): bool
    {
        if($this->leftChild == null && $this->rightChild == null) {
            return true;
        }
        return false;
    }
}

?>