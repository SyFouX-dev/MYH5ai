<?php

class H5AI {

    private $_tree;
    private $_path;

    public function __construct($path) {
        $this->_path = $path; 
        $this->_tree = array();
    }

    public function getTree() {
        return $this->_tree; 
    }
    
    public function getPath() {
        return $this->_path; 
    }

    public function getFiles(array $fileList, string $parent) {
        $tmp = array();
        
        foreach ($fileList as $file) {
            $filePath = $parent . "/" . $file;
            if ($file === "." || $file === ".." || $file === '.git')
                continue;

            if (is_dir($filePath)) {
                $tmp[$file] = $this->getFiles(scandir($filePath), $filePath);
                continue;
            }

            if (is_file($filePath)) {
                $size = filesize($filePath);
                $sizes = array('octets', 'Ko', 'Mo', 'Go', 'To');
                for ($i=0; $size > 1024 && $i < count($sizes) - 1; $i++) {
                    $size /= 1024;
                }
                
                $decimalplaces = 2; 
                $formattedSize = round($size, $decimalplaces).' '.$sizes[$i]. ' ' . ':';
                $formattedDate = 'Dernière modification' . ' ' . ':' . ' ' .  date("M d Y H:i", filemtime($filePath));
                
                $tmp[] =  $file . ' : ' . $formattedSize . ' ' . $formattedDate;
                continue;
            }
            
            echo "ERROR : File " . $file . " at " . $filePath . " doesn't exist !" . '<br>';
        }

        if ($parent === $this->_path)
            $this->_tree[$parent] = $tmp;
        return $tmp;
         }

    public function printTree(array $tree, int $count = 0) {
        foreach ($tree as $key => $element) {
            if (is_array($element)) {
                echo str_repeat("&nbsp;", $count * 4) . "<h4>"  .$key . "</h4><br>";

                $this->printTree($element, $count + 1);

            } else {
                echo str_repeat("&nbsp;", $count * 4) . "<li>" . $element . "</li><br>";
            }
        }
    }
}



// nodemon start