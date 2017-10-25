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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="/style.css">
</head>

<body>
 
    <div class="container">
    <h3 class="text-center"><?php echo $pollData['poll']['title']; ?></h3>
        <div class="row   justify-content-center">
            <div class="col-8">
                <div class="row justify-content-center">
                <?php foreach ($pollData['options'] as $opt) :?>
                    <div class=" col-10 col-sm-3 text-center mt-3">
                        <?php if(file_exists($opt['img'])): ?>
                        <img src="<?= $opt['img'] ?>" alt="" class="img-fluid">
                        <?php else :?>
                        <img src="/img/dummy.png" alt="" class="img-fluid">
                        <?php endif?>
                        <br>
                        <span><?= $opt['name'] ?></span>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>

        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-sm-8 text-center">
                <p><?php echo $pollData['poll']['subject']; ?></p>
            </div>
            <?php if (!isset($_COOKIE['1'])) : ?>
                <form method="post">
                <input type="hidden" name="pollID" value="<?= $pollData['poll']['id'] ?>">
                    <div class="row justify-content-center">
                    <div class="col-8">
                        <div class="row">
                        <?php foreach ($pollData['options'] as $opt) :?>
                            <div class="col-6 col-sm-4 col-md-3 ">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="voteOpt"  value="<?= $opt['id'] ?>"> <?= $opt['name'] ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div> 
                    </div>
                    <div class="text-center mt-4">
                        <button class="btn btn-success btn-outline-light pr-4 pl-4 submit-button" name="voteSubmit">Submit</button>
                    </div>
                </form>
            <?php else : ?>
                    
                <div class="col-12 text-center mt-4">
                    <a href="/results.php?pollID=1">
                        <button class="btn button pr-4 pl-4 submit-button" name="voteSubmit">Results</button>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
    </div>

</body>

</html>