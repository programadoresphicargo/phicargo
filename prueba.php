<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DataTable</title>
  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/cr-1.6.1/date-1.2.0/fc-4.2.1/fh-3.3.1/r-2.4.0/rg-1.3.0/rr-1.3.1/sc-2.0.7/sb-1.4.0/sp-2.1.0/sl-1.5.0/datatables.min.css" />
  <link rel="stylesheet" type="text/css" href="https://https://thegamechanger.us/Editor-PHP-2.0.10/css/editor.dataTables.min.css/" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />


  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/cr-1.6.1/date-1.2.0/fc-4.2.1/fh-3.3.1/r-2.4.0/rg-1.3.0/rr-1.3.1/sc-2.0.7/sb-1.4.0/sp-2.1.0/sl-1.5.0/datatables.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
  <script type="text/javascript" src="https://thegamechanger.us/Editor-PHP-2.0.10/js/dataTables.editor.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <style type="text/css">
    html,
    body {
      background-color: #F9F9F9;
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    table tbody tr.even:hover,
    table tbody tr.odd:hover {
      background-color: #ccc;
      /*cursor: pointer;*/
    }

    /* Reminder to talke about overriding styles */
    .table td {
      padding: 0.01rem 0.75rem;
      vertical-align: middle;
    }

    .table-responsive {
      overflow: visible !important;
    }

    table.dataTable tr.dtrg-group.dtrg-level-0 td {
      font-weight: bold;
      font-size: 20px;
      background-color: #ADD8e6;
    }

    table.dataTable tr.dtrg-group td {
      font-weight: bold;
      background-color: lightGrey;
    }

    table.dataTable tr.dtrg-group.dtrg-level-1 td:first-child {
      padding-left: 2em;
    }

    table.dataTable tr.dtrg-group.dtrg-level-1 td {
      background-color: #90EE90;
      padding-top: 0.25em;
      padding-bottom: 0.25em;
    }

    table.dataTable tr.dtrg-group.dtrg-level-2 td:first-child {
      padding-left: 3em;
    }

    table.dataTable tr.dtrg-group.dtrg-level-2 td {
      font-weight: bold;
      background-color: grey;
    }

    table.dataTable.compact tbody tr td.order_id {
      padding-left: 4em;
    }

    tfoot {
      display: table-header-group;
    }

    .icon-2 {
      color: green;
    }

    .icon-3 {
      color: red;
    }

    .icon-4 {
      color: blue;
    }

    .icon-5 {
      opacity: 0.0;
    }

    .icon-6 {
      opacity: 0.3;
    }

    .text-grey {
      color: lightGrey;
    }

    .zoomBox2 {
      zoom: 2;
    }

    .lightRed {
      background-color: #f0aaaa !important
    }

    .black {
      background-color: #000000 !important
    }

    .lightAmber {
      background-color: #fddf97 !important
    }
  </style>
  <!-- Add in extensions can be found here https://datatables.net/download/release -->

</head>

<body style="width: 95%; margin: 0 auto;">
  <div style="margin-bottom: 5px;"></div>
  <table id="table" class="table table-striped nowrap table-bordered compact" style="width: 100%;"></table>
  <script>
    // Find DataTable options here https://datatables.net/reference/option/
    $(document).ready(function() {


      const createdCell = function(cell) {
        let original;
        cell.setAttribute('contenteditable', true)
        cell.setAttribute('spellcheck', false)
        cell.addEventListener("focus", function(e) {
          original = e.target.textContent
        })
        cell.addEventListener("blur", function(e) {
          if (original !== e.target.textContent) {
            const row = table.row(e.target.parentElement)
            let content = e.target.textContent.trim()
            /*row.invalidate()*/
            var data = table.row($(this).parents('tr')).data();
            var pk = data.id;
            var columns = table.settings().init().columns;
            var idx = table.cell(this).index().column;
            var title = table.column(idx).header();
            var trans = table.colReorder.transpose(idx);
            var order = table.order();
            table.cell(row, idx).data(content).draw();
            var sp = pk + ' | ' + $(title).html() + ' | ' + content;
            FileMaker.PerformScriptWithOption('webPort - edit info', sp, 0);
          }
        })
      }

      //Dropdown Button Action
      $(function(row, data) {
        $('#posbuttondrop a').on('click', function(e) {
          var td = $(this).closest('td');
          var title = table.column(td).header();
          var idex = table.column(td).index();
          const row = table.row($(this).parents('tr')).index();
          var content = $(this).text();
          var data = table.row($(this).parents('tr')).data();
          var pk = data.id;
          var sp = pk + ' |  ' + $(title).html() + ' | ' + content;
          FileMaker.PerformScriptWithOption('webPort - edit info', sp, 0)
        });
      });

      $('#table thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#table thead');

      var collapsedGroups = [];
      var groupParent = [];
      var counter = 1;
      var table = $('#table').DataTable({

        "data": [{
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "1/1/2023",
            "group": "1. In",
            "id": "d-g-a",
            "jobpk": "jobID3",
            "member": "Smith, Mark",
            "membermatch": "BF4C2D-648",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|8:00 AM|5:00 PM|E3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "1/1/2023",
            "group": "1. In",
            "id": "BC777",
            "jobpk": "F5E3",
            "member": "Jones, Ryan",
            "membermatch": "BFE97",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|8:00 AM|5:00 PM|3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "1/1/2023",
            "group": "1. In",
            "id": "2823",
            "jobpk": "F5E3",
            "member": "Sanchez, Jennifer",
            "membermatch": "68E7",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|8:00 AM|5:00 PM|9583E3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "1/1/2023",
            "group": "1. In",
            "id": "17ABasD0Ed4",
            "jobpk": "5E3",
            "member": "Hanks, Julia",
            "membermatch": "69C",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|8:00 AM|5:00 PM|E3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "1/1/2023",
            "group": "1. In",
            "id": "asfwe",
            "jobpk": "95E3",
            "member": "Clooney, Charles",
            "membermatch": "B12620C",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|8:00 AM|5:00 PM|9589F5E3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "1/9/2023 11:33:25 AM",
            "confirmed": "Accept Call",
            "confnosend": "x",
            "date": "1/1/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "1/1/2023",
            "group": "1. In",
            "id": "42A7784",
            "jobpk": "E3",
            "member": "Pitts, Matthew",
            "membermatch": "153B5DFE9ad73",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|8:00 AM|5:00 PM|958ad339A3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "A48891F",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "",
            "group": "1. In",
            "id": "D1DDF",
            "jobpk": "9585E3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|8:00 AM|5:00 PM|9585E3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "",
            "group": "1. In",
            "id": "534150",
            "jobpk": "958E3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|8:00 AM|5:00 PM|95F9F5E3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "",
            "group": "1. In",
            "id": "EB1",
            "jobpk": "95F5E3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|8:00 AM|5:00 PM|9565E3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "",
            "group": "1. In",
            "id": "290",
            "jobpk": "95-A55E3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|8:00 AM|5:00 PM|95|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "",
            "group": "1. In",
            "id": "DF1212A",
            "jobpk": "jobID3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|8:00 AM|5:00 PM|jobID3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "",
            "group": "1. In",
            "id": "9367EC",
            "jobpk": "jobID3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|8:00 AM|5:00 PM|jobID3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "11:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "212957C",
            "jobpk": "jobID3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|6:00 PM|11:00 PM|jobID3|2. Show 1",
            "st": "",
            "start": "6:00 PM - 11:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "11:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "FBB8",
            "jobpk": "jobID3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|6:00 PM|11:00 PM|jobID3|2. Show 1",
            "st": "",
            "start": "6:00 PM - 11:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "11:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "B276EC2C",
            "jobpk": "jobID3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|6:00 PM|11:00 PM|jobID3|2. Show 1",
            "st": "",
            "start": "6:00 PM - 11:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "11:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "5279",
            "jobpk": "jobID3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|6:00 PM|11:00 PM|jobID3|2. Show 1",
            "st": "",
            "start": "6:00 PM - 11:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/1/2023",
            "dt": "",
            "end": "11:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "E92",
            "jobpk": "jobID3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/1/2023|6:00 PM|11:00 PM|jobID3|2. Show 1",
            "st": "",
            "start": "6:00 PM - 11:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "1/1/2023",
            "group": "1. In",
            "id": "D08F",
            "jobpk": "jobID3",
            "member": "Anchor, Mark",
            "membermatch": "g-d-g-9409-g",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|8:00 AM|5:00 PM|jobID3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "1/1/2023",
            "group": "1. In",
            "id": "676332",
            "jobpk": "jobID3",
            "member": "Forts, Ryan",
            "membermatch": "a-d-g-g-g",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|8:00 AM|5:00 PM|jobID3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "1/1/2023",
            "group": "1. In",
            "id": "83CD",
            "jobpk": "959F5E3",
            "member": "Dunham, Jennifer",
            "membermatch": "asd",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|8:00 AM|5:00 PM|jobID3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "1/1/2023",
            "group": "1. In",
            "id": "6B",
            "jobpk": "jobID3",
            "member": "Smith, Julia",
            "membermatch": "5E9C",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|8:00 AM|5:00 PM|jobID3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "1/1/2023",
            "group": "1. In",
            "id": "6E7",
            "jobpk": "jobID3",
            "member": "Lopez, Charles",
            "membermatch": "a-d-g-9C0F-b",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|8:00 AM|5:00 PM|jobID3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "",
            "group": "1. In",
            "id": "a-g-s-a-g",
            "jobpk": "jobID3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|8:00 AM|5:00 PM|jobID3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "",
            "group": "1. In",
            "id": "8",
            "jobpk": "93",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|8:00 AM|5:00 PM|jobID3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "",
            "group": "1. In",
            "id": "",
            "jobpk": "9",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|8:00 AM|5:00 PM|jobID3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "",
            "group": "1. In",
            "id": "D0",
            "jobpk": "93",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|8:00 AM|5:00 PM|3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "",
            "group": "1. In",
            "id": "B21",
            "jobpk": "93",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|8:00 AM|5:00 PM|jobID3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "",
            "group": "1. In",
            "id": "A8EA6D",
            "jobpk": "AE3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|8:00 AM|5:00 PM|3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "5:00 PM",
            "firstday": "",
            "group": "1. In",
            "id": "CB13EE",
            "jobpk": "95E3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|8:00 AM|5:00 PM|jobID3|1. In",
            "st": "",
            "start": "8:00 AM - 5:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "11:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "444823BC",
            "jobpk": "9585E3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|6:00 PM|11:00 PM|9583|2. Show 1",
            "st": "",
            "start": "6:00 PM - 11:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "11:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "0E16",
            "jobpk": "95833",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|6:00 PM|11:00 PM|955E3|2. Show 1",
            "st": "",
            "start": "6:00 PM - 11:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "11:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "3C37F2D9",
            "jobpk": "9F9F5E3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|6:00 PM|11:00 PM|959F5E3|2. Show 1",
            "st": "",
            "start": "6:00 PM - 11:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "11:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "CA8A60F",
            "jobpk": "958F5E3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|6:00 PM|11:00 PM|958E3|2. Show 1",
            "st": "",
            "start": "6:00 PM - 11:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/2/2023",
            "dt": "",
            "end": "11:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "4D46D2",
            "jobpk": "958F9F5E3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/2/2023|6:00 PM|11:00 PM|95F5E3|2. Show 1",
            "st": "",
            "start": "6:00 PM - 11:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/3/2023",
            "dt": "",
            "end": "3:00 PM",
            "firstday": "1/1/2023",
            "group": "2. Show 1",
            "id": "2C4371",
            "jobpk": "955E3",
            "member": "Lopez, Mark",
            "membermatch": "BF648",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/3/2023|11:00 AM|3:00 PM|958EF9F5E3|2. Show 1",
            "st": "",
            "start": "11:00 AM - 3:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/3/2023",
            "dt": "",
            "end": "3:00 PM",
            "firstday": "1/1/2023",
            "group": "2. Show 1",
            "id": "765A44",
            "jobpk": "95F9F5E3",
            "member": "Forts, Ryan",
            "membermatch": "C64A14BFE97",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/3/2023|11:00 AM|3:00 PM|9589F5E3|2. Show 1",
            "st": "",
            "start": "11:00 AM - 3:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/3/2023",
            "dt": "",
            "end": "3:00 PM",
            "firstday": "1/1/2023",
            "group": "2. Show 1",
            "id": "AB1679AE-9FE6-F3",
            "jobpk": "958F5E3",
            "member": "Hanks, Jennifer",
            "membermatch": "A80E7",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/3/2023|11:00 AM|3:00 PM|jobID3|2. Show 1",
            "st": "",
            "start": "11:00 AM - 3:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/3/2023",
            "dt": "",
            "end": "3:00 PM",
            "firstday": "1/1/2023",
            "group": "2. Show 1",
            "id": "1808",
            "jobpk": "95833F5E3",
            "member": "Smith, Julia",
            "membermatch": "60F59455E9C",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/3/2023|11:00 AM|3:00 PM|9578EF9F5E3|2. Show 1",
            "st": "",
            "start": "11:00 AM - 3:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/3/2023",
            "dt": "",
            "end": "3:00 PM",
            "firstday": "1/1/2023",
            "group": "2. Show 1",
            "id": "C69BFB",
            "jobpk": "jobID3",
            "member": "Lopez, Charles",
            "membermatch": "B12C8620C",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/3/2023|11:00 AM|3:00 PM|958F5E3|2. Show 1",
            "st": "",
            "start": "11:00 AM - 3:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/3/2023",
            "dt": "",
            "end": "3:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "a",
            "jobpk": "h",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/3/2023|11:00 AM|3:00 PM|95F5E3|2. Show 1",
            "st": "",
            "start": "11:00 AM - 3:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/3/2023",
            "dt": "",
            "end": "3:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "g",
            "jobpk": "a",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/3/2023|11:00 AM|3:00 PM|958339F5E3|2. Show 1",
            "st": "",
            "start": "11:00 AM - 3:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/3/2023",
            "dt": "",
            "end": "3:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "a",
            "jobpk": "95g83E3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/3/2023|11:00 AM|3:00 PM|955E3|2. Show 1",
            "st": "",
            "start": "11:00 AM - 3:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/3/2023",
            "dt": "",
            "end": "3:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "6D8FB5",
            "jobpk": "f",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/3/2023|11:00 AM|3:00 PM|952. Show 1",
            "st": "",
            "start": "11:00 AM - 3:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/3/2023",
            "dt": "",
            "end": "3:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "C56869",
            "jobpk": "sg",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/3/2023|11:00 AM|3:00 PM|958339E3|2. Show 1",
            "st": "",
            "start": "11:00 AM - 3:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/3/2023",
            "dt": "",
            "end": "3:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "22778",
            "jobpk": "959gF5E3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/3/2023|11:00 AM|3:00 PM||2. Show 1",
            "st": "",
            "start": "11:00 AM - 3:00 PM",
            "strike": "",
            "wrap": ""
          },
          {
            "buttons": "",
            "call": "",
            "callsent": "",
            "confirmed": "",
            "confnosend": "",
            "date": "1/3/2023",
            "dt": "",
            "end": "3:00 PM",
            "firstday": "",
            "group": "2. Show 1",
            "id": "28062",
            "jobpk": "jobID3",
            "member": "",
            "membermatch": "",
            "ot": "",
            "position": "Hand",
            "positioninfo": "Hand|1/3/2023|11:00 AM|3:00 PM|jobID3|2. Show 1",
            "st": "",
            "start": "11:00 AM - 3:00 PM",
            "strike": "",
            "wrap": ""
          }
        ],
        columns: [{
            "title": "id",
            "data": "id"
          },
          {
            "title": "jobpk",
            "data": "jobpk"
          },
          {
            "title": "date",
            "data": "date"
          },
          {
            "title": "group",
            "data": "group"
          },
          {
            "title": "position",
            "data": "position"
          },
          {
            "title": "Start",
            "data": "start"
          },
          {
            "title": "End",
            "data": "end"
          },
          {
            "title": "membermatch",
            "data": "membermatch"
          },
          {
            "title": "Member",
            "data": "member"
          },
          {
            "title": "positioninfo",
            "data": "positioninfo"
          },
          {
            "title": "firstday",
            "data": "firstday"
          },
          {
            "title": "Call Sent",
            "data": "callsent"
          },
          {
            "title": "Call",
            "data": "call"
          },
          {
            "title": "Wrap",
            "data": "wrap"
          },
          {
            "title": "ST",
            "data": "st"
          },
          {
            "title": "OT",
            "data": "ot"
          },
          {
            "title": "DT",
            "data": "dt"
          },
          {
            "title": "conf",
            "data": "confirmed",
            "searchable": false,
            "className": 'dt-center',
            "render": function(data, type, full) {
              if (data !== '') {
                return `<i class="fa fa-check fa-lg">`
              } {
                return `<i class="fa fa-check icon-5 fa-lg">`
              }
            }
          },
          {
            "title": "",
            "data": "buttons"
          },
          {
            "title": ""
          },
          {
            "title": "manual",
            "data": "confirmed",
            "searchable": false,
            "className": 'dt-center',
            "render": function(data, type, full) {
              if (data !== '') {
                return `<i class="fa fa-check-circle  icon-4 fa-lg">`
              } else {
                return '<button id="manualConfirm" type="button" class="btn btn-default"><span class="fa fa-check-circle icon-6 fa-lg"></span></button>'
              }
            }
          },
          {
            "title": "strike",
            "data": "strike",
            "searchable": false,
            "className": 'dt-center',
            "render": function(data, type, full) {
              if (data !== '') {
                return `<i class="fa fa-times-circle  icon-3 fa-lg">`
              } else {
                return '<button id="manualConfirm" type="button" class="btn btn-default"><span class="fa fa-times-circle icon-6 fa-lg"></span></button>'
              }
            }
          }
        ],
        columnDefs: [{
            targets: ["_all"],
            "orderable": false
          },
          {
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 14, 15, 16, 17, 18, 19, 21],
            className: 'noVis'
          },
          {
            targets: [10, 12, 13, 14, 15, 16],
            createdCell: createdCell
          },
          {
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 9, 10],
            "visible": false
          },
          {
            targets: [14, 15, 16, 17, 18, 19, 20, 21],
            width: 30
          },
          {
            "targets": 19,
            "data": null,
            "orderable": false,
            "className": 'dt-body-center',
            "render": function(data, type, full, meta) {
              return '<input type="checkbox" id="selector" class="zoomBox2" name="selector" value="' + $('<div/>').text(data).html() + '">';
            }
          },

          {
            targets: [18],
            "render": function(data, type, row) {
              return `<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
    <button class="dropdown-item" type="button" id="fill"><span class="fa fa-user fa-lg"> Fill Positions</button>
    <div class="dropdown-divider"></div>
    <button class="dropdown-item" type="button"id="clear"><span class="fa fa-times-circle fa-lg"> Clear Position</button>
    <div class="dropdown-divider"></div>
    <button class="dropdown-item" type="button"id="delete"><span class="fa fa-trash fa-lg"> Delete Position</button>
    <div class="dropdown-divider"></div>
    <button class="dropdown-item" type="button"id="add"><span class="fa fa-plus-circle fa-lg"> Add Position</button>
    <div class="dropdown-divider"></div>

  </div>`
            }
          }

        ],

        createdRow: function(row, data, dataIndex) {
          if (data.date == data.firstday) {
            $(row).addClass('lightAmber')
          }
        },
        buttons: [],
        displayLength: 40,
        scrollY: '85vh',
        scrollCollapse: true,
        processing: true,
        autoWidth: true,
        fixedHeader: {
          header: true,
          footer: true
        },
        scrollX: true,
        select: true,
        info: false,
        paging: false,
        searching: false,
        autoWidth: true,
        colReorder: {
          enable: true
        },
        order: [
          [2, "asc"],
          [3, "asc"],
          [4, "asc"],
          [5, "asc"]
        ],
        rowGroup: {
          dataSrc: ['id', 'member'],
          endRender: null,
          startRender: function(rows, group, level) {
            groupParent[level] = group;

            var groupAll = '';

            for (var i = 0; i < level; i++) {
              groupAll += groupParent[i];



              if (collapsedGroups[groupAll]) {
                return;
              }
            }
            groupAll += group;

            if ((typeof(collapsedGroups[groupAll]) == 'undefined') || (collapsedGroups[groupAll] === null)) {
              collapsedGroups[groupAll] = true;
            } //True = Start collapsed. False = Start expanded.

            var collapsed = collapsedGroups[groupAll];
            var toggleClass = collapsed ? "fa fa-fw fa-caret-right fa-lg toggler" : "fa fa-fw fa-caret-down fa-lg toggler ";
            rows.nodes().each(function(r) {
              r.style.display = (collapsed ? 'none' : '');
            });
            return $('<tr/>').append('<td colspan="4"><button class="btn btn-default" type="button" id="expButton"><span class="' + toggleClass + '"></button>' + group + '</td>').append('<td colspan="15">(' + rows.count() + ')</td>').attr('data-name', groupAll).toggleClass('collapsed', collapsed);
          }
        },

      });

      table.buttons().container()
        .appendTo('#table_wrapper .col-md-6:eq(0)');

      function hideShow(columnsArray, state) {
        $('#table').columns(columnsArray).visible(state);
      }

      table.colReorder.order([0, 1, 18, 19, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 17, 20, 21, 12, 13, 14, 15, 16]);

      $('#table tbody').on('click', 'tr.dtrg-start td button', function() {
        var tr = $(this).closest('tr'); // Get the clicked tr
        var pos = $('div.dataTables_scrollBody').scrollTop();
        var name = $(tr).data('name'); // Get the name of the clicked tr
        collapsedGroups[name] = !collapsedGroups[name];
        table.draw(false);
        $('.dataTables_scrollBody').scrollTop(pos);
      });

    });
  </script>
</body>

</html>