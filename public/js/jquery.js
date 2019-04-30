$(document).ready(function(){    //Data Tables
    $('.dat thead tr').clone(true).appendTo( '.dat thead' );
    $('.dat thead tr:eq(1) th').each( function (i) {
        let title = $(this).text();
        $(this).html(`<input type="text" class="form-control" placeholder="Search ${title}" />`);

        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    let table = $('.dat').DataTable( {
        orderCellsTop: true,
        responsive: true,
        fixedHeader: true
    } );


    $('.dat2 thead tr').clone(true).appendTo( '.dat2 thead' );
    $('.dat2 thead tr:eq(1) th').each( function (i) {
        let title = $(this).text();
        $(this).html(`<input type="text" class="form-control" placeholder="Search ${title}"/>`);

        $( 'input', this ).on( 'keyup change', function () {
            if ( tables.column(i).search() !== this.value ) {
                tables
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    let tables = $('.dat2').DataTable( {
        orderCellsTop: true,
        responsive: true,
        fixedHeader: true
    } );

    //Add rows for scores
    let i=0;
    $('#add_score').on('click', ()=>{
        ++i;
        $('#scores_table').append(`<tr id="row${i}"><td><input type="text" name="firm_name[${i}]" id="firm_name${i}" class="form-control name_list" required></td><td><input type="number" name="technical_score[${i}]" id="technical_score${i}" class="form-control name_list" required></td><td><input type="number" name="financial_score[${i}]" id="financial_score${i}" class="form-control name_list" required></td><td><button type="button" id="${i}" class="btn btn-danger btn_remove">X</button></td></tr>`);
    });

    // Add more days and hours to an task
    $('#addhours').on('click', ()=>{
        ++i;
        $('#hours_row').append(`<div class="row id="row${i}"><div class="col-md-5 mt-2"><input type="date" name="activity_date[${i}]" id="activity_date${i}" class="form-control" required></div><div class="col-md-4 mt-2"><input type="number" name="duration[${i}]" id="duration${i}" class="form-control" required></div><div class="col-md-3 mt-2"><button type="button" id="${i}" class="btn btn-danger btn_remove">X</button></div></div>`);
    });

    $('#addSpecials').on('click', ()=>{
        ++i;
        $('#specials_row').append(`<div class="row id="row${i}"><div class="col-md-10 mt-2"><input type="text" name="specialization[${i}]" id="specialization${i}" class="form-control" placeholder="More Specilaizations" required></div><div class="col-md-2"><button type="button" id="${i}" class="btn btn-danger btn_remove">X</button></div></div>`);
    });

    $(document).on('click', '.btn_remove', function(){  
        var button_id = $(this).attr("id");   
        $('#row'+button_id+'').remove();  
   });

   $(window).scroll(function () {
    var top = $(document).scrollTop();
    if(top > 50)
      $('#home > .navbar').removeClass('navbar-transparent');
    else
      $('#home > .navbar').addClass('navbar-transparent');
});

$("a[href='#']").click(function(e) {
  e.preventDefault();
});

var $button = $("<div id='source-button' class='btn btn-primary btn-xs'>&lt; &gt;</div>").click(function(){
  var html = $(this).parent().html();
  html = cleanSource(html);
  $("#source-modal pre").text(html);
  $("#source-modal").modal();
});

$('.bs-component [data-toggle="popover"]').popover();
$('.bs-component [data-toggle="tooltip"]').tooltip();

$(".bs-component").hover(function(){
  $(this).append($button);
  $button.show();
}, function(){
  $button.hide();
});

function cleanSource(html) {
  html = html.replace(/×/g, "&times;")
             .replace(/«/g, "&laquo;")
             .replace(/»/g, "&raquo;")
             .replace(/←/g, "&larr;")
             .replace(/→/g, "&rarr;");

  var lines = html.split(/\n/);

  lines.shift();
  lines.splice(-1, 1);

  var indentSize = lines[0].length - lines[0].trim().length,
      re = new RegExp(" {" + indentSize + "}");

  lines = lines.map(function(line){
    if (line.match(re)) {
      line = line.substring(indentSize);
    }

    return line;
  });

  lines = lines.join("\n");

  return lines;
}
})

$(".opportunity_taskview").click(function(){
    $(this).toggleClass("down"); 
});