<?
     if (isset($_SESSION['currentUser'])) {
        echo '123';
       };
?>

<a href="/auth/logout" class="">logout</a>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Management</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
  <link href="/css/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="/css/dashboard.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!-- <style>
    .row.content {height: 1500px}
    
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style> -->
</head>
<body>

    <div class="container-fluid">
        <div class="row h-full">
            <div class="col-sm-3">
                <? if (isset($_SESSION['currentUser'])) {
                     echo $_SESSION['currentUser']['name'];
                    };
                ?>
                <ul class="nav nav-pills nav-stacked flex flex-col item-start justify-center">
                    <li class="text-xl font-bold bg-green-400 text-white rounded pl-4">User</li>
                    <li class="text-xl font-bold bg-green-400 text-white rounded pl-4 mt-2">Room</li>
                </ul>
            </div>

            <div class="col-sm-9 border-l-2">
                <div class="flex justify-between items-center">
                    <h4><small>USER</small></h4>
                    <div class="flex">
                        <button type="button" class="btn btn-success">Create</button>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>

<footer class="container-fluid">
</footer>
<script src="/js/bootstrap/bootstrap.min.js"></script>
</body>
</html>