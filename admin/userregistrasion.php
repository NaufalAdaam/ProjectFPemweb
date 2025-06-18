<?php require_once '../db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>User Management System</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">  
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">  
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">  
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"> 

    <style>
        .action-buttons .btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .modal-header.bg-primary,
        .modal-header.bg-warning,
        .modal-header.bg-danger {
            color: white;
        }
        .role-admin { color: #dc3545; font-weight: bold; }
        .role-user { color: #28a745; }
        .loading {
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index.php" class="nav-link">Home</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="../login.php" class="nav-link">Logout</a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
      <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
      <span class="brand-text font-weight-light">TheOrbits Admin</span>
    </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Admin</a>
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="index.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Home</p></a>
                            </li>
                            <li class="nav-item">
                                <a href="neworder.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Total Order</p></a>
                            </li>
                            <li class="nav-item">
                                <a href="totalsales.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Total Sales</p></a>
                            </li>
                            <li class="nav-item">
                                <a href="userregistrasion.php" class="nav-link active">
                                    <i class="far fa-circle nav-icon"></i><p>User Registration</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="fas fa-users"></i> User Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">User Management</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div id="alertContainer"></div>
                        <div class="card">
                            <div class="card-header bg-warning">
                                <h3 class="card-title text-white"><i class="fas fa-user-plus"></i> Registered Users</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUserModal">
                                        <i class="fas fa-plus"></i> Add New User
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="usersTable" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="usersTableBody">
                                            <tr>
                                                <td colspan="5" class="loading">
                                                    <i class="fas fa-spinner fa-spin"></i> Loading users...
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>&copy; <?= date('Y') ?> TheOrbits Admin.</strong> All rights reserved.
    </footer>
</div>

<!-- Modals -->
<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="addUserForm">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-user-plus"></i> Add New User</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="addUsername"><i class="fas fa-user"></i> Username</label>
                        <input type="text" class="form-control" id="addUsername" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="addEmail"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" class="form-control" id="addEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="addPassword"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" class="form-control" id="addPassword" name="password" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label for="addRole"><i class="fas fa-user-tag"></i> Role</label>
                        <select class="form-control" id="addRole" name="role">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="editUserForm">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title"><i class="fas fa-user-edit"></i> Edit User</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editUserId" name="id">
                    <div class="form-group">
                        <label for="editUsername"><i class="fas fa-user"></i> Username</label>
                        <input type="text" class="form-control" id="editUsername" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="editPassword"><i class="fas fa-lock"></i> New Password (leave empty to keep current)</label>
                        <input type="password" class="form-control" id="editPassword" name="password" minlength="6">
                    </div>
                    <div class="form-group">
                        <label for="editRole"><i class="fas fa-user-tag"></i> Role</label>
                        <select class="form-control" id="editRole" name="role">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update User</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-trash"></i> Delete User</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> This action cannot be undone!
                </div>
                <ul>
                    <li><strong>Username:</strong> <span id="deleteUserName"></span></li>
                    <li><strong>Email:</strong> <span id="deleteUserEmail"></span></li>
                    <li><strong>Role:</strong> <span id="deleteUserRole"></span></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete User</button>
            </div>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-eye"></i> User Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="viewUserId"></span></p>
                <p><strong>Username:</strong> <span id="viewUserName"></span></p>
                <p><strong>Email:</strong> <span id="viewUserEmail"></span></p>
                <p><strong>Role:</strong> <span id="viewUserRole"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script> 

<!-- Custom JS -->
<script>
let users = [];
let currentDeleteId = null;
let dataTable = null;

$(document).ready(function () {
    loadUsers();
});

function loadUsers() {
    $.ajax({
        url: 'api.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                users = response.data;
                renderUsersTable();
                initializeDataTable();
            } else {
                showAlert('Failed to load users', 'danger');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading users:', error);
            showAlert('Error loading users', 'danger');
        }
    });
}

function renderUsersTable() {
    const tbody = $('#usersTableBody');
    tbody.empty();
    if (!users.length) {
        tbody.append('<tr><td colspan="5" class="text-center">No users found</td></tr>');
        return;
    }
    users.forEach((user, index) => {
        tbody.append(`
            <tr>
                <td>${index + 1}</td>
                <td>${user.username}</td>
                <td>${user.email}</td>
                <td>${getRoleBadge(user.role)}</td>
                <td class="action-buttons">
                    <button class="btn btn-info btn-sm" onclick="viewUser(${user.id})" title="View"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-warning btn-sm" onclick="editUser(${user.id})" title="Edit"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})" title="Delete"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `);
    });
}

function initializeDataTable() {
    if (dataTable) dataTable.destroy();
    dataTable = $('#usersTable').DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        searching: true,
        ordering: true,
        info: true,
        paging: true,
        pageLength: 10
    });
}

function getRoleBadge(role) {
    switch (role) {
        case 'admin': return '<span class="badge badge-danger">Admin</span>';
        case 'user': return '<span class="badge badge-success">User</span>';
        default: return `<span class="badge badge-secondary">${role}</span>`;
    }
}

function showAlert(message, type = 'success') {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-triangle' : 'info-circle'}"></i>
            ${message}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    `;
    $('#alertContainer').html(alertHtml);
    setTimeout(() => $('.alert').alert('close'), 5000);
}

// Form handlers
$('#addUserForm').on('submit', function(e) {
    e.preventDefault();
    const formData = {
        username: $('#addUsername').val(),
        email: $('#addEmail').val(),
        password: $('#addPassword').val(),
        role: $('#addRole').val()
    };
    $.ajax({
        url: 'api.php',
        type: 'POST',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        dataType: 'json',
        success: function(res) {
            if (res.success) {
                $('#addUserModal').modal('hide');
                $('#addUserForm')[0].reset();
                showAlert(res.message, 'success');
                loadUsers();
            } else {
                showAlert(res.error, 'danger');
            }
        },
        error: function(xhr) {
            const err = xhr.responseJSON?.error || 'Error adding user';
            showAlert(err, 'danger');
        }
    });
});

function editUser(id) {
    const user = users.find(u => u.id === id);
    if (user) {
        $('#editUserId').val(user.id);
        $('#editUsername').val(user.username);
        $('#editEmail').val(user.email);
        $('#editPassword').val('');
        $('#editRole').val(user.role);
        $('#editUserModal').modal('show');
    }
}

$('#editUserForm').on('submit', function(e) {
    e.preventDefault();
    const formData = {
        id: parseInt($('#editUserId').val()),
        username: $('#editUsername').val(),
        email: $('#editEmail').val(),
        role: $('#editRole').val()
    };
    const password = $('#editPassword').val();
    if (password) formData.password = password;
    $.ajax({
        url: 'api.php',
        type: 'PUT',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        dataType: 'json',
        success: function(res) {
            if (res.success) {
                $('#editUserModal').modal('hide');
                showAlert(res.message, 'success');
                loadUsers();
            } else {
                showAlert(res.error, 'danger');
            }
        },
        error: function(xhr) {
            const err = xhr.responseJSON?.error || 'Error updating user';
            showAlert(err, 'danger');
        }
    });
});

function deleteUser(id) {
    const user = users.find(u => u.id === id);
    if (user) {
        currentDeleteId = id;
        $('#deleteUserName').text(user.username);
        $('#deleteUserEmail').text(user.email);
        $('#deleteUserRole').text(user.role);
        $('#deleteUserModal').modal('show');
    }
}

$('#confirmDeleteBtn').on('click', function() {
    if (currentDeleteId) {
        $.ajax({
            url: 'api.php?id=' + currentDeleteId,
            type: 'DELETE',
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    $('#deleteUserModal').modal('hide');
                    currentDeleteId = null;
                    showAlert(res.message, 'success');
                    loadUsers();
                } else {
                    showAlert(res.error, 'danger');
                }
            },
            error: function(xhr) {
                const err = xhr.responseJSON?.error || 'Error deleting user';
                showAlert(err, 'danger');
            }
        });
    }
});

function viewUser(id) {
    const user = users.find(u => u.id === id);
    if (user) {
        $('#viewUserId').text(user.id);
        $('#viewUserName').text(user.username);
        $('#viewUserEmail').text(user.email);
        $('#viewUserRole').text(user.role);
        $('#viewUserModal').modal('show');
    }
}

// Reset forms when modals are hidden
$('#addUserModal, #editUserModal').on('hidden.bs.modal', function () {
    $(this).find('form')[0].reset();
});
</script>

</body>
</html>