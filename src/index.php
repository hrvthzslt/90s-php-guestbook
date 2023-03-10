<?php

$firstNumber = rand(0, 10);
$secondNumber = rand(0, 10);
$checkResult = $firstNumber + $secondNumber;

if (validateInput($_POST)) {
    if (poorMansCapthca($_POST['first_number'], $_POST['second_number'], $_POST['check'])) {
        addEntry($_POST['name'], $_POST['message']);
        header('Location: /');
        exit;
    } else {
        echo "You didn't say the magic word!";
    }
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>90s PHP Guestbook</title>
    </head>
    <body>
    <h1>90s PHP Guestbook</h1>
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name"/>
        <label for="message">Message:</label>
        <input type="text" name="message" id="message"/>
        <label for="check"><?= $firstNumber ?> + <?= $secondNumber ?></label>
        <input type="text" name="check" id="check"/>
        <input type="hidden" name="first_number" value="<?= $firstNumber ?>">
        <input type="hidden" name="second_number" value="<?= $secondNumber ?>">
        <input type="submit" value="Submit"/>
    </form>
    <table border="1">
        <!-- ENTRIES -->
        <tr>
            <td>John Doe</td>
            <td>Hi, this is my first message!</td>
            <td>2023-01-01 01:01:01</td>
        </tr>
    </table>
    </body>
    </html>

<?php
function addEntry(string $name, string $message): void
{
    $name = strip_tags($name);
    $message = strip_tags($message);
    $entry = "
        <tr>
            <td>$name</td>
            <td>$message</td>
            <td>" . date('Y-m-d H:i:s') . "</td>
        </tr>
    ";
    $content = file_get_contents('index.php');
    $pattern = '<!-- ENTRIES -->';
    $content = preg_replace('/' . $pattern . '/', $pattern . $entry, $content, 1);
    file_put_contents('index.php', $content);
}

function poorMansCapthca(int $firstNumber, int $secondNumber, int $result): bool
{
    return $firstNumber + $secondNumber === $result;
}

function validateInput(array $post): bool
{
    return !empty($post['name']) && !empty($post['message']) && !empty($post['check']);
}
?>

