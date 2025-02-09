
<?php
require_once '../core/Router.php';
require_once '../app/config/config.php';

if (Database::getInstance()->getConnection()) {
    echo "Connection successful";
} else {
    echo "Error connecting";
}

$router = new Router();
?>


<!-- if(Database::getInstance()->getConnection()){
    echo "connextion succesful";
}
else{
    echo "error connecting";
} -->
