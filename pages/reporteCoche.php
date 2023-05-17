<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
  <h1>Inspección de Taxi</h1>

  <img src="carro.png" usemap="#carromap" />

  <map name="carromap">
    <area shape="rect" coords="34,44,270,350" alt="Capó" href="#" onclick="seleccionarParte('Capó')">
    <!-- Agrega más áreas aquí -->
  </map>

  <h2>Daños</h2>

  <div id="danos"></div>

  <input type="file" accept="image/*" capture="environment" id="fileInput" style="display: none;">

  <button onclick="enviarDanos()">Enviar daños</button>

  <script src="app.js">
    let danos = [];

function seleccionarParte(parte) {
  let dano = {
    parte: parte,
    imagen: null
  };

  danos.push(dano);

  document.getElementById('fileInput').click();
}

document.getElementById('fileInput').addEventListener('change', function(e) {
  var file = e.target.files[0];
  var reader = new FileReader();

  reader.onloadend = function() {
    danos[danos.length - 1].imagen = reader.result;
    actualizarListaDeDanos();
  }

  if (file) {
    reader.readAsDataURL(file);
  }
});

function actualizarListaDeDanos() {
  let lista = document.getElementById('danos');
  lista.innerHTML = '';

  for (let dano of danos) {
    let item = document.createElement('p');
    item.textContent = dano.parte;
    lista.appendChild(item);
  }
}

function enviarDanos() {
  // Aquí puedes enviar los datos de `danos` a tu servidor PHP
}

  </script>
</body>

</html>
