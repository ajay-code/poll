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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M"
    crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="text-center mt-4">
    <h3 >
        <?php echo $pollResult['poll']; ?>
    </h3>
    <p>
        <b>Total Votes:</b>
        <?php echo $pollResult['total_votes']; ?>
    </p>
</div>
    <?php
        $data = ['labels' => [], 'votes' => [], 'colors' => []];
        $barColorArr = array('blue','yellow','violet','green','red', 'pink', 'gray', 'brown');
        
        if (!empty($pollResult['options'])) {
            $i = 0;
            foreach ($pollResult['options'] as $opt => $vote) {
                //Calculate vote percent
                if (!array_key_exists($i, $barColorArr)) {
                    $i=0;
                }
                $data['labels'][] = $opt;
                $data['votes'][] = $vote ? $vote: 0;
                $data['colors'][] = $barColorArr[$i];
                $i++;
            }
        } 
    ?>
    <canvas id="result" ></canvas>

        <a href="index.php" class="ml-2">
            <button class="btn btn-outline-light go-back-button"> Back To Poll</button>
        </a>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
        <script>
            var data = {
                    labels : <?= json_encode($data['labels']) ?>,
                    datasets: [{
                        label: '# of Votes',
                        data: <?= json_encode($data['votes']) ?>,
                        backgroundColor: <?= json_encode($data['colors']) ?>,
                        borderWidth: 1
                    }]
                }
        </script>
        <script src="script.js"></script>
</body>

</html>