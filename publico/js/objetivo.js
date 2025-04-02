document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('.header');
    const tarjetas = document.querySelectorAll('.tarjeta');

    // Animar el encabezado al cargar la página
    setTimeout(() => {
        header.classList.add('animated');
    }, 200);

    // Animar las tarjetas al cargar la página
    tarjetas.forEach((tarjeta, index) => {
        tarjeta.style.opacity = '0';
        tarjeta.style.transform = 'translateY(50px)';
        setTimeout(() => {
            tarjeta.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            tarjeta.style.opacity = '1';
            tarjeta.style.transform = 'translateY(0)';
        }, index * 200); // Retraso entre tarjetas
    });

    // Efecto de sombra al pasar el mouse
    tarjetas.forEach(tarjeta => {
        tarjeta.addEventListener('mouseenter', () => {
            tarjeta.style.boxShadow = '0 8px 16px rgba(0, 0, 0, 0.3)';
        });

        tarjeta.addEventListener('mouseleave', () => {
            tarjeta.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
        });
    });
});
