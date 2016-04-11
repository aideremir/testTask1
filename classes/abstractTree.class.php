<?php

abstract class abstractTree
{
    abstract public function showPreloadedTree();

    abstract public function ajaxShowTree();

    abstract public function ajaxFetchTreeNode($nodeId);
}