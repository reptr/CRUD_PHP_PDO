<?php require_once('./includes/header.php') ?>
<body>
    <div class="container">
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            header("Location:index.php");
        } else {
            $id = $_POST['val'];
            $sql = "SELECT * FROM users WHERE user_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id' => $id
            ]);

            if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user_id = $user['user_id'];
                $user_name = $user['user_name'];
                $user_email = $user['user_email'];
                $user_password = $user['user_password'];
            }
        }
        ?>
        <h2 class="pt-4">User Update</h2>
        <?php

        if (isset($_POST['updateUser'])) {
            $user_id = $_POST['val'];
            $user_name = trim( $_POST['username']);
            $user_email = trim($_POST['email']);
            $user_password = trim($_POST['password']);

            if (empty($user_name) || empty($user_email) || empty($user_password)) {
                echo "<div class='alert alert-danger'>field can't be blank !</div>";
            } else {
                $sql = "UPDATE users SET user_name = :username, user_email= :email, user_password = :password WHERE user_id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':username' => $user_name,
                    ':email' => $user_email,
                    ':password' => $user_password,
                    ':id' => $user_id
                ]);
                header("Location:index.php");
            }
        }

        ?>

        <form class="py-2" autocomplete="off" action="edit-user.php" method="POST">
            <input type="hidden" name="val" value="<?= $user_id ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Desired username" value="<?= $user_name ?>">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" placeholder="Desired email address" value="<?= $user_email ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter new password" value="<?= $user_password ?>">
            </div>
            <a href="index.php" class="btn btn-warning">Back</a>
            <button type="submit" class="btn btn-primary" name="updateUser">Submit</button>
        </form>
    </div>
<?php require_once('./includes/footer.php') ?>