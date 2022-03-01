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

        <?php include_once('../global/header2.php'); ?>

        <?php


        $stmt = $mysqlClient->prepare("SELECT id_blog, title, messages, currentDate FROM blog WHERE id_users = :id_users ORDER BY currentDate DESC");
        $stmt->bindParam(':id_users', $_SESSION['IS_LOGGED']);
        $stmt->execute();
        $msg = $stmt->fetchAll();
        ?>



        <a href="blog.php" class="btn btn-primary">Retournez à votre blog.</a>
        <?php if (isset($msg[0])) : ?>
            <?php foreach ($msg as $i) : ?>
                <?php $comment = $i["id_blog"]; ?>
                <h3><?php echo $i['title']; ?></h3>
                <p><?php echo $i['messages']; ?></p>
                <p><?php echo $i['currentDate']; ?></p>
                <form method="post">
                    <input name="writeComment" placeholder="Ecrivez un commentaire...">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
                <hr>
            <?php endforeach ?>
        <?php else : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo "Vous n'avez pas encore écrit de messages."; ?>
            </div>
        <?php endif; ?>
        <?php include_once('../global/footer.php'); ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>