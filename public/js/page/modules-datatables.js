"use strict";

$("#table-1").dataTable({
    columnDefs: [{ sortable: false, targets: [2, 3] }],
    pageLength: 25,
    ordering: false,
});
