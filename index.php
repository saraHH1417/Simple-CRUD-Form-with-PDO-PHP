<?php

    $new_city = filter_input(INPUT_POST, "new_city" , FILTER_SANITIZE_STRING);
    $country_code = filter_input(INPUT_POST, "country_code" , FILTER_SANITIZE_STRING);
    $district = filter_input(INPUT_POST, "district" , FILTER_SANITIZE_STRING);
    $population = filter_input(INPUT_POST, "population" , FILTER_SANITIZE_STRING);


    $city = filter_input(INPUT_GET, "city" , FILTER_SANITIZE_STRING);
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDO Project</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <main>
        <header>
            <h1> PHP PDO Tutorial</h1>
        </header>


        <?php
          if( !$city && !$new_city) {
        ?>
            <section>
                <h2> Select Data / Read Data</h2>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
                    <label for="city">City Name</label>
                    <input type="text" id="city" name="city" required>
                    <button>Submit</button>
                </form>
            </section>

            <section>
                <h2> Insert Data / Create Data</h2>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <label for="new_city">City Name</label>
                    <input type="text" id="new_city" name="new_city" required>
                    <label for="country_code">Country Code</label>
                    <input type="text" id="country_code" name="country_code" maxlength="3" required>
                    <label for="district">District</label>
                    <input type="text" id="district" name="district" required>
                    <label for="population">Population</label>
                    <input type="text" id="population" name="population" required>
                    <button>Submit</button>
                </form>
            </section>
        <?php }else { ?>
              <?php require_once 'database.php'; ?>

              <?php  if($new_city)  {
                        $query = "insert into city
                                        (Name, CountryCode, District, Population)
                                     values   
                                        (:new_city , :country_code, :district, :population)";
                        $statement = $db->prepare($query);
                        $statement->bindValue(':new_city' , $new_city);
                        $statement->bindValue(':country_code' , $country_code);
                        $statement->bindValue(':district' , $district);
                        $statement->bindValue(':population' , $population);
                        $statement->execute();
                        $statement->closeCursor();

                        echo "Data inserted successfully. <br><br><br>";
                     }
                     if($city) {
                        $query = 'select * from city
                                    where Name = :city
                                    order by population desc ';

                        $statement = $db->prepare($query);

                        $statement->bindValue(':city' , $city);

                        $statement->execute();
                        $results = $statement->fetchAll();
                        $statement->closeCursor();
                    }
              ?>
              <?php if(!empty($results)) {?>
                    <section>
                        <h2> Update Or Delete Data</h2>
                        <?php foreach ($results as $result) {
                            $id = $result['ID'];
                            $city = $result['Name'];
                            $country_code = $result['CountryCode'];
                            $district = $result['District'];
                            $population = $result['Population'];
                        ?>
                            <form class="update" action="update_record.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $id?>">
                                <label for="city-<?php echo $id;?>"> City Name:</label>
                                <input type="text" id="city-<?php echo $id;?>" value="<?php echo $city ?>"
                                       name="city" required>

                                <label for="country_code-<?php echo $id;?>"> Country Code:</label>
                                <input type="text" id="country_code-<?php echo $id;?>" value="<?php echo $country_code ?>"
                                       name="country_code" required>

                                <label for="district-<?php echo $id;?>"> District:</label>
                                <input type="text" id="district-<?php echo $id;?>" value="<?php echo $district ?>"
                                       name="district" required>

                                <label for="population-<?php echo $id;?>"> Population:</label>
                                <input type="text" id="population-<?php echo $id;?>" value="<?php echo $population ?>"
                                       name="population" required>

                                <button> Update</button>
                            </form>
                            <form class="delete" action="delete_record.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <button class="red"> Delete</button>
                            </form>
                      <?php } ?>
                    </section>
              <?php } else if(isset($results) && empty($results)) { ?>
                            <P> Sorry. No results. <br><br><br></P>
              <?php }?>
              <a href="<?php echo $_SERVER['PHP_SELF'] ?>"> Go to request forms! </a>
        <?php } ?>
    </main>
</body>
</html>
