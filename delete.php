<?php 
if (isset($_POST['id']) && !empty($_POST['id'])) {
    require_once 'config.php';
    $sql = 'DELETE FROM employees WHERE id= :id';
    if ($stmt= $pdo->prepare($sql)) {

        $stmt->bindParam(':id', $param_id);
        $param_id = trim($_POST['id']);

        if ($stmt->execute()) {
            header('location: index.php');
            exit();
        } else {
            echo 'Opps! Something went wrong. Try again later!.';
        }
    }
    unset($stmt);
    unset($pdo);
} else {
    if (empty(trim($_GET['id']))) {
        header('location: error.php');
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete </title>
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container pt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Delete Record</h2>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="alert alert-danger fade-in">
                        <input type="hidden" name="id" value="<?php echo trim($_GET['id']); ?>">
                        <p>Are you sure you want to delete this record?</p><br>
                        <p>
                            <input type="submit" value="Yes" class="btn btn-danger">
                            <a href="index.php" class="btn btn-default">NO</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>