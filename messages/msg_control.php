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
        if (isset($_POST['th-anime'])) {
            $_SESSION['theme'] = 'thanime';
        } elseif (isset($_POST['th-msg'])) {
            $_SESSION['theme'] = 'messages';
        }
        if ((!isset($_POST['message']) || empty($_POST['message']))) {
            $errorMessage = "Vous devez rentrer un message.";
        } else {
            $msg = $_POST['message'];
            $succesMessage = "Vous avez bien enregistré un message dans le theme :" . $_SESSION['theme'];

            $smst3 = $mysqlClient->prepare("INSERT INTO $_SESSION[theme] (messages, currentDate, id_users) VALUES (:message, now(), :id_users)");
            // $smst3->bindParam(':theme',$_SESSION['theme']);
            $smst3->bindParam(':message', $msg);
            $smst3->bindParam(':id_users', $_SESSION['IS_LOGGED']);
            $smst3->execute();
        }
        ?>
        <form method="post">
            <input type="submit" name="th-msg" value="message normal">
            <input type="submit" name="th-anime" value="theme anime">
        </form>
        <form method="POST" action="./messages.php">
            <?php if (isset($errorMessage)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorMessage; ?>
                </div>
            <?php else : ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $succesMessage; ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="message">Put your message here !</label>
                <textarea class="form-control" name="message" id="message" rows="3"></textarea>
            </div>
            <button class="btn btn-primary">Envoyer</button>
        </form>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>