window.onload = function() {
  $('#files').on("change",function(e){
    let bank = $('#bank option:selected').val();
    let header = (bank === 'ING' ? true : false);

    let result = $('#files').parse({
                          config: {
                          download: true,
                          skipEmptyLines: true,
                          header: header,
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
                          $('button[type="submit"]').prop('disabled', false);
                        }
    });
  });

  $('select[name="account_id"]').on("change", function(){
    // if account dropdown changes, read new value, read bank from "account1 (BANK)"
    let bank = $(this).find(":selected").text().match(/\([^\(]+\)$/)[0].slice(1,-1);
    // set bank dropdown to bank
    $('select[name="bank"]').val(bank);
  });
}

function displayHTMLTable(results){
// called after csv has been parsed, creates html table from data and displays results.
  let bank = $('#bank option:selected').val();
  let table = "";
  if (bank === "ASN") {
    table = getTableASN(results);
  } else if (bank == "ING"){
    table = getTableING(results);
  }

  $("#parsed_csv_list").html(table);

  $('tr td input[type="text"]').each(function(){
    $(this).hover(function(){
      $(this).attr('title', $(this).val());
    });
  });
}


function getTableASN(results){
// create string which contains all html elements for a table with all the data
  var data = results.data;
  var height = data.length;
  var table = "<table class='overflow'>";
  // table header
  headers = ["Boekingsdatum", "Opdrachtgeversrekening", "Tegenrekeningnummer", "Naam tegenrekening", "Adres", "Postcode", "Plaats", "Valutasoort rekening", "Saldo rekening voor mutatie", "Valutasoort mutatie", "Transactiebedrag", "Journaaldatum", "Valutadatum", "Interne transactiecode", "Globale transactiecode", "Volgnummer transactie", "Betalingskenmerk", "Omschrijving", "Afschriftnummer"];
  let width = headers.length;

  table += "<tr>";
  for(var i=0;i<width;i++){
    table += "<th>";
    table += headers[i];
    table += "</th>";
  }
  table += "</tr>";

  // table rows
  for(var i=0;i<height;i++){
    table += "<tr>";
    var row = data[i];
    for (var key in row){
      table += "<td>";
      table += "<input type=\"text\" name=\"transactions[" + i + "][" + headers[key] + "]\" value=\"" + row[key] + "\" readonly>";
      table += "</th>";
    }
    table += "</tr>";
  }

  return(table);
}

function getTableING(results){
// create string which contains all html elements for a table with all the data
  var data = results.data;
  var height = data.length;
  var table = "<table class='overflow'>";
  var headers = results.meta.fields;
  // table header
  let width = headers.length;
  table += "<tr>";
  for(var i=0;i<width;i++){
    table += "<th>";
    table += headers[i];
    table += "</th>";
  }
  table += "</tr>";

  // table rows
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

  return(table);
}

