<?php
header("Content-Type: application/json; charset=UTF-8");

include("../conifg/conn.php");
include_once("../class/book.php");
include_once("index.php");







if (isset($_GET['b_id'])) {
    $id = $_GET['b_id'];

    $database = new Database();
    $db = $database->getConnection();
    $item = new Book($db);

    $item->getSingleBook($id);
    if ($item->name != null) {
        // create array
        // $emp_arr = array(
        //     "id" =>  $item->id,
        //     "name" => $item->name,
        //     "email" => $item->email,
        //     "age" => $item->age,
        //     "designation" => $item->designation,
        //     "created" => $item->created
        // );

        http_response_code(200);
        echo json_encode($emp_arr);
    } else {
        http_response_code(404);
        echo json_encode("book not found.");
    }


    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $author = $row['author'];
        $pages = $row['pages'];
        $copies = $row['copies'];
    }
}

$name_error = "";
$author_error = "";
$pages_error = "";
$copies_error = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['update'])) {

        $name = $_POST['name'];
        $author = $_POST['author'];
        $copies = $_POST['copies'];
        $pages = $_POST['pages'];
        $success = true;

        if (empty($name)) {
            $name_error = "name is requaired";
            $success = false;
        }
        if (empty($author)) {
            $author_error = "author is requaired";
            $success = false;
        }
        if (empty($pages)) {
            $pages_error = "pages is requaired";
            $success = false;
        }
        if (empty($copies)) {
            $copies_error = "copies is requaired";
            $success = false;
        }
        if ($success) {

            $database = new Database();
            $db = $database->getConnection();

            $item = new Book($db);

            $data = json_decode(file_get_contents("php://input"));

            if ($item->updateBook($id, $name, $author, $pages, $copies)) {
                echo json_encode("Employee data updated.");
                $name = "";
                $author = "";
                $pages = "";
                $copies = "";
            } else {
                echo json_encode("Data could not be updated");
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Library Managments</title>
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            <div class="" style="width: 100%;">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-4 grid-margin stretch-card"> </div>
                        <div class="col-md-4 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Update New Book </h4>
                                    <form class="forms-sample" method="post">
                                        <div class="form-group">
                                            <label>name</label>
                                            <input type="text" class="form-control" placeholder="Book name" name="name" value="<?php echo $name  ?>">
                                            <p class="error"> <?php echo $name_error  ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Author</label>
                                            <input type="text" class="form-control" placeholder="Book author" name="author" value="<?php echo $author  ?>">
                                            <p class="error"><?php echo $author_error  ?></p>

                                        </div>

                                        <div class="form-group">
                                            <label>Number of pages</label>
                                            <input type="number" class="form-control" placeholder="Book pages" name="pages" value="<?php echo $pages  ?>">
                                            <p class="error"><?php echo $pages_error  ?></p>

                                        </div>

                                        <div class="form-group">
                                            <label>Number of copies</label>
                                            <input type="number" class="form-control" placeholder="Book copies" name="copies" value="<?php echo $copies  ?>">
                                            <p class="error"><?php echo $copies_error  ?></p>

                                        </div>
                                </div>
                                <input type="submit" value="Update" name="update" class="btn btn-gradient-success me-2">
                                <a href="index.php" class="btn btn-light">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card"> </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
</body>

</html>