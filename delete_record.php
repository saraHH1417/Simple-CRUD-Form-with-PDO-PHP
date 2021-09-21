<?php
    require_once 'database.php';
    $id = filter_input(INPUT_POST, 'id' , FILTER_VALIDATE_INT);

    if($id) {
        $query = "delete from city
                    where ID = :id";

        $statement = $db->prepare($query);
        $statement->bindValue(":id" , $id);
        $success = $statement->execute();
        $statement->closeCursor();
        echo "Record deleted successfully. <br><br><br>
                <a href='index.php'> Go to request forms! </a>";
    }





