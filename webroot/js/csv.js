window.onload = function() {
  $('#submit-file').on("click",function(e){
    e.preventDefault();
    $('#files').parse({
                          config: {
                          download: true,
                          skipEmptyLines: true,
                          header: true,
                          complete: displayHTMLTable,
                          },
                        before: function(file, inputElem) {
                          console.log("Parsing file...", file);
                        },
                        error: function(err, file) {
                          console.log("ERROR:", err, file);
                        },
                        complete: function() {
                          console.log("Done with all files");
                        }
    });
  });

  $('select[name="account_id"]').on("change", function(){
    let bank = $(this).find(":selected").text().match(/\([^\(]+\)$/)[0].slice(1,-1);
    $('select[name="bank"]').val(bank);
  });
}

function displayHTMLTable(results){
  var table = "<table class='table'>";
  var data = results.data;
  var headers = results.meta.fields;
  var height = data.length;
  var width = headers.length;

  table += "<tr>";
  for(var i=0;i<width;i++){
    table += "<th>";
    table += headers[i];
    table += "</th>";
  }
  table += "</tr>";
  for(var i=0;i<height;i++){
    table += "<tr>";
    var row = data[i];
    for (var key in row){
      table += "<td>";
      table += "<input type=\"text\" name=\"transactions[" + i + "][" + key + "]\" value=\"" + row[key] + "\" readonly>";
      table += "</th>";
    }
    table += "</tr>";
  }
  table += "</table>";
  $("#parsed_csv_list").html(table);
}


