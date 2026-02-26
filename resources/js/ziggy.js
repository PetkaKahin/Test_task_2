const Ziggy = {"url":"http:\/\/localhost:8000","port":8000,"defaults":{},"routes":{"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"yandex_reviews.index":{"uri":"api\/yandex_reviews","methods":["GET","HEAD"]},"login.show":{"uri":"login","methods":["GET","HEAD"]},"login":{"uri":"login","methods":["POST"]},"settings.show":{"uri":"settings","methods":["GET","HEAD"]},"settings.update":{"uri":"settings","methods":["PATCH"]},"reviews.show":{"uri":"reviews","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["GET","HEAD"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
