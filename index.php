<script type="text/javascript" src="http://gc.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=BuNXp2XUoTF4KlIIEuUcNUHsv3JbX-AINiAutuK9atGlf3NQmmBNmSH5zRvCBEFG1gWMlCdLNIwXvbnTX4a0KA" charset="UTF-8"></script><?php
// Header with needed variables
$page = "home";
$title = "Homepage";
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
function getData($conn)
{
    $productLine = "";
    $sql = "SELECT * FROM classicmodels.productlines";
    $result = $conn->query($sql);
    $prodLineID = 0;
    echo "<h2>Product Lines</h2><p>Below you can read about our product lines. Click on a heading to get more information about the products in that line.</p><br>";
    if ($result->num_rows > 0)
    {
        // output data of each row
        while ($row = $result->fetch_assoc())
        {
            echo "<h3 class='clickable' onclick=\"showHide('" . 'pLine' . $prodLineID . "');\"><span class='line'><b>" . $row["productLine"] . "</b></span></h4><p>" . $row["textDescription"] . "</p><br>";
            $productLine = $row["productLine"];
            $prodLine = "SELECT * FROM classicmodels.products WHERE productLine='" . $productLine . "'";
            $products = $conn->query($prodLine);
            if ($products->num_rows > 0)
            {
                // output data of each row
                echo "<div class='prodLine'><table id=" . 'pLine' . $prodLineID . " class='hidden'>";
                echo "<thead><tr><th>Product Code</th><th>Name</th><th>Scale</th><th>Vendor</th>
      <th>Description</th><th>Quantity in Stock</th><th>Buy Price</th><th>MSRP</th></tr></thead>";
                while ($row = $products->fetch_assoc())
                {
                    echo "<tr><td>" . $row["productCode"] . "</td><td>" . $row["productName"] . "</td><td>" . $row["productScale"] . "</td><td>" . $row["productVendor"] . "</td><td>" . $row["productDescription"] . "</td><td>" . $row["quantityInStock"] . "</td><td>" . $row["buyPrice"] . "</td><td>" . $row["MSRP"] . "</td></tr>";
                }
                $prodLineID++;
                echo "</table></div><br>";
            }
            else
            {
                echo "0 results";
            }
            echo "<script>window.onload = function(){window.scrollBy(0, -100);}</script>";
        }
    }
}

include "footer.php";
?>