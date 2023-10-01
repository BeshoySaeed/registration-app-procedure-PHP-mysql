<?php 
    // session_start();
    // if(!$_SESSION['email']){
    //     header("location: ../register.html");
    // }
?>

<table border="1">

    <tr>
        <th>id</th>
        <th>first name</th>
        <th>last name</th>
        <th>email</th>
        <th>phone</th>
        <th>password</th>
        <th>img</th>
        <th>controls</th>
    </tr>

    <?php 

    session_start();

    if($_SESSION['errors']){
        print_r($_SESSION['errors']);

    }else{
        echo "no errors";
    }

    try {
        require_once('./db.inc.php');

        $query = "SELECT * FROM students;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        
        foreach($data as $key => $value){
            echo "<tr>";
            foreach($value as $k => $v){
                if($k == 'img'){
                    echo "<td><img src='./uploads/{$value['img']}' width='40px'> </td>";
                }else{

                    echo "<td> $v </td>";
                }
            }
            echo "<td> <a href='../edit-page.php?id={$value['id']}' > Edit </a> <a href='db-delete.php?id={$value['id']}' >Delete</a> </td>";
            echo "</tr>";
        }


    } catch (\Throwable $th) {
        //throw $th;
    }
    ?>

</table>
