<?php
class OnlineStore{
    //declaring private variables
    private $DBConnect = NULL;
    private $DBName = "";
    private $storeID = "";
    private $inventory = array();
    private $shoppingCart = array();

    //will start working first
    //can be called constructor or name of class
    function __construct(){
        //grabing the file
        include("inc_OnlineStoresDB.php");
        $this->DBConnect = $DBConnect;
        $this->DBName = $DBName;
    }

    //will get called when script ends
    //named specifically
    function  __destruct(){
        echo "<p>Closing database ". 
        "<em>$this->DBName</em>.</p>\n";
        $this->DBConnect->close();
    }

    // starts to work after unserialized
    function __wakeup(){
        include("inc_OnlineStoresDB.php");
        $this->DBConnect = $DBConnect;
        $this->DBName = $DBName;
    }

    public function setStoreID($storeID){
       if($this->storeID != $storeID){
        $this->storeID = $storeID;
        $TableName = "inventory";
        $SQLstring = "SELECT * FROM $TableName".
        " WHERE storeID='". $this->storeID.
        "'";
        $QueryResult = $this->DBConnect->query($SQLstring);
            if(!$QueryResult){
                echo "<p>Unable to perform the query.
                <br>". "Error code". 
                $this->DBConnect->errno. ": ".
                $this->DBConnect->error. "</p>\n";
                $this->storeID = "";
            }else{
                $inventory = array();
                $shoppingCart = array();
                while(($row = $QueryResult->fetch_assoc()) != NULL){
                    $this->inventory[$row['productID']] = array();
                    $this->inventory[$row['productID']]['name'] = $row['name'];
                    $this->inventory[$row['productID']]['description'] = $row['description'];
                    $this->inventory[$row['productID']]['price'] = $row['price'];
                    $this->shoppingCart[$row['productID']] = 0;
                }
echo "<pre>\n";
print_r($this->inventory);
print_r($this->shoppingCart);
echo "</pre>\n";
            }
       }
    }
}


?>