<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$firstName = htmlspecialchars($_SESSION["first_name"]);
$role = $_SESSION["role"];

$pdo = getDBConnection();
$sql = "SELECT * FROM users";

if($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
// Attempt to execute the prepared statement
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
    }
}


//var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/stylesheets/table.css">
    <link rel="stylesheet" href="resources/stylesheets/style.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<?php include("svgImages.html"); ?>
<main class="d-flex flex-nowrap">
    <?php include("leftSideMenu.php"); ?>
    <div id="primary-window" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark overflow-y-scroll">
        <div>
            <a href="addUser.php" class="btn btn-primary">Add User</a>
        </div>
        <h1 class="my-5">Manage Users</h1>
        <table class="table table-striped table-hover"
            <thead>
            <tr>
                <th scope="col">id#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $count = 1;
            foreach($rows as $row)
            {
                if($row["is_active"]){
                $id = $row["id"];
                ?>
                <tr>
                    <th scope="row"><?= $id?></th>
                    <td><?= $row["first_name"] ?></td>
                    <td><?= $row["last_name"] ?></td>
                    <td><?= $row["email"] ?></td>
                    <td class ='<?= $role?>'><?= $row["role"] ?></td>
                    <td>
                        <a href="editUser.php?id=<?= $id?>" class="btn btn-info">Edit</a>
                        <a href="deleteUser.php?id=<?= $id?>" class="btn btn-danger">Delete</a>
                        <a href="resetUserPass.php?id=<?= $id?>" class="btn btn-danger">Reset PW</a>
                    </td>
                </tr>
                <?php
                $count++;
                }
            }
            ?>
            </tbody>
        </table>

    </div>
    <!-- end .container -->
    <!--       _
           .__(.)< (Connor did it!)
            \___)
    ~~~~~~~~~~~~~~~~~~-->
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body>
<script src="resources/scripts/popups.js">
    // let params = new URLSearchParams(location.search);
    // let status = params.get('status');
    // if(status!==null)
    //     alert(status);
</script>
</html>