<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Signin Template</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin">
        <img class="mb-4" src="https://media.licdn.com/dms/image/C560BAQFqUuRAIwl4wg/company-logo_200_200/0/1590046309117?e=2147483647&v=beta&t=C2Rga75MUGjLdkTZ5ZkcdKibHqNO0TI86HSpBY2QaFA" alt="" width="72" height="72">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
            <input type="email" class="form-control" id="email" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" id="name" placeholder="name">
            <label for="floatingPassword">Full name</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary mt-3" id="btn_login">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2023</p>
    </main>

    <script src="/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
</body>

</html>