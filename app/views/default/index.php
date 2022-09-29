<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login Page</title>
        <link href="/css/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="/css/login.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                <div class="card-body p-4 p-sm-5">
                    <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
                    <form>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="rememberPasswordCheck">
                        <label class="form-check-label" for="rememberPasswordCheck">
                        Remember password
                        </label>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign
                        in</button>
                    </div>
                    <hr class="my-4">
                    <div class="d-grid mb-2">
                        <button class="btn btn-google btn-login text-uppercase fw-bold" type="submit">
                        Sign in with Google
                        </button>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-facebook btn-login text-uppercase fw-bold" type="submit">
                        Sign in with Facebook
                        </button>
                    </div>
                    </form>
                </div>
                </div>
            </div>
            </div>
        </div>
        <script src="/js/bootstrap/bootstrap.min.js"></script>
    </body>
</html>