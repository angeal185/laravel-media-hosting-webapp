<!DOCTYPE html>
<html>

<head>
    <title>404 Not Found</title>
    <style type="text/css">
        body {
            background-color: #1E1E1E;
        }
        
        .img404 {
            margin: 130px auto;
            width: 30%;
        }
        
        .img404 h2 {
            font-size: 16px;
            color: #545454;
            text-shadow: 0px 1px 0px black;
        }
        
        .img404 a {
            text-decoration: none;
            color: #0f90ba;
            text-shadow: 0px 1px 0px black;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="img404"> <img src="{{url('/')}}/themes/dark/img/404/logo.png">
                <h2>Oops! The Page you requested was not found!</h2> <a href="{{url('/')}}">Back to hom page</a> </div>
        </div>
    </div>
</body>

</html>