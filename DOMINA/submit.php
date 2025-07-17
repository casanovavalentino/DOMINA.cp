<?php
// Basic sanitization
function sanitize($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

// Collect and validate input
$nom = sanitize($_POST['name']);
$age = intval($_POST['age']);
$kink = sanitize($_POST['kink']);
$description = sanitize($_POST['description']);
$whatsapp = sanitize($_POST['whatsapp']);

$errors = [];

// Validation rules
if ($age < 18) {
  $errors[] = "You must be 18 or older.";
}

if ($kink !== "submissive") {
  $errors[] = "Only 'submissive' is accepted.";
}

if (!preg_match('/^\+?\d{10,15}$/', $whatsapp)) {
  $errors[] = "Invalid WhatsApp number format.";
}

if (strlen($nom) > 30) {
  $errors[] = "Name must be 30 characters or fewer.";
}

if (strlen($description) > 300) {
  $errors[] = "Description must be 300 characters or fewer.";
}

// Handle success or error
if (count($errors) === 0) {
  $entry = "Name: $nom\nAge: $age\nKink: $kink\nDescription: $description\nWhatsApp: $whatsapp\n\n---\n";
  file_put_contents("sub_database.txt", $entry, FILE_APPEND);
  header("Location: thankyou.html");
  exit();
} else {
  echo "<h2>Submission Error</h2>";
  foreach ($errors as $e) {
    echo "<p style='color:red;'>$e</p>";
  }
  echo "<p><a href='join.html'>Go Back</a></p>";
}
?>
