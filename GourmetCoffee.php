<?php
//starting session to serialize object
session_start();
//brings into the page once will throw error
require_once("inc_OnlineStoresDB.php");
require_once("class_OnlineStore.php");

//creating $StoreID
$StoreID = "COFFEE";

//protection code
if(class_exists("OnlineStore")){
    if(isset($_SESSION['currentStore'])){
        echo "Unserializing object.<br>";
        $Store = unserialize($_SESSION['currentStore']);
    }else {
        echo "Instantiating new object.<br>";//debug
        //instantiating a new class variable.
        $Store = new OnlineStore();
    }
    //passing in the store id to the function
    $Store->setStoreID($StoreID);

}else{
    //error message setting cvariable to empty.
    $errorMsgs[] = "The <em>OnlineStore</em> class is not available!";
    $Store = Null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Gourmet Coffee</title>
    <script src="modernizr.custom.65897.js"></script>
</head>
<body>
    <h1>Gourmet Coffee</h1>
    <h2>Description goes here</h2>
    <p>Welcome message goes here</p>
    <?php
    $TableName = "inventory";
    //if no error we get something out of the invetory
    if(count($errorMsgs) == 0){
        //geting the store id coffee to display in table
        $SQLstring = "SELECT * FROM $TableName". 
        " WHERE storeID='COFFEE'";
        $QueryResult = $DBConnect->query($SQLstring);
        if(!$QueryResult){
            $errorMsgs[] = "<p>Unable to perform the query.
            <br>". "Error code". $DBConnect->errno. ": ".
            $DBConnect->error. "</p>\n";
        }else{
            echo "<table width='100%'>\n";
            echo "<tr>\n";
            echo "<th>Product</th>";
            echo "<th>Description</th>";
            echo "<th>Price Each</th>";
            echo "</tr>\n";
            while (($row = $QueryResult->fetch_assoc()) !=NULL) {
                echo "<tr><td>". htmlentities($row['name']).
                "</td>\n";
                echo "<td>". htmlentities($row['description']).
                "</td>\n";
                printf("<td>$%.2f</td></tr>\n", $row['price']);
            }
            echo "</table>\n";
            $_SESSION['currentStore'] = serialize($Store);
        }
    }

    //if array count more than 1 foreach through it
    if(count($errorMsgs) > 0){
        //displays all error messages in array line by line
        foreach ($errorMsgs as $msg) {
            echo "<p>". $msg. "</p>\n";
        }
    }
    ?>
</body>
</html>

<!-- close connection -->
<?php
// if(!$DBConnect->connect_error){
//     echo "<p>Closing Database <em>$DBName</em>.</p>\n";
//     $DBConnect->close();
// }

?>