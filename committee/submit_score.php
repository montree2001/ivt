<?php
// Include database connection
include '../conn.php';
session_start();

// Assuming you have included session_start() in your main PHP file

// Get the submitted score data
$committee_id = $_SESSION['user_id'];
$invention_id = $_POST['invention_id']; // Assuming you have an input field for invention_id in your form
$scoring_criteria_id = $_POST['scoring_criteria_id']; // Assuming you have an input field for scoring_criteria_id in your form
$score = $_POST['score']; // Assuming you have an input field for score in your form

// Check if the score should be updated or inserted
$sql_check_vote = "SELECT * FROM vote WHERE committee_id = :committee_id AND invention_id = :invention_id AND scoring_criteria_id = :scoring_criteria_id";
$stmt_check_vote = $pdo->prepare($sql_check_vote);
$stmt_check_vote->bindParam(':committee_id', $committee_id);
$stmt_check_vote->bindParam(':invention_id', $invention_id);
$stmt_check_vote->bindParam(':scoring_criteria_id', $scoring_criteria_id);
$stmt_check_vote->execute();

if ($stmt_check_vote->rowCount() > 0) {
    // Score exists, update it
    $sql_update_score = "UPDATE vote SET score = :score WHERE committee_id = :committee_id AND invention_id = :invention_id AND scoring_criteria_id = :scoring_criteria_id";
    $stmt_update_score = $pdo->prepare($sql_update_score);
    $stmt_update_score->bindParam(':score', $score);
    $stmt_update_score->bindParam(':committee_id', $committee_id);
    $stmt_update_score->bindParam(':invention_id', $invention_id);
    $stmt_update_score->bindParam(':scoring_criteria_id', $scoring_criteria_id);

    if ($stmt_update_score->execute()) {
        // Score updated successfully
        echo "Score updated successfully";

     
    } else {
        // Error occurred while updating score
        http_response_code(500);
        echo "Error occurred while updating score";
    }
} else {
    // Score doesn't exist, insert it
    if ($score !== 'YOUR_NOT_REQUIRED_VALUE') { // Replace 'YOUR_NOT_REQUIRED_VALUE' with the value that indicates score should not be inserted
        $sql_insert_score = "INSERT INTO vote (score, committee_id, invention_id, scoring_criteria_id) VALUES (:score, :committee_id, :invention_id, :scoring_criteria_id)";
        $stmt_insert_score = $pdo->prepare($sql_insert_score);
        $stmt_insert_score->bindParam(':score', $score);
        $stmt_insert_score->bindParam(':committee_id', $committee_id);
        $stmt_insert_score->bindParam(':invention_id', $invention_id);
        $stmt_insert_score->bindParam(':scoring_criteria_id', $scoring_criteria_id);

        if ($stmt_insert_score->execute()) {
            // Score inserted successfully
            echo "Score submitted successfully";
        } else {
            // Error occurred while inserting score
            http_response_code(500);
            echo "Error occurred while submitting score";
        }
    } else {
        // Do nothing if score is not required
        echo "Score not required";
    }
}
?>
