<?php
include "connection.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
        header("location: login.php");
        exit;
} else {

$showalert = false;
$showError = false;

// Query for Invoice Number 
$sql_Invoice = "SELECT invoice_id FROM `total_invoices` ORDER BY invoice_id DESC;";
$run_Invoice = mysqli_query($conn, $sql_Invoice);
$invoice_row = mysqli_fetch_assoc($run_Invoice);
$invoice_number = $invoice_row['invoice_id'];
$invoice_no = $invoice_number + 1;


if (isset($_POST['submit'])) {
    $card_no = $_POST['card_no'];

    // Check card value first
    $existAmount = "SELECT card_amount FROM `account_table` WHERE account_no='$card_no'";
    $amountResult = mysqli_query($conn, $existAmount);
    $num_rows = mysqli_num_rows($amountResult);
    if ($num_rows == 1) {
        $row = mysqli_fetch_assoc($amountResult);
        // Card Amount from database
        $amount = $row['card_amount'];
        // Total amount of invoice
        $t_amount = $_POST['t_amount'];

        // Item id,name,desc,price,quantity,total
        $id = $_POST['id'];
        $item = $_POST['item'];
        $desc = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $total = $_POST['total'];

        // Checking that card value is greater than or equal to the total amount
        if ($amount >= $t_amount) {
            //         // Subtracting the total amount from card amount and updating it
            $remaining = $amount - $t_amount;
            $update = "UPDATE `account_table` SET `card_amount`='$remaining' WHERE account_no='$card_no'";
            $run = mysqli_query($conn, $update);
            if ($run) {
                // Inserting in total_invoice table for invoice id
                $invoice = "INSERT INTO `total_invoices` (`invoice_id`,`customer_account`,`total_amount`) VALUES('$invoice_no','$card_no','$t_amount')";
                $invoice_result = mysqli_query($conn, $invoice);
                if ($invoice_result) {
                    foreach ($id as $index => $ids) {
                        // Inserting total items in invoice_table
                        $sql = "INSERT INTO `invoice_table` (`invoice_id`,`item_id`,`item_name`,`description`,`price`,`quantity`,`total`) VALUES ('$invoice_no','$ids','$item[$index]','$desc[$index]','$price[$index]','$quantity[$index]','$total[$index]')";
                        $result = mysqli_query($conn, $sql);
                    }
                    if ($result) {
                        $showalert = true;
                    }
                }
            } else {
                $show = "Data is not submitted";
                $showError = true;
            }
        } else {
            $show = "Card Amount is less than total amount";
            $showError = true;
        }
    }
}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Accounts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/invoice.css" />
    <!-- Font Awesome Cdn Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body>
    <!-- navbar -->
    <form action="invoice.php" method="POST">
        <header class="header">
            <div class="logo">
                <a href="#">SUS</a>
                <div class="search_box">
                    <input type="text" placeholder="Search">
                    <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
        </header>
        <!-- alert -->
        <?php
        if ($showalert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Congratulations!</strong>Data has been submitted.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
        if ($showError) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Sorry!</strong>' . $show . '.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
        ?>
        <div class="s_container">
            <nav>
                <!-- sidebar -->
                <div class="side_navbar">
                    <span>Main Menu</span>
                    <a href="all_card.php" class="active">Billing</a>

                    <div class="links">
                        <span>User Menu</span>
                        <a href="#">Profile</a>
                        <a href="#">Change Password</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </nav>

            <div class="main-body">
                <h2>Accounts</h2>
                <div class="promo_card">
                    <ul class="text-center">
                        <li><h5>Cafeteria System</h5></li>
                    </ul>
                </div>

                <div class="table-info">
                    <article class="py-2">
                        <h1>Recipient</h1>
                        <table class="Recipient">
                            <tr>
                                <th> STUDENT NAME</th>
                                <td><input type="text" id="name" class="border-0 student_info" disabled> </td>
                            </tr>
                            <tr>
                                <th> REGISTRATION NO</th>
                                <td><input type="text" id="rollno" class="border-0 student_info" disabled> </td>
                            </tr>
                            <tr>
                                <th> PHONE NUMBER</th>
                                <td><input type="text" id="pno" class="border-0 student_info" disabled> </td>
                            </tr>
                            <!-- <tr>
                                                                        <th> Payment Method</th>
                                                                        <td> <select name="payment_method" id="" class="form-select border-0">
                                                                                        <option value="" disabled selected>Select</option>
                                                                                        <option value="">Card</option>
                                                                                        <option value="">Cash</option>
                                                                                </select></td>
                                                                </tr> -->
                        </table>
                        <table class="meta">
                            <tr>
                                <th>Invoice #</span></th>
                                <td><input type="text" value="<?php echo $invoice_no; ?>" class="student_info" disabled></span></td>
                            </tr>
                            <tr>
                                <th>Date</span></th>
                                <td><?php echo date("d/m/Y"); ?></td>
                            </tr>
                            <tr>
                                <th>Card No</span></th>
                                <td><input type="password" class="border-0 student_info" name="card_no" id="card_no"  required> </td>
                            </tr>

                        </table>
                        <table class="inventory pt-3">
                            <thead>
                                <tr>
                                    <th>Id</span></th>
                                    <th>Item</span></th>
                                    <th>Description</span></th>
                                    <th>Price</span></th>
                                    <th>Quantity</span></th>
                                    <th>Total</span></th>
                                </tr>
                            </thead>
                            <tbody id="Tbody">

                                <tr id="Trow_1">
                                    <td><a class="cut">-</a><input type="text" class="form-control border-0" name="id[]" id="id_1" onkeyup="BtnCheck(this)"></td>
                                    <td><input type="text" class="form-control border-0" name="item[]" id="item_1"></td>
                                    <td><input type="text" class="form-control border-0" name="description[]" id="description_1"></td>
                                    <td><input type="text" class="form-control border-0" name="price[]" id="price_1"></td>
                                    <td><input type="number" class="form-control border-0" value="1" name="quantity[]" id="quantity_1" onchange="calc(this)"></td>
                                    <td><input type="text" class="form-control border-0" name="total[]" id="total_1"></td>
                                </tr>
                            </tbody>
                        </table>
                        <a class="add" onclick="BtnAdd()">+</a>

                        <table class="balance">
                            <tr>
                                <th><span contenteditable>Total</span></th>
                                <td><input type="text" class="form-control border-0" name="t_amount" id="t_amount"></td>
                            </tr>
                            <!-- <tr>
                                                                        <th><span contenteditable>Amount Paid</span></th>
                                                                        <td><span data-prefix>Rs.</span><span contenteditable>0.00</span></td>
                                                                </tr>
                                                                <tr>
                                                                        <th><span contenteditable>Balance Due</span></th>
                                                                        <td><span data-prefix>Rs.</span><span>600.00</span></td>
                                                                </tr> -->
                            <tr>
                                <td class=" border-0"></td>
                                <td class="border-0"><input type="submit" name="submit" id="submit" class="btn btn-primary"></td>
                            </tr>
                        </table>
                    </article>

                </div>
            </div>


            <div class="sidebar">


            </div>
        </div>
    </form>
    <script src="js/jquery.js"></script>
    <script src="js/invoice.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>