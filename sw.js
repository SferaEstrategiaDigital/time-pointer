self.addEventListener("install", (event) => {
  console.log("Service Worker instalado.");
});

self.addEventListener("activate", (event) => {
  console.log("Service Worker ativado.");
});

self.addEventListener("push", (event) => {
  const payload = event.data ? event.data.text() : "Notificação padrão";
  const options = {
    body: payload,
    icon: "path/to/icon.png",
  };

  event.waitUntil(
    self.registration.showNotification("Título da Notificação", options)
  );
});
