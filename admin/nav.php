<nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a class="nav-link <?= isactive('home.php') ? 'active' : '' ?>" href="home.php">Overview
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= isactive('edit-question.php') ? 'active' : '' ?>" href="edit-question.php">Edit Question</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= isactive('create-question.php') ? 'active' : '' ?>" href="create-option.php">Add Option</a>
        </li>
    </ul>
</nav>