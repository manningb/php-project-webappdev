<?php
// Header with needed variables
$page = "offices";
$title = "Offices";
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
    $sql = "SELECT * FROM classicmodels.offices";
    $result = $conn->query($sql);
    $i = 0;
    if ($result->num_rows > 0)
    {
        echo "<h2>Offices</h2><p>Below you can read about our office locations. Click on the more info button to see information about the employees.</p><br>";

        echo "<div id='tableRows'><div id='tableLeft'><table>";
        echo "<thead><tr><th>City</th><th>Phone</th><th>Address</th><th>Employee Information</th></thead>";
        // output data of each row
        $officeName = [];
        while ($row = $result->fetch_assoc())
        {
            $countAddr = 0;
            echo "<tr>";

            // for loop to allow for address formatting
            foreach ($row as $key => $value)
            {
                $$key = $value;
                if ($key == "officeCode")
                {
                    $officeCode = $value;
                }
                if ($key == "city")
                {
                    echo "<td>" . $value . "</td>";
                    $officeName[$officeCode] = $value;
                }
                elseif ($key == "phone")
                {
                    echo "<td>" . $value . "</td>";
                }
                elseif (in_array($key, array(
                    "addressLine1",
                    "addressLine2",
                    "state",
                    "country",
                    "postalCode",
                    "territory"
                )))
                {
                    if ($countAddr == 0)
                    {
                        $countAddr++;
                        echo "<td>";
                    }
                    if ($value) echo $value . "<br>";
                    if ($key == "territory") echo "</td><td><a href='offices.php?office=" . $officeCode . "'>More Info</a></td>";
                }
            }
            echo "</tr>";
            $i++;
        }
        echo "</table></div>";
    }
    else
    {
        echo "0 results";
    }

    // check if office number set in URL and return employee data if so
    if (isset($_GET['office']))
    {
        // check that the office exists with that number
        if (isset($officeName[$_GET['office']])) {
            $customersql = "SELECT * from classicmodels.employees WHERE employees.officeCode =" . $_GET['office'] . " ORDER BY employees.jobTitle";
            $customerresult = $conn->query($customersql);
            echo "<div id='tableRight'><h3>Office: " . $officeName[$_GET['office']] . "</h3><table>";
            echo "<thead><tr><th>Full Name</th><th>Job Title</th><th>Employee Number</th><th>Email Address</th></tr></thead>";
            while ($row = $customerresult->fetch_assoc())
            {
                echo "<tr><td>" . $row["firstName"] . " " . $row["lastName"] . "</td><td>" . $row["jobTitle"] . "</td><td>" . $row["employeeNumber"] . "</td><td>" . $row["email"] . "</td></tr>";
            }
            echo "</table></div><br>";
        } else {
            echo "<p>Office not found please try again.</p>";
        }
    }
    echo "</div>";
}
include "footer.php";
?>