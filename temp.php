<?php
//Include and initialize Poll class 
include 'classes/Poll.php';
$poll = new Poll;

//Get poll result data
$pollResult = $poll->getResult($_GET['pollID']);
if (!$pollResult['total_votes']) {
    header('LOCATION: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h3>
        <?php echo $pollResult['poll']; ?>
    </h3>
    <p>
        <b>Total Votes:</b>
        <?php echo $pollResult['total_votes']; ?>
    </p>
    <?php
    if (!empty($pollResult['options'])) {
        $i=0;
        //Option bar color class array
        $barColorArr = array('blue','yellow','violet','green','red', 'pink', 'gray', 'brown');
        //Generate option bars with votes count
        foreach ($pollResult['options'] as $opt => $vote) {
            //Calculate vote percent
            $votePercent = round(($vote/$pollResult['total_votes'])*100);
            $votePercent = !empty($votePercent)?$votePercent.'%':'0%';
            //Define bar color class
            if (!array_key_exists($i, $barColorArr)) {
                $i=0;
            }
            $barColor = $barColorArr[$i];
    ?>
        <div class="bar-main-container <?php echo $barColor; ?>">
            <div class="txt">
                <?php echo $opt; ?>
            </div>
            <div class="wrap">
                <div class="bar-percentage">
                    <?php echo $votePercent; ?>
                </div>
                <div class="bar-container">
                    <div class="bar" style="width: <?php echo $votePercent; ?>;"></div>
                </div>
            </div>
        </div>
        <?php $i++;
        }
    } ?>
        <a href="index.php">Back To Poll</a>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
        <script>
            var data = {
                
            }
        </script>
        <script src="script.js"></script>
</body>

</html>