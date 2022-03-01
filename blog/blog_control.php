<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HomePage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <?php
        if ((!isset($_POST['title']) || empty($_POST['title'])) || (!isset($_POST['content']) || empty($_POST['content']))) {
            $errorMessage = "Vous devez rentrer un message.";
        } else {
            $title = $_POST['title'];
            $content = $_POST['content'];

            $smst3 = $mysqlClient->prepare("INSERT INTO blog (title, messages, currentDate, id_users) VALUES (:title, :message, now(), :id_users)");
            $smst3->bindParam(':title', $title);
            $smst3->bindParam(':message', $content);
            $smst3->bindParam(':id_users', $_SESSION['IS_LOGGED']);
            $smst3->execute();
        }

        ?>

        <form method="POST" action="./blog.php">
            <div class="mb-3">
                <label for="title" class="form-label">Entrez votre title :</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Entrez votre contenu : </label>
                <textarea type="text" class="form-control" id="content" name="content" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>