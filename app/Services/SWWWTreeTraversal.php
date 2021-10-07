<?php
namespace App\Services;

class SWWWTreeTraversal {

    protected $tree;
    protected $output = array();


    public function __construct($conf){
        $this -> tree = isset($conf['tree']) ? $conf['tree'] : array();
        $this -> preorder($this->tree);
    }

    protected function preorder($nodes){
       // $nodes = $this->filter_array_keys(['id' , 'children'] , $nodes);
        if(empty($nodes)){
            return;
        }

        foreach($nodes as $node){
            $this->visit_root($node);

            $this->visit_children($node);
        }
    }

    protected function visit_root($root){

        if(! is_array($root) && !is_object($root)){
            $this->output[] = $root;
        }
    }

    protected function visit_children($children){
        if(is_array($children)){
            $this->preorder($children);
        }
    }

    public function get(){
        return $this->output;
    }

    public function filter_array_keys($allowed , $my_array) {
        $filtered = array_filter(
            $my_array,
            function ($key) use ($allowed) {
                return in_array($key, $allowed);
            },
            ARRAY_FILTER_USE_KEY
        );
        return $filtered;
    }
}