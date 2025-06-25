<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100%;
    }

    .img {
      position: relative; /* Add relative positioning to the div */
      background-image: url('/servis/gambar/Dashboard.png');
      height: 100vh; /* Set the height of the div to 100% of the viewport height */
      background-position: center;
      background-repeat: repeat;
      background-size: 100%;
      background-attachment: scroll;
    }

    .btn-cyan {
      position: absolute; 
      top: 85%; /* Adjust the top position to center the button vertically */
      left: 45%; /* Adjust the left position to center the button horizontally */
      transform: translate(-50%, -50%); /* Center the button precisely */
      border-radius: 50px; /* Adjust the border-radius to make the button more rounded */
      background-color: cyan; /* Change the background color to cyan */
      color: white; /* Set the text color to white for better visibility */
    }

    .btn-primary{
      position: absolute; /* Add absolute positioning to the button */
      top: 85%; /* Adjust the top position to center the button vertically */
      left: 37%; /* Adjust the left position to center the button horizontally */
      border-radius: 50px;
      padding: 20px 50px;
      font-size: 100%;
      background-color: skyblue;
      color: white;
      border-color: skyblue;
    }

    .btn-secondary{
      position: absolute; /* Add absolute positioning to the button */
      top: 85%; /* Adjust the top position to center the button vertically */
      left: 51%; /* Adjust the left position to center the button horizontally */
      border-radius: 50px;
      padding: 20px 50px;
      font-size: 100%;
      background-color: #8ca4d4;
      color: white;
      border-color: #8ca4d4;
    }
  </style>
</head>
<body>
  <div class="img"></div>
  <tr>
    <th><a type="a" href='/servis/servis.php' class="btn btn-primary btn-lg shadow"><b>VIEW LIST</b></a></th>
    <th><a type="a" href='/servis/isi-data.php' class="btn btn-secondary btn-lg shadow"><b>ADD DATA</b></a></th>
  </tr>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
