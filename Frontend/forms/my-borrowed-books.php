<?php



class borrowedbooks{
    public function retrieveborrowedbooks(){

    }
}


try {
    $borrowedbooks = new borrowedbooks;
} catch (\Throwable $th) {
    echo 'Class called does not exist: ' . $th->getMessage();
    exit;
}

try {
    $borrowedbooks->retrieveborrowedbooks();
} catch (\Throwable $th) {
    echo 'Function called does not exist: ' . $th->getMessage();
    exit;
}

?>