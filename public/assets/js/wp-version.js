$(document).ready(function () {
    $('#wp-version').click(function () {
        $('#versionsModal').modal('show'); // Show the modal when the button is clicked
    });

    var versiontable = $('#versiontalbe').DataTable({
        ajax: {
            url: '/getversions',
            dataSrc: ''
        },
        searching: true,
        lengthChange: true,
        columns: [
            { data: null, render: function (data, type, row, meta) { return meta.row + 1; } },
            { data: 'name' },
            { data: 'description' },
            { data: 'type' },
        ]
    });
});
