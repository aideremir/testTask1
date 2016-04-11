<?
include 'db_config.php';
include 'classes/abstractTree.class.php';
include 'classes/myTree.class.php';

header('Content-Type: text/json');

$command = isset($_GET['command']) ? trim($_GET['command']) : '';

$allowedCommands = array('showPreloadedTree', 'ajaxFetchTreeNode');

if (!in_array($command, $allowedCommands)) {
    echo '{"error": "' . $command . ' command not allowed!"}';
    exit;
}

$tree = new myTree();

switch ($command) {
    case 'showPreloadedTree':
        $result = $tree->showPreloadedTree();
        break;

    case 'ajaxFetchTreeNode':
        if (!isset($_GET['nodeId'])) {
            echo '{"error": "nodeId is required"}';
            exit;
        }

        $result = $tree->ajaxFetchTreeNode(intval($_GET['nodeId']));
        break;
}


echo json_encode($result);