<html>
<head>
    <meta charset="utf-8">
    <title>MoneyIQ Stores</title>
    <link rel="stylesheet" type="text/css" href="media/css/jquery.dataTables.css">
    <script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/tabletools/2.2.3/css/dataTables.tableTools.css">
    <link rel="stylesheet" type="text/css" href="media/css/dataTables.editor.css">
    <link rel="stylesheet" type="text/css" href="media/css/admin_editor.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">

    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/tabletools/2.2.3/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" language="javascript" src="scripts/dataTables.editor.js"></script>
    <script type="text/javascript" language="javascript" class="init">
        var personas = [];
        var index;
        tmp = $.ajax({
            url: '../backend/crud/persona/all',
            data: {
                format: 'json',
                "contentType": "application/json; charset=utf-8",
                "dataType": "json"
            },
            type: 'GET',
            async: false
        }).responseText;

        if(tmp) {
            jason = JSON.parse(tmp);
            if(jason["data"]!=undefined) {
                tmpStore = jason["data"];
                for (index = 0; index < tmpStore.length; ++index) {
                    personas.push({
                        value: tmpStore[index]["PersonaId"],
                        label: tmpStore[index]["Name"]
                    })
                }
            }
        }

        var  restrictionTypes = [];
        tmp = $.ajax({
            url: '../backend/crud/restriction/type/all',
            data: {
                format: 'json',
                "contentType": "application/json; charset=utf-8",
                "dataType": "json"
            },
            type: 'GET',
            async: false
        }).responseText;

        if(tmp) {
            jason = JSON.parse(tmp);
            if(jason["data"]!=undefined) {
                tmpStore = jason["data"];
                for (index = 0; index < tmpStore.length; ++index) {
                    restrictionTypes.push({
                        value: tmpStore[index]["RestrictionTypeId"],
                        label: tmpStore[index]["Name"]
                    })
                }
            }
        }

        var creditCards = [];
        tmp = $.ajax({
            url: '../backend/display/creditcards',
            data: {
                format: 'json',
                "contentType": "application/json; charset=utf-8",
                "dataType": "json"
            },
            type: 'GET',
            async: false
        }).responseText;

        if(tmp) {
            var $mtmp = "";
            jason = JSON.parse(tmp);
            if(jason["data"]!=undefined) {
                tmpStore = jason["data"];
                for (index = 0; index < tmpStore.length; ++index) {
                    if(tmpStore[index]["issuer"]!=null) {
                        $mtmp = "(" + tmpStore[index]["issuer"]["name"] +  ")";
                    }
                    creditCards.push({
                        value: tmpStore[index]["credit_card_id"],
                        label: tmpStore[index]["name"] + $mtmp
                    })
                }
            }
        }



        restrictionTypeEditor = new $.fn.dataTable.Editor(
            {
                ajax: {
                    create: '../backend/crud/restriction/type/create', // default method is POST
                    edit: {
                        type: 'PUT',
                        url:  '../backend/crud/restriction/type/update'
                    },
                    remove: {
                        type: 'DELETE',
                        url: '../backend/crud/restriction/type/delete'
                    }
                },
                table: "#restrictionType",
                idSrc: "RestrictionTypeId",
                fields: [
                    {
                        label: "Id:",
                        name: "RestrictionTypeId",
                        type:  "readonly"
                    }, {
                        label: "Name:",
                        name: "Name"
                    }, {
                        label: "Description:",
                        name: "Description"
                    }, {
                        label: "Display:",
                        name: "Display"
                    }, {
                        label: "Path:",
                        name: "Path"
                    }, {
                        label: "Update date:",
                        name: "UpdateTime",
                        type: "readonly"
                    }, {
                        label: "Update user:",
                        name: "UpdateUser"
                    }
                ]
            });

        creditCardRestrictionEditor = new $.fn.dataTable.Editor(
            {
                ajax: {
                    create: '../backend/crud/restriction/credit/card/general/create', // default method is POST
                    edit: {
                        type: 'PUT',
                        url:  '../backend/crud/restriction/credit/card/general/update'
                    },
                    remove: {
                        type: 'DELETE',
                        url: '../backend/crud/restriction/credit/card/general/delete'
                    }
                },
                table: "#creditCardRestrictionTable",
                idSrc: "CreditCardRestrictionId",
                fields: [
                    {
                        label: "Id:",
                        name: "CreditCardRestrictionId",
                        type:  "readonly"
                    },{
                        label: "CreditCard:",
                        name: "CreditCard.credit_card_id",
                        type:  "select",
                        options: creditCards
                    },{
                        label: "RestrictionType:",
                        name: "RestrictionType.RestrictionTypeId",
                        type: "select",
                        options:restrictionTypes
                    }, {
                        label: "Comparator",
                        name: "Comparator",
                        type: "select",
                        options: ['=', '!=', '>', '<', 'in', 'not in']
                    },  {
                        label: "Value:",
                        name:  "Value"
                    },  {
                        label: "Priority",
                        name: "Priority"
                    },  {
                        label: "Update date:",
                        name: "update_time",
                        type: "readonly"
                    }, {
                        label: "Update user:",
                        name: "update_user"
                    }
                ]
            });

        restrictionEditor = new $.fn.dataTable.Editor(
            {
                ajax: {
                    create: '../backend/crud/restriction/general/create', // default method is POST
                    edit: {
                        type: 'PUT',
                        url:  '../backend/crud/restriction/general/update'
                    },
                    remove: {
                        type: 'DELETE',
                        url: '../backend/crud/restriction/general/delete'
                    }
                },
                table: "#restrictionTable",
                idSrc: "GeneralRestrictionId",
                fields: [
                    {
                        label: "Id:",
                        name: "GeneralRestrictionId",
                        type:  "readonly"
                    },{
                        label: "Persona:",
                        name: "Persona.PersonaId",
                        type:  "select",
                        options: personas
                    },{
                        label: "RestrictionType:",
                        name: "RestrictionType.RestrictionTypeId",
                        type: "select",
                        options:restrictionTypes
                    }, {
                        label: "Comparator",
                        name: "Comparator",
                        type: "select",
                        options: ['=', '!=', '>', '<', 'in', 'not in']
                    },  {
                        label: "Value:",
                        name:  "Value"
                    },  {
                        label: "Priority",
                        name: "Priority"
                    },  {
                        label: "Update date:",
                        name: "update_time",
                        type: "readonly"
                    }, {
                        label: "Update user:",
                        name: "update_user"
                    }
                ]
            });

        $(document).ready(function() {

            $('#restrictionType').dataTable({
                dom: "rtTip",
                "pageLength": 25,
                "ajax": {
                    "url": "../backend/crud/restriction/type/all",
                    "type": "GET",
                    "contentType": "application/json; charset=utf-8",
                    "dataType": "json"
                },
                "columns": [
                    {"data": "RestrictionTypeId", edit: false},
                    {"data": "Name", width: "15%"},
                    {"data": "Description", width:"25%"},
                    {"data": "Display", width: "30%"},
                    {"data": "Path", width: "30%"},
                    {"data": "UpdateTime", edit: false, visible: false},
                    {"data": "UpdateUser", visible: false}
                ]
                , tableTools: {
                    sRowSelect: "os",
                    aButtons: [
                        {sExtends: "editor_create", editor: restrictionTypeEditor},
                        {sExtends: "editor_edit", editor: restrictionTypeEditor},
                        {sExtends: "editor_remove", editor: restrictionTypeEditor}
                    ]
                }
            });

            $('#creditCardRestrictionTable').dataTable({
                dom: "lfrtTip",
                "pageLength": 25,
                "ajax": {
                    "url": "../backend/crud/restriction/credit/card/general/all",
                    "type": "GET",
                    "contentType": "application/json; charset=utf-8",
                    "dataType": "json"
                },
                "columns": [
                    {"data": "CreditCardRestrictionId",width:"125px"},
                    {"data": "CreditCard.name",editField: "CreditCard.credit_card_id", width:"150px"},
                    {"data": "RestrictionType.Name", editField: "RestrictionType.RestrictionTypeId",width:"150px"},
                    {"data": "Comparator",width:"100px"},
                    {"data": "Value",width:"100px"},
                    {"data": "Priority",width:"50px", visible:false},
                    {"data": "UpdateTime", visible:false,width:"20px"},
                    {"data": "UpdateUser",  visible:false,width:"20px"}
                ],
                tableTools: {
                    sRowSelect: "os",
                    aButtons:  [
                        {sExtends: "editor_create", editor: creditCardRestrictionEditor},
                        {sExtends: "editor_edit", editor: creditCardRestrictionEditor},
                        {sExtends: "editor_remove", editor: creditCardRestrictionEditor}
                    ]
                }

            } );

            $('#restrictionTable').dataTable({
                dom: "lfrtTip",
                "pageLength": 25,
                "ajax": {
                    "url": "../backend/crud/restriction/general/all",
                    "type": "GET",
                    "contentType": "application/json; charset=utf-8",
                    "dataType": "json"
                },
                "columns": [
                    {"data": "GeneralRestrictionId",width:"125px"},
                    {"data": "Persona.Name",editField: "Persona.PersonaId", width:"150px"},
                    {"data": "RestrictionType.Name", editField: "RestrictionType.RestrictionTypeId",width:"150px"},
                    {"data": "Comparator",width:"100px"},
                    {"data": "Value",width:"100px"},
                    {"data": "Priority",width:"50px", visible:false},
                    {"data": "UpdateTime", visible:false,width:"20px"},
                    {"data": "UpdateUser",  visible:false,width:"20px"}
                ],
                tableTools: {
                    sRowSelect: "os",
                    aButtons:  [
                        {sExtends: "editor_create", editor: restrictionEditor},
                        {sExtends: "editor_edit", editor: restrictionEditor},
                        {sExtends: "editor_remove", editor: restrictionEditor}
                    ]
                }
                /*,
                "initComplete": function(settings, json) {
                    this.api().columns().every(
                        function () {
                            var column = this;
                            if (!arrayValuesInString(column.header().innerHTML, ['Description','Title','Icon'])) {
                                var select = $('<select><option value=""></option></select>')
                                    .appendTo($(column.footer()))
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );

                                        column
                                            .search(val ? '^' + val + '$' : '', true, false)
                                            .draw();
                                    });

                                column.data().unique().sort().each(
                                    function (d, j) {
                                        select.append('<option value="' + d + '">' + d + '</option>')
                                    }
                                );
                            }
                        }
                    );
                }
                */
            } );

        });
    </script>
</head>

<body class="dt-other">
<div  class="admin_datatable_medium">
    <div class="table-headline"><a name="restrictiontype">Restriction Attributes</a></div>
    <table id="restrictionType" class="display" cellspacing="0">
        <thead>
        <tr>
            <th>Id</th>
            <th>Attribute</th>
            <th>Description</th>
            <th>Display</th>
            <th>Path</th>
            <th>Updated</th>
            <th>User</th>
        </tr>
        </thead>

        <tfoot>
        <tr>
            <th>Id</th>
            <th>Attribute</th>
            <th>Description</th>
            <th>Display</th>
            <th>Path</th>
            <th>Updated</th>
            <th>User</th>
        </tr>
        </tfoot>
    </table>
    <a href="../backend/crud/restriction/type/all" class="source">Source</a>
</div>

<div  class="admin_datatable_medium">
    <div class="table-headline"><a name="restrictions">Persona Restrictions</a></div>
    <table id="restrictionTable" class="display" cellspacing="0">
        <thead>
        <tr>
            <th>Id</th>
            <th>Persona</th>
            <th>Attribute</th>
            <th>Comparator</th>
            <th>Value</th>
            <th>Priority</th>
            <th>Updated</th>
            <th>User</th>
        </tr>
        </thead>

        <tfoot>
        <tr>
            <th>Id</th>
            <th>Persona</th>
            <th>Attribute</th>
            <th>Comparator</th>
            <th>Value</th>
            <th>Priority</th>
            <th>Updated</th>
            <th>User</th>
        </tr>
        </tfoot>
    </table>
    <a href="../backend/crud/restriction/general/all" class="source">Source</a>
</div>

<div class="admin_datatable_medium">
    <div class="table-headline"><a name="restrictions">CreditCard Restrictions</a></div>
    <table id="creditCardRestrictionTable" class="display" cellspacing="0">
        <thead>
        <tr>
            <th>Id</th>
            <th>CreditCard</th>
            <th>Attribute</th>
            <th>Comparator</th>
            <th>Value</th>
            <th>Priority</th>
            <th>Updated</th>
            <th>User</th>
        </tr>
        </thead>

        <tfoot>
        <tr>
            <th>Id</th>
            <th>CreditCard</th>
            <th>Attribute</th>
            <th>Comparator</th>
            <th>Value</th>
            <th>Priority</th>
            <th>Updated</th>
            <th>User</th>
        </tr>
        </tfoot>
    </table>
    <a href="../backend/crud/restriction/general/all" class="source">Source</a>
</div>

<br>
<br>
<br>
<div class="clear">
    <div class="source">Requests for menus</div>
    <a href="../backend/display/creditcards"  class="source">CreditCard</a>
    <a href='../backend/crud/persona/all' class="source">Personas</a>
    <a href='../backend/crud/restriction/type/all' class="source">Restrictions</a>
</div>
</body>
</html>