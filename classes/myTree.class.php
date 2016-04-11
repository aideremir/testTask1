<?php

/**
 * Please write your code here
 */
class myTree extends abstractTree
{
    /**
     * Constructor: Connects to DB
     */
    function __construct()
    {
        $this->dbLink = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
        mysqli_select_db($this->dbLink, DB_NAME);
    }

    /**
     * Executes query and fetches result into array of objects
     * @param $sql — query to execute
     * @return array of objects
     * */
    private function _queryExecute($sql)
    {
        $items = array();

        $queryResult = mysqli_query($this->dbLink, $sql);

        while ($item = mysqli_fetch_object($queryResult)) {
            $items[] = $item;
        }

        mysqli_close($this->dbLink);

        return $items;
    }

    /**
     * Fetches all categories from Db
     * and putting them into tree structure
     * @return array category tree
     */
    public function showPreloadedTree()
    {
        // Categories tree
        $tree = new stdClass();
        $tree->subcategories = array();

        // pointers to tree nodes
        $pointers = array();
        $pointers[0] = &$tree;

        $categories = $this->_queryExecute("select *
                FROM tree_menu t
                ORDER BY t.name");

        $finish = false;

        while (!empty($categories) && !$finish) {
            $flag = false;
            foreach ($categories as $k => $category) {
                if (isset($pointers[$category->parent_id])) {
                    // adding current category to tree
                    $pointers[$category->node_id] = $pointers[$category->parent_id]->subcategories[] = $category;

                    // and sorting categories on one level
                    usort($pointers[$category->parent_id]->subcategories, array('myTree', 'compareCategories'));

                    // Removing used categories from categories array
                    unset($categories[$k]);
                    $flag = true;
                }
            }
            if (!$flag) $finish = true;
        }

        unset($pointers[0]);

        return $tree->subcategories;

    }

    /**
     * Don't know what it is needed for...
     */
    public function ajaxShowTree()
    {

    }

    /**
     * Fetches only one tree node
     * @param $nodeId — id of the tree node to fetch
     * @return category, identified by $nodeId with it's child categories (1 level only)
     * */
    public function ajaxFetchTreeNode($nodeId)
    {
        $sql = "select t.*, (SELECT count(*) FROM tree_menu WHERE parent_id=t.node_id) as subcategoriesCount
                FROM tree_menu t
                WHERE t.parent_id=" . intval($nodeId) . "
                ORDER BY t.name";

        return $this->_queryExecute($sql);
    }


    /**
     * Compares two category objects
     * @param $cat1 — category object 1
     * @param $cat3 — category object 2
     * @return 1 , 0 , or -1 if cat1 > cat2, cat1 = cat2, cat1 < cat2
     * */
    static function compareCategories($cat1, $cat2)
    {
        $name1 = strtolower($cat1->Name);
        $name2 = strtolower($cat2->Name);
        if ($name1 == $name2) {
            return 0;
        }
        return ($name1 > $name2) ? +1 : -1;
    }
}