document.addEventListener('DOMContentLoaded', function () {
  const body = document.body;
  const mensaje = body.getAttribute('data-popup-msg');
  const imagen = body.getAttribute('data-popup-img');
  const redireccion = body.getAttribute('data-popup-redi');

  if (mensaje && imagen) {
    mostrarPopup(mensaje, imagen, redireccion);
  }
});

function mostrarPopup(mensaje, imagen, redireccion) {
  // Estilos base
  const style = document.createElement('style');
  style.textContent = `
    @keyframes popupFade {
      from { opacity: 0; transform: scale(0.9); }
      to { opacity: 1; transform: scale(1); }
    }

    .popup-overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.6);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .popup-box {
      background: #fff;
      padding: 30px 25px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
      animation: popupFade 0.3s ease-out;
      max-width: 90%;
      width: 350px;
    }

    .popup-box img {
      width: 120px;
      margin-bottom: 15px;
    }

    .popup-box p {
      margin: 0 0 20px;
      font-size: 16px;
      color: #333;
    }

    .popup-box button {
      background: #4CAF50;
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 8px;
      font-size: 15px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .popup-box button:hover {
      background: #45a049;
    }
  `;
  document.head.appendChild(style);

  const overlay = document.createElement('div');
  overlay.className = 'popup-overlay';

  const popup = document.createElement('div');
  popup.className = 'popup-box';

  const image = document.createElement('img');
  image.src = imagen;

  const message = document.createElement('p');
  message.textContent = mensaje;

  const button = document.createElement('button');
  button.textContent = 'Aceptar';
  button.addEventListener('click', () => {
    window.location.href = redireccion;
  });

  popup.appendChild(image);
  popup.appendChild(message);
  popup.appendChild(button);
  overlay.appendChild(popup);
  document.body.appendChild(overlay);
}
