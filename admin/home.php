<?php

include 'includes.php';

$admin = new Admin();
$admin->redirectIfNotLoggedIn();

$pollData = $admin->getPolls();

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Admin / Dashboard </title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M"
            crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Custom styles for this template -->
        <link href="dashboard.css" rel="stylesheet">
    </head>

    <body>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="home.php">Dashboard</a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <div class="ml-auto">

                    <a href="logout.php ">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button>
                    </a>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <?php include 'nav.php'?>

                <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
                    <h1>Dashboard</h1>

                    <section class="row ml-4 placeholders">
                        <div class="placeholder">
                            <h4>Poll</h4>
                            <h5>Title:
                                <?= $pollData['poll']['title'] ?>
                            </h5>
                            <h5>Question:
                                <?= $pollData['poll']['subject'] ?>
                            </h5>
                        </div>
                    </section>

                    <h2>Options</h2>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Created</th>
                                    <th>Modified</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1 ?>
                                <?php foreach ($pollData['options'] as $opt) : ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $opt['name'] ?></td>
                                    <td><?= $opt['img'] ?></td>
                                    <td><?= $opt['created'] ?></td>
                                    <td><?= $opt['modified'] ?></td>
                                    <td>
                                    <a href="edit-option.php?optionID=<?= $opt['id'] ?>"><i class="fa fa-edit"></i></a>
                                    <a href="delete-option.php?optionID=<?= $opt['id'] ?>"><i class="fa fa-trash text-danger"></i></a>
                                    </td>
                                    <?php $i++ ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>

        <!-- Bootstrap core JavaScript
    ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
            crossorigin="anonymous"></script>
    </body>

    </html>