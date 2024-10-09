<?php

// Database configuration
$host = 'localhost'; 
$username = 'root';
$password = ''; 
$dbName = 'booklendingDB'; 
set_time_limit(1000); 


try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

  // Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $memberId = $_POST['member_id'];
    $bookId = $_POST['book_id'];
    $bookTitle = $_POST['book_title'];
    $bookAuthor = $_POST['book_author'];
    $bookIsbn = $_POST['book_isbn_no'];
    $bookCopyNo = $_POST['book_copy_no'];
    $borrowdate = $_POST['borrow_date'];
    $returnDate = $_POST['return_date'];
    $suggestedReason = $_POST['suggested_reason'];
    

    try {
        $pdo->beginTranscation();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM members WHERE member_id =:member_id");
        $stmt->execute(['member_id'=>$memberId]);


        if($stmt->fetchColumn() == 0){
            throw new exception('Member Does Not Exist');
        }

        $stmt = $pdo->prepare("SELECT available_copies FROM books where book_id=:book_id");
        $stmt->execute(["book_id"=>$book_id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$book){
            throw new Exception("Book Does Not Exist");
        } elseif($book['available_copies']<=0){
            throw new Exception("No available copies for this book");
        }

        $stmt = $pdo->$prepare("INSERT INTO Lending(book_id,book_title,book_author,book_isbn_no,book_copy_no,
        borrow_date,return_date,suggested_reason)
         VALUES(:book_id,:book_title,:book_author,:book_isbn_no,:book_copy_no,
        :borrow_date,:return_date,:suggested_reason)");

        $stmt->execute(['book_id'=>$book_id,
                        'book_title'=>$bookTitle,
                        'book_author'=>$bookAuthor,
                        'book_isbn_no'=>$bookIsbn,
                        'book_copy_no'=>$bookCopyNo,
                        'borrow_date'=>$borrowdate,
                        'return_date'=>$returnDate,
                        'suggested_reason'=>$suggestedReason
        ]);
        $stmt = $pdo->prepare('UPDATE books SET available_copies = available_copies -1  WHERE book_id :book_id');
        $stmt->execute(['book_id'=>$book_id]);

        $pdo->commit();

        echo "Book borrowed successfully!";

    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }


}

?>