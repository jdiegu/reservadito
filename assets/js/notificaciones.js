document.addEventListener("DOMContentLoaded", () => {
  if (Notification.permission !== "granted") {
      Notification.requestPermission();
  }

  //console.log("se notifico");

  setInterval(() => {
      fetch("../models/notificaciones/verificar_notificacion.php")
          .then(res => res.json())
          .then(data => {
              if (data.mensaje && Notification.permission === "granted") {
                  new Notification("Reservadito", {
                      body: data.mensaje,
                      icon: "../assets/media/logo.png"
                  });
              }
          });
  }, 2000);
});
