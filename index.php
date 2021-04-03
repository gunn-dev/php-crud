<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container pt-3">
        <div class="row">
            <div class="col-md-8">
                <h2>Employees Details</h2>
            </div>
            <div class="col-md align-self-end">
                <a href="create.php" class="btn btn-success btn-sm">Add New Employee</a>
            </div>
        </div>
        <div class="mb-3"></div>
        <?php
        require_once 'config.php';
        $sql = 'SELECT * FROM employees';
        if($result = $pdo->query($sql)) {
            if ($result->rowCount() > 0) {
                echo "<table class='table'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<td>#</td>";
                            echo "<td>Name</td>";
                            echo "<td>Address</td>";
                            echo "<td>Salary</td>";
                            echo "<td>Action</td";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = $result->fetch()) {
                        echo "<tr>";
                            echo "<td>".$row['id']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['address']."</td>";
                            echo "<td>".$row['salary']."</td>";
                            echo "<td>";
                                echo "<a href='read.php?id=".$row['id']."' title='View Record' data-toggle='tooltip' class='btn btn-sm btn-success'>View</a>";
                                echo "<a href='update.php?id=".$row['id']."' title='Update Record' data-toggle='tooltip' class='btn btn-sm btn-info'>Update</a>";
                                echo "<a href='delete.php?id=".$row['id']."' title='Delete' data-toggle='tooltip' class='btn btn-sm btn-danger'>Delete</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                echo "</table>";
                unset($result);
            } else {
                echo '<p class="lead text-center text-danger pt-5"><em>No Record Found.</em></p>';
            }
        } else {
            echo "ERROR: Could not able to execute $sql".$mysqli->error;
        }
        unset($pdo);
        ?>
    </div>
</body>
</html>