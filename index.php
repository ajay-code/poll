<?php
        include 'classes/Poll.php';
        $poll = new Poll();
        include 'vote.php';
        $pollData = $poll->getPolls();
?>   
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Question</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M"
        crossorigin="anonymous">
    <link rel="stylesheet" href="/style.css">
</head>

<body>
 
    <div class="container">
    <h3 class="text-center"><?php echo $pollData['poll']['subject']; ?></h3>
        <div class="row   justify-content-center">
            <div class="col-10">
                <div class="row justify-content-center">
                <?php foreach ($pollData['options'] as $opt) :?>
                    <div class=" col-10 col-sm-3 text-center mt-3">
                        <img src="/img/dummy.png" alt="" class="img-fluid">
                        <span><?= $opt['name'] ?></span>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>

        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-sm-8">
                <p>Exercitation nisi qui voluptate aliqua ipsum irure aliquip proident laborum adipisicing laborum.</p>
                <form method="post">
                <input type="hidden" name="pollID" value="<?= $pollData['poll']['id'] ?>">
                    <div class="row">
                        <?php foreach ($pollData['options'] as $opt) :?>
                            <div class="col-6 col-sm-4 col-md-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="voteOpt"  value="<?= $opt['id'] ?>"> <?= $opt['name'] ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-center mt-4">
                        <button class="btn btn-success btn-outline-light pr-4 pl-4 submit-button" name="voteSubmit">Submit</button>
                    </div>
                </form>

            </div>
        </div>
        
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
        crossorigin="anonymous"></script>
    <script src="/script.js"></script>
</body>

</html>