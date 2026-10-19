
<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedidos</title>
    <link rel="icon" href="img/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>

<body>

    <div class="row">
        <div class="col-md-1 col-lg-3 col-xl-4"></div>
        <div class="col-md-10 col-lg-6 col-xl-4">
            <form class="border border-gray p-5  mt-5">
                <div class="mb-3 mt-3">
                    <label for="idCompra" class="form-label">ID de compra</label>
                    <input type="text" class="form-control" id="idCompra" aria-describedby="emailHelp">
                </div>
                <p id="mensaje"></p>
                <button type="submit" class="btn btn-primary btnRenvCorr mb-3">Enviar</button>
            </form>
        </div>
        <div class="col-md-1 col-lg-3 col-xl-4"></div>
    </div>

</body>
<!-- jQuery Version 1.11.1 -->
<script src="../js/jquery.js"></script>
<script src="../js/renCorr.js"></script>
<!-- jQuery UI -->
<script src="../js/jquery-ui.js"></script>

</html>