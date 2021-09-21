<?php
    require_once 'database.php';

    $id =  filter_input(INPUT_POST, 'id' , FILTER_VALIDATE_INT);
    $city =  filter_input(INPUT_POST, 'city' , FILTER_VALIDATE_INT);
    $country_code =  filter_input(INPUT_POST, 'country_code' , FILTER_VALIDATE_INT);
    $district =  filter_input(INPUT_POST, 'district' , FILTER_VALIDATE_INT);
    $population =  filter_input(INPUT_POST, 'population' , FILTER_VALIDATE_INT);

    if($id) {
        $query = "update city
                    set Name = :city and CountryCode = :country_code and District= :district and Population= :population
                    where ID= :id";
        $statement = $db->prepare($query);

        $statement->bindValue(":id" , $id);
        $statement->bindValue(":city" , $city);
        $statement->bindValue(":country_code" , $country_code);
        $statement->bindValue(":district" , $district);
        $statement->bindValue(":population" , $population);

        $success = $statement->execute();
        $statement->closeCursor();
        echo "Record updated successfully. <br><br><br>
                <a href='index.php'> Go to request forms! </a>";
    }
