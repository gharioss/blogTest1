<?php session_start(); ?>
<?php include_once('../global/variable.php'); ?>
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

        if (isset($_POST['th-anime'])) {
            $_SESSION['theme'] = 'thanime';
        } elseif (isset($_POST['th-msg'])) {
            $_SESSION['theme'] = 'messages';
        }
        if (isset($_POST["5"])) {
            $limit = (int)5;
        } elseif (isset($_POST["10"])) {
            $limit = (int)10;
        } elseif (isset($_POST["15"])) {
            $limit = (int)15;
        } else {
            $limit = (int)100;
        }
        $stmt = $mysqlClient->prepare("SELECT messages, currentDate FROM $_SESSION[theme] WHERE id_users = :id_users ORDER BY currentDate DESC LIMIT $limit");
        $stmt->bindParam(':id_users', $_SESSION['IS_LOGGED']);
        $stmt->execute();
        $msg = $stmt->fetchAll();
        ?>

        <form method="post">
            <input type="submit" name="th-msg" value="message normal">
            <input type="submit" name="th-anime" value="theme anime">
        </form>
        <form method="post">
            <input type="submit" name="5" value="5">
            <input type="submit" name="10" value="10">
            <input type="submit" name="15" value="15">
        </form>
        <a href="../messages/messages.php" class="btn btn-primary">Retournez à vos messages.</a>
        <?php if (isset($msg[0])) : ?>
            <?php foreach ($msg as $i) : ?>
                <h3><?php echo $i['currentDate']; ?></h3>
                <p><?php echo $i['messages']; ?></p>
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