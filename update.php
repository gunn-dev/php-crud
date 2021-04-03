<?php
require_once 'config.php';
$name = $address = $salary = '';
$name_err = $address_err = $salary_err = '';


if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
    $input_name = trim($_POST['name']);
    $input_address = trim($_POST['address']);
    $input_salary = trim($_POST['salary']);

    if (empty($input_name)) {
        $name_err = 'Please enter a name.';
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP,
        array('options'=>array('regexp'=>'/^[a-zA-Z\s]+$/')))) {
            $name_err = 'Please enter valid name';
    } else {
        $name = $input_name;
    }

    if (empty($input_address)) {
        $address_err = 'Please enter address';
    } else {
        $address = $input_address;
    }

    if (empty($input_salary)) {
        $salary_err = 'Please enter salary amount.';
    } elseif(!ctype_digit($input_salary)) {
        $salary_err = 'Please enter positive integer.';
    } else {
        $salary = $input_salary;
    }

    if (empty($name_err) && empty($address_err) && empty($salary_err)) {
        $sql = 'UPDATE employees SET name=:name, address=:address, salary=:salary WHERE id=:id';

        if ($stmt = $pdo->prepare($sql)) {
            
            $stmt->bindParam(':name', $param_name);
            $stmt->bindParam(':address', $param_address);
            $stmt->bindParam(':salary', $param_salary);
            $stmt->bindParam(':id', $param_id);

            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_id = $id;            

            if ($stmt->execute()) {
                header('location: index.php');
                exit();
            } else {
                echo 'Opps! Something went wrong. Please try again later.';
            }
            unset($stmt);
            unset($pdo);
        } 
    }
} else {
    if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
        $id = trim($_GET['id']);
        $sql = 'SELECT * FROM employees WHERE id = :id';

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':id' , $param_id);
            $param_id = $id;

            if ($stmt->execute()) {

                if($stmt->rowCount() == 1) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $name = $row['name'];
                    $address = $row['address'];
                    $salary = $row['salary'];
                } else {
                    header('location: error.php');
                    exit();
                }
            } else {
                echo 'Opps! Something went wrong. Please try again later.';
            }
        } 
        unset($stmt);
        unset($pdo);
    } else {
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
    <title>Update </title>
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>
<body>  
    <div class="container pt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Update Record</h2>
                </div>
                <p class="text-warning">You can edit record.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
                    <div class="form-group <?php echo(!empty($name_err)) ? 'has-error' : ''; ?>">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo $name; ?>">
                        <span class="help-block text-danger"><?php echo $name_err; ?></span>
                    </div>
                    <div class="form-group <?php echo(!empty($address_err)) ? 'has-error' : ''; ?>">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="form-control"><?php echo $address; ?></textarea>
                        <span class="help-block text-danger"><?php echo $address_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($salary)) ? 'has-error' : ''; ?>">
                        <label for="salary">Salary</label>
                        <input type="number" name="salary" id="salary" class="form-control" value="<?php echo $salary; ?>">
                        <span class="help-block text-danger"><?php echo $salary_err; ?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>