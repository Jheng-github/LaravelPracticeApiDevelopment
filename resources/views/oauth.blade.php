<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="top-right home">
        </div>
        <div class="content">
            <div class="m-b-md">
                <form name="login" action="index.php" method="post">
                    <p>登入帳號 : <input type=text name="name" placeholder="輸入帳號"></p>
                    <p>登入密碼 : <input type=password name="password" placeholder="輸入密碼"></p>
                    <p><input type="submit" name="submit" value="登入">
                        <input type="reset" name="Reset" value="清除">
                    </p>
                </form>
                <div class=" flex items-center justify-center gap-x-4">
                    <a href="/auth/github" class="text-sm text-gray-500"> login with Github <span
                            aria-hidden="true">→</span></a>
                </div>
                <div class=" flex items-center justify-center gap-x-4">
                    <a href="/auth/facebook" class="text-sm text-gray-500"> login with Facebook <span
                            aria-hidden="true">→</span></a>
                </div>
                <div class=" flex items-center justify-center gap-x-4">
                    <a href="/auth/google" class="text-sm text-gray-500"> login with google <span
                            aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
