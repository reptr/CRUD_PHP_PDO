<?php require_once('./includes/header.php') ?>

<body>
    <div class="container">
        <div class="col-md-12">
            <h2 class="mt-5">Data Users</h2>
            <hr class="my-4">
            <div class="row mt-2">
                <div class="col-md-5">
                    <?php

                    if (isset($_POST['addNewUser'])) {
                        $userName  = trim($_POST['username']);
                        $userEmail = trim($_POST['email']);
                        $userPass  = 'SECRET';

                        if (empty($userName)||empty($userEmail)) {
                            $error_Msg = true;
                        } else {
                            // add user
                            $sql = 'INSERT INTO users (user_name, user_email, user_password) VALUES (:name, :email, :password)';
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([
                                ':name' => $userName,
                                ':email' => $userEmail,
                                ':password' => $userPass
                            ]);
                            header('location:index.php');
                        }
                    }

                ?>
                    <?php echo isset($error_Msg) ? "<div class='alert alert-danger'>field can't be blank !</div>":" ";  ?>
                    <form class="form-group" action="./index.php" method="POST">
                        <input type="text" class="form-control" placeholder="Username" name="username">
                        <br>
                        <input type="text" class="form-control" placeholder="Email Address" name="email">
                        <br>
                        <button type="submit" class="form-control btn btn-secondary" name="addNewUser">Add New User</button>

                    </form>
                </div>
                <div class="col-md-7">
                    <table class="table py-5">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = 'SELECT * FROM users';
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $user_id    = $users['user_id'];
                                    $user_name  = $users['user_name'];
                                    $user_email = $users['user_email'];
                            ?>
                                    <tr>
                                        <th><?= $user_id ?></th>
                                        <td><?= $user_name ?></td>
                                        <td><?= $user_email ?></td>
                                        <td>
                                            <form action="edit-user.php" method="POST">
                                                <input type="hidden" value="<?= $user_id ?>" name="val">
                                                <input type="submit" class="btn btn-link" value="Edit" name="submit">
                                            </form>
                                        </td>
                                        <td>
                                            <form action="index.php" method="POST">
                                                <input type="hidden" value="<?= $user_id ?>" name="val">
                                                <input type="submit" class="btn btn-link" value="Delete" name="submit">
                                            </form>
                                        </td>
                                    </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php
                        if (isset($_POST['submit'])) {
                            $id = $_POST['id'];

                            $sql = 'DELETE FROM users WHERE user_id = :id';
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([
                                ':id' => $id
                            ]);
                            header('location:index.php');
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('./includes/footer.php') ?>