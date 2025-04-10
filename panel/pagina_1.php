<!-- Estilos personalizados -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CaloriFit</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="../publico/css/estilo.css">
</head>
<body>
  <?php include '../vistas/nab.php'; ?>
  <?php include '../vistas/modal_perfil.php'; ?>

  <!-- Sección de bienvenida -->
  <section class="welcome-section text-center">
    <h1>Bienvenido a <span>CALORIFIT</span></h1>
    <p>Transforma tu cuerpo y mente con nuestros planes exclusivos.</p>
    <button id="openProfile" class="btn btn-outline-light mt-3" onclick="location.href='#planes'">Suscríbete ahora</button>
  </section>
  
  <section id="planes" class="container section-container">
    <h2 class="text-center professional-title text-warning">ELIGE EL MEJOR PLAN PARA TI</h2>
    <p class="text-center subtitle">AHORRA HASTA 30%</p>
    <div class="text-center mb-4">
        <div class="toggle-container">
            <button id="monthlyButton" class="toggle-btn active">MENSUAL</button>
            <button id="annualButton" class="toggle-btn">ANUAL</button>
        </div>
    </div>
    <div class="contenedor-tarjetas">
        <!-- Tarjeta 1 -->
        <div class="card">
            <div class="card-img-container">
                <img src="https://e00-mx-marca.uecdn.es/mx/assets/multimedia/imagenes/2023/05/20/16846178754107.jpg" alt="Plan FIT">
            </div>
            <div class="contenido">
                <h2>PLAN FIT</h2>
                <p>Accede a contenido exclusivo y mejora tu rendimiento físico con entrenamientos personalizados.</p>
                <h3 class="price plan-price" data-monthly="40000" data-annual="320000">$54,950<span>/mes</span></h3>
                <p class="price-discount" data-monthly="70000" data-annual="560000">$70.000</p>
                <button class="boton" onclick="location.href='../vistas/index.php'">Descubre más</button>
            </div>
        </div>
        <!-- Tarjeta 2 -->
        <div class="card">
            <div class="card-img-container">
                <img src="../publico/imagenes/arnold.jpg" alt="Plan BLACK">
            </div>
            <div class="contenido">
                <h2>PLAN BLACK</h2>
                <p>Disfruta de beneficios premium, entrenamientos avanzados y acceso exclusivo a nuestras instalaciones.</p>
                <h3 class="price plan-price" data-monthly="60000" data-annual="480000">$34,950<span>/mes</span></h3>
                <p class="price-discount" data-monthly="90000" data-annual="720000">$90.000</p>
                <button class="boton" onclick="location.href='../vistas/index.php'">Descubre más</button>
            </div>
        </div>
        <!-- Tarjeta 3 -->
        <div class="card">
            <div class="card-img-container">
                <img src="https://th.bing.com/th/id/R.75c2ef94bc631ceb46e613eed9ab5471?rik=ylWJYGFtp4ZBwQ&riu=http%3a%2f%2f5b0988e595225.cdn.sohucs.com%2fimages%2f20190403%2f7f7a1ae827d64742b6e3c71131b11fc8.jpg&ehk=pgvHntSg5eORVPol8OfQnbRlsbz%2fenpbL7mVEChnag4%3d&risl=&pid=ImgRaw&r=0" alt="Plan CALO">
            </div>
            <div class="contenido">
                <h2>PLAN CALO</h2>
                <p>Obtén acceso completo a todas las áreas y servicios premium para alcanzar tus metas.</p>
                <h3 class="price plan-price" data-monthly="80000" data-annual="640000">$89,900<span>/mes</span></h3>
                <p class="price-discount" data-monthly="120000" data-annual="960000">$120.000</p>
                <button class="boton" onclick="location.href='../vistas/index.php'">Descubre más</button>
            </div>
        </div>
    </div>
  </section>

  <!-- Tabla de comparación de planes -->
  <section class="container my-5">
    <h2 class="text-center mb-4 sub-title">Comparación de Planes</h2>
    <div class="table-responsive plan-comparison-wrapper">
      <table class="table plan-comparison-table text-center align-middle">
        <thead>
          <tr>
            <th>Beneficios</th>
            <th>Plan Black</th>
            <th>Plan Fit</th>
            <th>Plan Calo</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Acceso ilimitado a más de 1,700 sedes</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
          </tr>
          <tr>
            <td>Invitado 5 veces al mes</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
          </tr>
          <tr>
            <td>Spa y masajes</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
          </tr>
          <tr>
            <td>Descuentos en marcas aliadas</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
          </tr>
          <tr>
            <td>App personalizada</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
          </tr>
          <tr>
            <td>Seguimiento a tu progreso</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
          </tr>
          <tr>
            <td>Entrenamientos en línea</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
          </tr>
          <tr>
            <td>Clases grupales</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
          </tr>
          <tr>
            <td>Acceso a todas las áreas</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
          </tr>
          <tr>
            <td class="fw-bold">Desde</td>
            <td class="fw-bold">$54,950/mes</td>
            <td class="fw-bold">$34,950/mes</td>
            <td class="fw-bold">$89,900/mes</td>
          </tr>
        </tbody>
      </table>
      <p class="table-note text-muted">*Valores promocionales. Aplican términos y condiciones.</p>
    </div>
  </section>

  <?php include '../vistas/footer.php'; ?>
  
  <script>
    const monthlyButton = document.getElementById('monthlyButton');
    const annualButton = document.getElementById('annualButton');
    const prices = document.querySelectorAll('.plan-price');
    const discounts = document.querySelectorAll('.price-discount');

    monthlyButton.addEventListener('click', () => {
        togglePlan('monthly');
        monthlyButton.classList.add('active');
        annualButton.classList.remove('active');
    });

    annualButton.addEventListener('click', () => {
        togglePlan('annual');
        annualButton.classList.add('active');
        monthlyButton.classList.remove('active');
    });

    function togglePlan(type) {
        prices.forEach(price => {
            const priceValue = price.getAttribute(`data-${type}`);
            price.innerHTML = `$${(priceValue / 1000).toLocaleString()}.000<span class="fs-6">/${type === 'monthly' ? 'mes' : 'año'}</span>`;
        });
        
        discounts.forEach(discount => {
            const discountValue = discount.getAttribute(`data-${type}`);
            discount.innerHTML = `$${(discountValue / 1000).toLocaleString()}.000`;
        });
    }
  </script>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../publico/js/script.js"></script>
</body>
</html>