<?php
    
    spl_autoload_register(function ($class) {
        if (file_exists($class . '.php')) {
            require_once $class . '.php';
        }
    });
    
    $classe = $_REQUEST['class'];
    $method = isset($_REQUEST['method']) ? $_REQUEST['method'] : null;
    unset($_REQUEST['class'],$_REQUEST['method']);
    
    if (class_exists($classe)) {
        $pagina = new $classe($_REQUEST);
        if (!empty($method) and (method_exists($classe, $method))) {
            $pagina->$method($_REQUEST);
        }
        $pagina->show();
    }else{
        header("Location: https://localhost/php_product/index.php?class=ProductList");
    }
