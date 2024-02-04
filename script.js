// script.js
$(document).ready(function() {
    var table = $('#userTable').DataTable({
        paging: true,
        ordering: true,
        searching: true,
        info: false,
        pageLength: 10 
    });

    var users = [
        { id: 1, name: 'Ali', surname: 'Dhanani', dob: '1995-01-01', status: 'active', gender: 'male' },
    ];

    function populateTable() {
        table.clear();

        $.each(users, function(index, user) {
            table.row.add([
                user.name,
                user.surname,
                user.dob,
                user.status,
                user.gender,
                '<button class="editUser" data-id="' + user.id + '">Edit</button>' +
                '<button class="deleteUser" data-id="' + user.id + '">Delete</button>'
            ]).draw(false);
        });
    }

    populateTable();

    $('#addUser').click(function() {
        $('#userModal').show();
        $('#name').val('');
        $('#surname').val('');
        $('#dob').val('');
        $('#status').val('active');
        $('#gender').val('male');
        $('#saveUser').data('mode', 'add');
    });

    $('#saveUser').click(function() {
        var mode = $(this).data('mode');
        var id = $('#saveUser').data('id');

        var newUser = {
            id: id || users.length + 1,
            name: $('#name').val(),
            surname: $('#surname').val(),
            dob: $('#dob').val(),
            status: $('#status').val(),
            gender: $('#gender').val(),
        };

        if (mode === 'add') {
            users.push(newUser);
        } else if (mode === 'edit') {
            var index = findUserIndexById(id);
            if (index !== -1) {
                users[index] = newUser;
            }
        }

        $('#userModal').hide();
        populateTable();
    });

    $('#cancelUser').click(function() {
        $('#userModal').hide();
    });

    $('#userTable').on('click', '.editUser', function() {
        var id = $(this).data('id');
        var user = findUserById(id);

        $('#name').val(user.name);
        $('#surname').val(user.surname);
        $('#dob').val(user.dob);
        $('#status').val(user.status);
        $('#gender').val(user.gender);

        $('#saveUser').data('mode', 'edit');
        $('#saveUser').data('id', id);

        $('#userModal').show();
    });

    $('#userTable').on('click', '.deleteUser', function() {
        var id = $(this).data('id');

        var index = findUserIndexById(id);
        if (index !== -1) {
            users.splice(index, 1);
            populateTable();
        }
    });

    function findUserIndexById(id) {
        for (var i = 0; i < users.length; i++) {
            if (users[i].id === id) {
                return i;
            }
        }
        return -1;
    }

    function findUserById(id) {
        for (var i = 0; i < users.length; i++) {
            if (users[i].id === id) {
                return users[i];
            }
        }
        return null;
    }
});
