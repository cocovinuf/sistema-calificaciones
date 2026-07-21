//Esto crea un objeto que está modelado en la libreria de tabulator. Se manda el objeto y tabulator lo instancia

//AjaxURL se refiere a la url desde donde se van a obtener los datos partiendo desde planilla_materias.php ya que es donde se carga tabla.js
var table = new Tabulator("#tabla_tutores", {
  layout: "fitDataTable",
  validationMode: "blocking",
  ajaxURL: "../datos_tabla_tutores.php",
  ajaxCache: false,
  pagination: "local",
  paginationSize: 20,
  frozenRows: 0,

  //field se refiere a la clave del json
  columns: [
    {
      title: "Datos del alumno:",
      columns: [
        {
          title: "Nombre",
          field: "nombre",
          headerFilter: "input",
          headerFilterPlaceholder: "Distingue tildes",
          frozen: true,
        },
        {
          title: "Año",
          field: "ano",
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
        {
          title: "Nota 1",
          field: "T1N1Envio",

          validator: "numeric",
        },
        {
          title: "Nota 2",
          field: "T1N2Envio",

          validator: "numeric",
        },
        {
          title: "Nota 3",
          field: "T1N3Envio",

          validator: "numeric",
        },
        {
          title: "Concepto",
          field: "T1N1Concepto",
          editor: "input",
          validator: "numeric",
          headerVertical: true,
        },

        {
          title: "Promedio",
          field: "T1N2Promedio",
          headerVertical: true,
          formatter: function (cell) {
            let value = cell.getValue();

            if (
              value === 0.0 ||
              value === "0.00" ||
              value === null ||
              value === undefined
            ) {
              return "";
            }

            return value;
          },
        },

        {
          title: "Recuperatorio",
          field: "T1N3Recuperatorio",

          validator: "numeric",
          headerVertical: true,
        },
        // T1N4NotaTrimestral Se refiere al maximo entre el promedio y el recuperatorio, es decir la nota final de ese trimestre

        {
          title: "Nota Trimestral",
          field: "T1N4NotaTrimestral",

          headerVertical: true,
          formatter: function (cell) {
            let value = cell.getValue();

            if (
              value === 0.0 ||
              value === "0.00" ||
              value === null ||
              value === undefined
            ) {
              return "";
            }

            return value;
          },
        },
      ],
    },

    {
      title: "Segundo Trimestre",
      columns: [
        {
          title: "Nota 4",
          field: "T2N4Envio",

          validator: "numeric",
        },
        {
          title: "Nota 5",
          field: "T2N5Envio",

          validator: "numeric",
        },
        {
          title: "Nota 6",
          field: "T2N6Envio",

          validator: "numeric",
        },
        {
          title: "Concepto",
          field: "T2N1Concepto",
          editor: "input",
          headerVertical: true,
          validator: "numeric",
        },

        {
          title: "Promedio",
          field: "T2N2Promedio",
          headerVertical: true,
          formatter: function (cell) {
            let value = cell.getValue();

            if (
              value === 0.0 ||
              value === "0.00" ||
              value === null ||
              value === undefined
            ) {
              return "";
            }

            return value;
          },
        },

        {
          title: "Recuperatorio",
          field: "T2N3Recuperatorio",

          validator: "numeric",
          headerVertical: true,
        },

        {
          title: "Nota Trimestral",
          field: "T2N4NotaTrimestral",

          headerVertical: true,
          formatter: function (cell) {
            let value = cell.getValue();

            if (
              value === 0.0 ||
              value === "0.00" ||
              value === null ||
              value === undefined
            ) {
              return "";
            }

            return value;
          },
        },
      ],
    },

    {
      title: "Tercer Trimestre",
      columns: [
        {
          title: "Nota 7",
          field: "T3N7Envio",

          validator: "numeric",
        },
        {
          title: "Nota 8",
          field: "T3N8Envio",

          validator: "numeric",
        },
        {
          title: "Nota 9",
          field: "T3N9Envio",

          validator: "numeric",
        },
        {
          title: "Concepto",
          field: "T3N1Concepto",
          editor: "input",
          validator: "numeric",
          headerVertical: true,
        },

        {
          title: "Promedio",
          field: "T3N2Promedio",
          headerVertical: true,
          formatter: function (cell) {
            let value = cell.getValue();

            if (
              value === 0.0 ||
              value === "0.00" ||
              value === null ||
              value === undefined
            ) {
              return "";
            }

            return value;
          },
        },

        {
          title: "Recuperatorio",
          field: "T3N3Recuperatorio",

          validator: "numeric",
          headerVertical: true,
        },

        {
          title: "Nota Trimestral",
          field: "T3N4NotaTrimestral",

          headerVertical: true,
          formatter: function (cell) {
            let value = cell.getValue();

            if (
              value === 0.0 ||
              value === "0.00" ||
              value === null ||
              value === undefined
            ) {
              return "";
            }

            return value;
          },
        },
      ],
    },
    {
      title: "Prom. Trim.",
      field: "T4N1PromTrim",
      headerVertical: true,
      formatter: function (cell) {
        let value = cell.getValue();

        if (
          value === 0.0 ||
          value === "0.00" ||
          value === null ||
          value === undefined
        ) {
          return "";
        }

        return value;
      },
    },
    {
      title: "DIC",
      field: "T4N2Diciembre",
      validator: "numeric",
      headerVertical: true,
    },
    {
      title: "FEB",
      field: "T4N3Febrero",
      validator: "numeric",
      headerVertical: true,
    },
    {
      title: "Calif Def.",
      field: "T4N5CalifDef",
      headerVertical: true,
      formatter: function (cell) {
        let value = cell.getValue();

        if (
          value === 0.0 ||
          value === "0.00" ||
          value === null ||
          value === undefined
        ) {
          return "";
        }

        return value;
      },
    },
  ],
});

table.on("cellEdited", function (cell) {
  let row = cell.getRow(); //devuelve el objeto row de tabulator
  let fila = row.getData(); //convierte los datos del objeto en un json

  fetch("../controlador/controlador_guardar_notas.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(fila), // mando al controlador de guardar nota los datos de la fila
  })
    .then((res) => res.json())
    .then((resp) => {
      row.update(resp);
      console.log("¡Funciono!");
    });
});
