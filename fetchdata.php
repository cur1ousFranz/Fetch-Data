<?php 

$servername = "localhost";
$username = "root";
$password = "";

// CREATING DATABASE CONNECTION
try {
    $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    if($e->getCode() == 1045){
        echo "Coneection failed!";
    }
  }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

    <!-- CREATING A FROM THE GET THE DATA  -->
   <div class="container w-50 border mt-3">
       <form action="practice2.php" method="post">
            <input type="text" class="form-control mt-2" placeholder="Enter First Name" name="firstname" required>
            <input type="text" class="form-control mt-3" placeholder="Enter Last Name" name="lastname" required>
            <input type="email" class="form-control mt-3" placeholder="Enter Email" name="email" required>
            <button class="btn btn-primary form-control mt-3 mb-3" type="submit">Submit</button> 
        </form>
   </div>

        <!-- INSERTING THE DATA FROM THE FORM TO DATABASE -->
        <?php 
                // THIS IS THE METHOD HOW TO AVOID SQL INJECTION ATTACKS
                $stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email)
                VALUES (:firstname, :lastname, :email)");

                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':email', $email);

                if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email'])){
                 

                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $email = $_POST['email'];

                    $stmt->execute();
                    header('Location: practice2.php');
                }
                
        ?>
    
    <!-- Creating table to display all the data that has been fetched -->
    <div class="container mt-5">

        <table class="table table-striped table-hover">
            <thead class="bg-dark text-white">
                <tr>
                    <td>ID</td>
                    <td>FIRST NAME</td>
                    <td>LASTNAME</td>
                    <td>EMAIL</td>
                    <td>REG_DATE</td>
                </tr>
            </thead>
        <?php 
        // CREATING A QUERY
            $query = "SELECT * FROM myguests";
            $d = $conn->query($query);
            
            foreach($d as $data){

        ?>
            <tr>
                <td><?php echo $data['id'];?></td>
                <td><?php echo $data['firstname'];?></td>
                <td><?php echo $data['lastname'];?></td>
                <td><?php echo $data['email'];?></td>
                <td><?php echo $data['reg_date'];?> </td>
            </tr>
        <?php }?>
        </table>

    </div>
    
</body>
</html>