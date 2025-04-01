<?php
require_once("Models/Product.php");
require_once("components/HeadLinks.php");
require_once("components/HeaderNav.php");
require_once("components/Footer.php");
require_once("Models/Database.php");


$dbConnection = new Database();

$sortColumn = $_GET['sortColumn'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
        <?php HeadLinks()?>
    </head>
    <body>
        <!-- Navigation-->
        <?php HeaderNav()?>
        <!-- Section-->
        <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <a href="/admin/new" class="btn btn-primary">Create new</a>
            <table class="table">
                <thead>
                        <th>Name
                            <a href="admin?sortColumn=title&sortOrder=asc">
                                <i class="bi bi-arrow-down-circle-fill"></i>
                            </a>
                            <a href="admin?sortColumn=title&sortOrder=desc">
                                <i class="bi bi-arrow-up-circle-fill"></i>
                            </a>
                        </th>
                        <th>Category
                            <a href="admin?sortColumn=categoryName&sortOrder=asc">
                                <i class="bi bi-arrow-down-circle-fill"></i>
                            </a>
                            <a href="admin?sortColumn=categoryName&sortOrder=desc">
                                <i class="bi bi-arrow-up-circle-fill"></i>
                            </a>
                        </th>
                        <th>Price
                            <a href="admin?sortColumn=price&sortOrder=asc">
                                <i class="bi bi-arrow-down-circle-fill"></i>
                            </a>
                            <a href="admin?sortColumn=price&sortOrder=desc">
                                <i class="bi bi-arrow-up-circle-fill"></i>
                            </a>
                        </th>
                        <th>Stock level
                            <a href="admin.php?sortColumn=stockLevel&sortOrder=asc">
                                <i class="bi bi-arrow-down-circle-fill"></i>
                            </a>
                            <a href="admin.php?sortColumn=stockLevel&sortOrder=desc">
                                <i class="bi bi-arrow-up-circle-fill"></i>
                            </a>
                        </th>
                        <th>Action</th>
                </thead>
                <tbody>
                    <?php foreach($dbConnection->getAllProducts($sortColumn, $sortOrder) as $prod) { ?>
                    <tr>
                        <td><?php echo $prod->title; ?></td>
                        <td><?php echo $prod->categoryName; ?></td>
                        <td><?php echo $prod->price; ?></td>
                        <td><?php echo $prod->stockLevel; ?></td>
                        <td><a href="/admin/edit?id=<?php echo $prod->id; ?>" class="btn btn-primary">Edit</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        </section>
        <!-- Footer-->
        <?php Footer()?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
