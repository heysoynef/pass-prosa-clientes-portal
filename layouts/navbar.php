<div class="row barrasup ctEs">
    
    <div class="col-md-2 nvh">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8"  style="padding-top:8px;">
                <div align="center">
                    <a href="./"><img src="img/prosalogo-negativo2.png" alt="Logo Prosa"></a>  
                </div> 

            </div>
            <div class="col-md-2"></div>


        </div>
    </div>
    <div class="col-md-10">
        <div class="row" style="padding-top:15px;">
            <div class="col-md-6 d-flex">
                                <div style="float:right;padding-top:22px;width:90%; display:flex; justify-content:center;"><p style="width:10%;color:rgb(72,186,88);text-align:center;font-weight: 500;font-family: 'Exo', sans-serif;">Tels. </p>
                    <a href="tel:8009992575" target="_blank">
                        <p class="mb-2" style="width:100%;color:rgb(72,186,88);text-align:center;font-weight: 500;font-family: 'Exo', sans-serif;">80 09 99 25 75</p>
                    </a>
                    <p style="width:5%;color:rgb(72,186,88);text-align:center;font-weight: 500;">|</p> <a href="tel:8009992585" target="_blank">
                        <p class="m-0" style="width:100%;color:rgb(72,186,88);text-align:center;font-weight: 500;font-family: 'Exo', sans-serif;">80 09 99 25 85</p>
                    </a>
                </div>
                <div style="float:right;padding-top:20px;width:90%;">
                <label style="width:100%;color:rgb(72,186,88);text-align:center;font-weight: 500;font-family: 'Exo', sans-serif;" for="exampleInputEmail1"><?= $mailUser ?></label>

                </div>
            </div>

            <div class="col-md-3 pull-right">
                <button type="button" style="font-family: 'Exo', sans-serif;" class="btn btn-light barrasup" id="logout" name="closeSession">Cerrar Sesi&oacute;n</button>
            </div>
            <div class="col-md-3 pull-right">
                <span class="spoiler">
                    <div class="contenedor">
                        <img src="img/cv.png" />
                        <div class="texto-encima">0</div>
                        <p style="margin-bottom:0px;font-family: 'Exo', sans-serif;">Ver Pedido</p>
                    </div>
                    <span id="car" style="color:white;">.
                        <div class="shopping_cart_dropdown" style="width:100%;">
                        </div>

                    </span>
                </span>



            </div>
        </div>
    </div>

</div>

<nav class="ctMo navbar navbar-expand-sm bg-light navbar-fixed-top navbar-light">

    <div class="col-md-5 nvh">
        <p class="bd" style="font-family: 'Exo', sans-serif;">Bienvenido:<span id="clien"><?= $cliente ?></span></p>
    </div>
    <div class="col-md-7">
        <div class="row">
            <div class="container">
                <div class="col" style="float:right;padding-top:5px;padding-bottom:5px;">
                    <input type="email" style="width:100%;visibility:hidden;position:absolute" class="form-control" id="cmpEmail" name="cmpEmail" value="<?= $mailUser ?>">
                    <label style="width:100%;color:rgb(72,186,88);text-align:center;font-weight: 500;font-family: 'Exo', sans-serif;" for="exampleInputEmail1"><?= $mailUser ?></label>
                        <span style="font-family: 'Exo', sans-serif;" type="text" class="col btn btn-light" id="logoutMovil" name="closeSession">Cerrar Sesi&oacute;n</span>

                </div>
            </div>

            <div class="container text-center">
                <div class="row row-cols-2">

                    <div class="col">
                        <a href="catalogo.pdf" target="_blank">
                            <img src="img/catalogoMovil.jpeg">
                        </a>
                    </div>
                    <div class="col">
                        <div class="container">
                            <span class="spoiler">
                                <div class="contenedor">
                                    <img src="img/cv.png" />
                                    <div class="texto-encima">0</div>
                                    <p style="margin-bottom:0px;font-family: 'Exo', sans-serif;">Ver Pedido</p>
                                </div>
                                <span id="car" style="color:white;">.
                                    <div class="shopping_cart_dropdown" style="width:100%;">
                                    </div>

                                </span>
                            </span>
                        </div>

                    </div>

                </div>

            </div>
        </div>

</nav>