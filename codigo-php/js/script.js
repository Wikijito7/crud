function mostrarModal() {
  var modal = document.getElementById('modal');
  modal.style.display= "flex";
}

function cerrarModal(cual) {
  if (cual === undefined) var modal = document.getElementById('modal');
  else var modal = document.getElementById(cual);
  modal.style.display= "none";
}
