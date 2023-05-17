<?php

class componentes
{
  // Función encargada de generar el header de la página

  function header()
  {
    return '
        <header class="header-sticky">
            <div class="logo">
            <img src="../assets/img/logo.png" alt="logo">
            </div>
            <div class="navegacion">
            <ul>
                <li><a href="inicio.php">Inicio</a></li>
                <li><a href="mecanica.php">Taller</a></li>
                <li><a href="reservas.php">Reservas</a></li>
                <li><a href="asesoria.php">AsesorÍa</a></li>
                <li><a href="equipamiento.php">Equipamiento</a></li>
            </ul>
            </div>
            <div class="sesion">
            <ul>
                <li><button onclick="OpenloginModal()">Iniciar Sesión</button></li>
                <li><button onclick="OpenregisterModal()" href="index.php">Registrarse</button></li>
            </ul>
            </div>
            <div class="mobile-close-header">
            <i class="bi bi-list"></i>
            </div>
        </header>
        
        ';
  }
  //FUNCION ENCARGADA DE CREAR EL ENCABEZADO EN MECANICA Y ASESORIA 



  // Función encargada de generar el footer de la página
  // function footer()
  // {
  //     return '
  //     <footer>
  //     <div class="footer_container">
  //         <div class="logo">
  //             <img src="../assets/img/logo.png" alt="logo">
  //         </div>
  //         <div class="redes">
  //             <ul>
  //                 <li><a href="index.php"><i class="bi bi-facebook"></i></a></li>
  //                 <li><a href="index.php"><i class="bi bi-facebook"></i></a></li>
  //                 <li><a href="index.php"><i class="bi bi-instagram"></i></a></li>
  //                 <li><a href="index.php"><i class="bi bi-twitter"></i></a></li>
  //                 <li><a href="index.php"><i class="bi bi-youtube"></i></a></li>
  //                 <li><a href="index.php"><i class="bi bi-tiktok"></i></a></li>
  //             </ul>
  //         </div>
  //     </div>
  //     <div class="nav_options">
  //         <ul>
  //             <li><a href="index.php">Inicio</a></li>
  //             <li><a href="index.php">Taller</a></li>
  //             <li><a href="index.php">Reservas</a></li>
  //             <li><a href="index.php">asesoria</a></li>
  //         </ul>
  //     </div>
  //     </footer>
  //     ';
  // }
  function footer()
  {
    return '
        <footer>
            <div class="footer-container">
                <div class="footer-logo">
                    <img src="../assets/img/logo.png" alt="logo">
                </div>
                
                <div class="footer-links">
                    <div class="links">
                        <ul>
                            <h1>Empresa</h1>
                            <li><a class="a" href="#">Conocenos</a></li>
                            <li><a class="a" href="#">Mecanica</a></li>
                            <li><a class="a" href="#">Equipamiento</a></li>
                            <li><a class="a" href="#">Servicios</a></li>
                            <li><a class="a" href="#">Contacto</a></li>
                        </ul>
                    </div>
                    <div class="links">
                        <ul>
                            <h1>Reservas</h1>
                            <li><a href="#">Cambio de tarifa</a></li>
                            <li><a href="#">Mecanica</a></li>
                            <li><a href="#">Accesorios</a></li>
                            <li><a href="#">Limpieza</a></li>
                        </ul>
                    </div>
                    <div class="links">
                        <ul>
                            <h1>Escuela</h1>
                            <li><a href="#">Conocenos</a></li>
                            <li><a href="#">Mecanica</a></li>
                            <li><a href="#">Equipamiento</a></li>
                            <li><a href="#">Servicios</a></li>
                        </ul>
                    </div>
                    <div class="links">
                        <ul>
                            <h1>Escuela</h1>
                            <li><a href="#">Conocenos</a></li>
                            <li><a href="#">Mecanica</a></li>
                            <li><a href="#">Equipamiento</a></li>
                            <li><a href="#">Servicios</a></li>
                            <li><a href="#">Contacto</a></li>
                        </ul>
                    </div>
                </div>

                <div class="social">
                    <div class="wetaxi-app">
                        <a href="#" class="wetaxi-link-btn">
                            <i class="bi bi-google-play"></i>
                            <div class="wetaxi-link-text">
                                <span>Descargar en</span>
                                <h5>Google Play</h5>
                            </div>
                        </a>
                        <a href="#" class="wetaxi-link-btn">
                            <i class="bi bi-apple"></i>
                            <div class="wetaxi-link-text">
                                <span>Descargar en</span>
                                <h5>App Store</h5>
                            </div>
                        </a>
                    </div>

                    <div class="networks">
                        <ul>
                            <li><a href="https://www.facebook.com/madridurbanwetaxi/?locale=es_ES"><i class="bi bi-facebook"></i></a></li>
                            <li><a href="https://www.facebook.com/wetaximadridurban/?locale=es_ES"><i class="bi bi-facebook"></i></a></li>
                            <li><a href="https://www.instagram.com/wetaximadrid/?hl=es"><i class="bi bi-instagram"></i></a></li>
                            <li><a href="https://twitter.com/Wetaximadrid"><i class="bi bi-twitter"></i></a></li>
                            <li><a href="https://www.tiktok.com/@wetaxiurban"><i class="bi bi-tiktok"></i></a></li>
                            <li><a href="index.php"><i class="bi bi-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="copyright">
                    <p>© 2021 - Todos los derechos reservados</p>
                    <ul class="req">
                        <li><a href="#">Privacidad</a></li>
                        <li><a href="#">Accesibilidad</a></li>
                        <li><a href="#">Condiciones</a></li>                    
                    </ul>
                </div>
            </div>
        </footer>
        ';
  }
  function subheader($title, $description, $description2, $description3, $image)
  {
    return '
        <div class="header-image" style="background-image:url(' . $image . ');">
        <div class="header-text">  
            <h1>' . $title . '</h1>
            <p> ' . $description .  ' </p>
            <p> ' . $description2 .  ' </p>
            <p> ' . $description3 .  ' </p>
            
        </div>
        </div>
        ';
  }
}
// <img src=" '. $image .' " alt="Neumáticos" >