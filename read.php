<?php 
    if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
        require_once 'config.php';
        $sql = 'SELECT * FROM employees WHERE id = :id';

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':id', $param_id);
            $param_id = trim($_GET['id']);

            if ($stmt->execute()) {
                
                if ($stmt->rowCount() == 1) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $name = $row['name'];
                    $address = $row['address'];
                    $salary = $row['salary'];
                } else {
                    header('location: error.php');
                    exit();
                }
            } else {
                echo 'Oops! Something went wrong. Please try again later.';
            }
        }
        unset($stmt);
        unset($pdo);
    } else {
        header('location: error.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View </title>
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container pt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>View Record</h2>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <p class="form-control"><?php echo $name; ?></p>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <p class="form-control"><?php echo $address; ?></p>
                </div>
                <div class="form-group">
                    <label for="salary">Salary</label>
                    <p class="form-control"><?php echo $salary; ?></p>
                </div>
                <p><a href="index.php" class="btn btn-primary">Back</a></p>
            </div>
        </div>
    </div>    
</body>
</html>