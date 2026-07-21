// Document es el documento HTML que quiero leer. Es desde el cual se llama al script main. "Click" es el evento a escuchar. Function(e) es la funcion que se va a ejecutar cuando presione el click
document.addEventListener("click", function (e) {
  // e.target es el elemento que recibiio el click
  // En esta condicion alcanzaria con poner e.target.id === "btn_solicitar_libreta" sin lo primero. Pero se suele poner doble para interpretarlo de la siguiente manra: Si existe un click en el DOM y ademas ese click es "btn_solicitar_libreta", haz lo siguiente. Esto es asi debido a que en sistemas viejos era necesario y dependiendo del framework tambien puede serlo. En este caso lo dejo por las dudas y por buena practica.
  if (e.target && e.target.id === "btn_solicitar_libreta") {
    //Se definen los nombres de variables en JS segun se llamen en el documento por su atributo name. Esto se hace con query selector y name y no con el id (getElementById) porque name se usa en php.
    let sede = document.querySelector("[name='id_sede_libretas']").value;
    let ano = document.querySelector("[name='ano_libretas']").value;
    let alumno = document.querySelector("[name='nombre_alumno_libreta']").value;

    console.log("Llega al js");
    console.log("La sede es: " + sede);
    console.log("El ano es: " + ano);
    console.log("El alumno es: " + alumno);

    //Aca abajo hacemos una peticion ajax tipo GET a datos_tabla_libretas.php
    //table es la instancia de tabulator. setData lo que hace es buscar datos en la url que le indiques y recarga la tabla
    table.setData("../datos_tabla_libretas.php", {
      // Le decimos a tabulator que mande estos parametros al PHP para leerlos ahi con GET
      id_sede: sede,
      ano: ano,
      id_alumno: alumno,
    });
  }
});
