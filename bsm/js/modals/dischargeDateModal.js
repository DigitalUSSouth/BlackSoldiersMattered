$('#dischargeDateModal').on('shown.bs.modal', function() {
            //alert('t');
          g3 = new Dygraph(
          document.getElementById("graphDischargeDateAll"),
            "data/dischargeDate.csv"
          );

           g4 = new Dygraph(
          document.getElementById("graphDischargeDateCompare"),
            "data/dischargeDateCompare.csv"
          );
});