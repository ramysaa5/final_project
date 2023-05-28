<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
include("../conifg/conn.php");
include_once("../class/book.php");


if (isset($_GET['b_id'])) {
    $id = $_GET['b_id'];
    $database = new Database();
    $db = $database->getConnection();
    $item = new Book($db);

    $data = json_decode(file_get_contents("php://input"));
    if ($item->deleteBook($id)) {
        echo json_encode("Book deleted. ");
    } else {
        echo json_encode("Book could not be deleted.");
    }
}

$database = new Database();
$db = $database->getConnection();
$items = new Book($db);
$st = $items->getBook();
$itemCount = $st->rowCount();

echo json_encode($itemCount);
if ($itemCount > 0) {
    $bookArr = array();
    $bookArr['body'] = array();
    $bookArr['itemCount'] = $itemCount;
    $result = $st->ger_result();


    while ($row = $result->fetch_assoc()) {
        $b = array(
            "id" => $row['id'],
            "name" => $row['name'],
            "author" => $row['author'],
            "pages" => $row['pages'],
            "copies" => $row['copies']
        );
    }
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
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
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="page-header">
                                        <h3 class="page-title"> <a href="add.php" class="btn btn-primary">Add New</a>
                                        </h3>
                                        <nav aria-label="breadcrumb">
                                            <input type="text" name="" id="" class="form-control" placeholder="Search">
                                        </nav>
                                    </div>
                                    </p>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Autor</th>
                                                <th>Number of Pages</th>
                                                <th>Number of copies</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            foreach ($bookArr as $book) {
                                                foreach ($book as $ky => $val) {
                                            ?>
                                            <tr>
                                                <td><?php echo $val ?></td>

                                                <td>
                                                    <a href="edit.php?b_id=<?php if ($ke = "id") {
                                                                                        echo $val;
                                                                                    } ?>" class="btn btn-success">
                                                        Update</a>

                                                </td>
                                                <td>
                                                    <a href="index.php?b_id=<?php if ($ke = "id") {
                                                                                        echo $val;
                                                                                    } ?>" class="btn btn-danger">
                                                        Delete</a>
                                                </td>

                                            </tr>
                                            <?php
                                                }
                                            }

                                            ?>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>



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