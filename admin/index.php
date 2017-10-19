<?php
    include 'includes.php';
    
    $admin = new Admin();
    $admin->redirectIfLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <title>Admin / Login</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M"
        crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
</head>

<body>
    <div class="container">
            <div class="row mt-4">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h2>Please Login</h2>
                    <hr>
                </div>
            </div>
            <form action="/admin/login.php" method="post">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group has-danger">
                            <label class="sr-only" for="email">E-Mail Address</label>
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" style="width: 2.6rem">
                                    <i class="fa fa-at"></i>
                                </div>
                                <input type="text" name="username" class="form-control" id="email" value="<?= isset($_SESSION['old']['username']) ? $_SESSION['old']['username'] : ''?>" placeholder="you@example.com" required autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-control-feedback">
                            <?php if (isset($_SESSION['errors'])) :?>
                            <span class="text-danger align-middle">
                                <i class="fa fa-close"></i> <?=$_SESSION['errors']?>
                            </span>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="sr-only" for="password">Password</label>
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" style="width: 2.6rem">
                                    <i class="fa fa-key"></i>
                                </div>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-control-feedback">
                            <span class="text-danger align-middle">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6" style="padding-top: .35rem">
                        <div class="form-check mb-2 mr-sm-2 mb-sm-0">
                            <label class="form-check-label">
                                <input class="form-check-input" name="remember" type="checkbox"  <?= isset($_SESSION['old']['remember']) ? ($_SESSION['old']['remember']? 'checked': '') : '' ?>>
                                <span style="padding-bottom: .15rem">Remember me</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 1rem">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-sign-in"></i> Login</button>
                    </div>
                </div>
            </form>
    </div>
    <?php unset($_SESSION['old']) ?>
    <?php unset($_SESSION['errors']) ?>
    
</body>

</html>