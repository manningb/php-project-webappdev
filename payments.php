<?php
// Header with needed variables
$page = "payments";
$title = "Payments";
include "header.php";

// Login details
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR;
try
{
    $conn = mysqli_connect($servername, $username, $password);
    getData($conn);
    $conn->close();
}
catch(mysqli_sql_exception $e)
{
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
    include "404.html";
}

// get last 20 payment info
function getData($conn)
{
    $sql = "SELECT * from classicmodels.payments ORDER BY paymentDate DESC LIMIT 20";
    $result = $conn->query($sql);
    $i = 0;
    if ($result->num_rows > 0)
    {
        echo "<h2>Payments</h2><p>Below you can read the last 20 payments. Click on a customer number to get more information about that customer.</p><br>";

        echo "<div id='tableRows'><div id='tableLeft'> <table>";
        echo "<thead><tr><th>Customer Number</th><th>Check Number</th><th>Payment Date</th><th>Amount</th></tr></thead>";
        // output data of each row
        while ($row = $result->fetch_assoc())
        {
            echo "<tr><td><a href='payments.php?customer=" . $row["customerNumber"] . "'>" . $row["customerNumber"] . "</a></td><td>" . $row["checkNumber"] . "</td><td>" . $row["paymentDate"] . "</td><td>" . $row["amount"] . "</td></tr>";
        }
        echo "</table></div>";
    }

    // check if customer number set in URL and that its not empty
    if (isset($_GET['customer']) && !empty($_GET['customer']))
    {
        $customerdetails = "SELECT * from classicmodels.customers WHERE customerNumber =" . $_GET['customer'] . " LIMIT 0,1";
        $customerdetailsresults = $conn->query($customerdetails);
        // check that customer exists
        if ($customerdetailsresults->num_rows > 0) {
        echo "<div id='tableRight'><h3 style='text-align:center'>Customer: " . $_GET['customer'] . "</h3><ul>";

        echo "<table>";
        echo "<thead><tr><th>Phone</th><th>Sales Rep ID</th><th>Credit Number</th></tr></thead>";
        while ($row = $customerdetailsresults->fetch_assoc())
        {
            echo "<tr><td>" . $row["phone"] . "</td><td>" . $row["salesRepEmployeeNumber"] . "</td><td>" . $row["creditLimit"] . "</td></tr>";
        }

        // get data for customer number
        $customersql = "SELECT * from classicmodels.payments INNER JOIN classicmodels.customers ON payments.customerNumber = customers.customerNumber WHERE payments.customerNumber =" . $_GET['customer'] . " ORDER BY paymentDate DESC";
        $customerresult = $conn->query($customersql);
        $total = 0;
        echo "<table>";
        echo "<thead><tr><th>Check Number</th><th>Payment Date</th><th>Amount</th></tr></thead>";
        while ($row = $customerresult->fetch_assoc())
        {
            echo "<tr><td>" . $row["checkNumber"] . "</td><td>" . $row["paymentDate"] . "</td><td>" . number_format($row["amount"], 2, '.', ',') . "</td></tr>";
            $total += floatval($row["amount"]);
        }
        echo "<tr><td></td><td></td><td></td></tr><tr><td></td><td><b>Total Amount</b></td><td>" . number_format($total, 2, '.', ',') . "</td></tr>";
        echo "</table></div>";
    } else {
        echo "<p>Customer not found please try again.</p>";
    }
    }
    echo "</div>";
}
include "footer.php";
?>