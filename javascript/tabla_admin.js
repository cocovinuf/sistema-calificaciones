//Esto crea un objeto que está modelado en la libreria de tabulator. Se manda el objeto y tabulator lo instancia

//AjaxURL se refiere a la url desde donde se van a obtener los datos partiendo desde home.php ya que es donde se carga tabla.js

var table = new Tabulator("#tabla_admin", {
  layout: "fitDataTable",
  ajaxURL: "../datos_tabla_admin.php",
  ajaxCache: false,
  pagination: "local",
  paginationSize: 20,
  frozenRows: 0,

  //field se refiere a la clave del json
  columns: [
    {
      title: "Datos del alumno",
      columns: [
        { title: "ID", field: "id_alumno", headerFilter: "input" },
        {
          title: "Nombre",
          field: "nombre_alumno",
          headerFilter: "input",
          headerFilterPlaceholder: "Distingue tildes",
        },
        { title: "Dni", field: "dni_alumno", headerFilter: "input" },
        {
          title: "Año Alumno",
          field: "ano_alumno",
          headerFilter: "list",
          headerFilterParams: { valuesLookup: true, clearable: true },
        },
        {
          title: "Año Materia",
          field: "ano_materia",
          headerFilter: "list",
          headerFilterParams: { valuesLookup: true, clearable: true },
        },
        {
          title: "Materia",
          field: "nombre_materia",
          headerFilter: "list",
          headerFilterParams: { valuesLookup: true, clearable: true },
        },
        {
          title: "Sede",
          field: "sede",
          headerFilter: "list",
          headerFilterParams: { valuesLookup: true, clearable: true },
        },
      ],
    },

    {
      title: "Primer Trimestre",
      columns: [
        { title: "Nota 1", field: "T1N1Envio", editor: "" },
        { title: "Nota 2", field: "T1N2Envio", editor: "" },
        { title: "Nota 3", field: "T1N3Envio", editor: "" },
        { title: "Con", field: "T1N1Concepto", editor: "" },
        { title: "Promedio", field: "T1N2Promedio", headerVertical: true },
        { title: "Rec", field: "T1N3Recuperatorio", editor: "" },
      ],
    },

    {
      title: "Segundo Trimestre",
      columns: [
        { title: "Nota 4", field: "T2N4Envio", editor: "" },
        { title: "Nota 5", field: "T2N5Envio", editor: "" },
        { title: "Nota 6", field: "T2N6Envio", editor: "" },
        { title: "Con", field: "T2N1Concepto", editor: "" },
        { title: "Promedio", field: "T2N2Promedio", headerVertical: true },
        { title: "Rec", field: "T2N3Recuperatorio", editor: "" },
      ],
    },

    {
      title: "Tercer Trimestre",
      columns: [
        { title: "Nota 7", field: "T3N7Envio", editor: "" },
        { title: "Nota 8", field: "T3N8Envio", editor: "" },
        { title: "Nota 9", field: "T3N9Envio", editor: "" },
        { title: "Con", field: "T3N1Concepto", editor: "" },
        { title: "Promedio", field: "T3N2Promedio", headerVertical: true },
        { title: "Rec", field: "T3N3Recuperatorio", editor: "" },
      ],
    },
    { title: "Prom. Trim.", field: "T4N1PromTrim", headerVertical: true },
    { title: "DIC", field: "T4N2Diciembre", headerVertical: true, editor: "" },
    { title: "FEB", field: "T4N3Febrero", headerVertical: true, editor: "" },
    { title: "Calif Def.", field: "T4N5CalifDef", headerVertical: true },
  ],
});
