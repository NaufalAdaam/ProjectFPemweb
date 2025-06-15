<?php
require_once '../db.php';
?>
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
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">
  <style>
    .action-buttons .btn {
      margin-right: 5px;
      margin-bottom: 5px;
    }
    .modal-header.bg-primary {
      background-color: #007bff !important;
    }
    .modal-header.bg-warning {
      background-color: #ffc107 !important;
    }
    .modal-header.bg-danger {
      background-color: #dc3545 !important;
    }
    .loading {
      text-align: center;
      padding: 20px;
    }
    .role-admin { color: #dc3545; font-weight: bold; }
    .role-user { color: #28a745; }
  </style>
</head>
<body class="hold-transition layout-top-nav">
  <div class="wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid mt-4">
        <div class="row">
          <div class="col-12">
            <h2 class="mb-3"><i class="fas fa-users"></i> User Management System</h2>

            <!-- Alert Messages -->
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
                  <table id="usersTable" class="table table-striped table-hover">
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

            <a href="index.php" class="btn btn-secondary mt-3">
              <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
          </div>
        </div>
      </div>
    </section>

  </div>

  <!-- Add User Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title"><i class="fas fa-user-plus"></i> Add New User</h5>
          <button type="button" class="close text-white" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <form id="addUserForm">
          <div class="modal-body">
            <div class="form-group">
              <label for="addUsername"><i class="fas fa-user"></i> Username</label>
              <input type="text" class="form-control" id="addUsername" name="username" required>
            </div>
            <div class="form-group">
              <label for="addEmail"><i class="fas fa-envelope"></i> Email Address</label>
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
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Add User
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit User Modal -->
  <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title"><i class="fas fa-user-edit"></i> Edit User</h5>
          <button type="button" class="close text-white" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <form id="editUserForm">
          <div class="modal-body">
            <input type="hidden" id="editUserId" name="id">
            <div class="form-group">
              <label for="editUsername"><i class="fas fa-user"></i> Username</label>
              <input type="text" class="form-control" id="editUsername" name="username" required>
            </div>
            <div class="form-group">
              <label for="editEmail"><i class="fas fa-envelope"></i> Email Address</label>
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
            <button type="submit" class="btn btn-warning">
              <i class="fas fa-save"></i> Update User
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete User Modal -->
  <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title"><i class="fas fa-trash"></i> Delete User</h5>
          <button type="button" class="close text-white" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this user?</p>
          <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Warning:</strong> This action cannot be undone!
          </div>
          <p><strong>User Details:</strong></p>
          <ul>
            <li><strong>Username:</strong> <span id="deleteUserName"></span></li>
            <li><strong>Email:</strong> <span id="deleteUserEmail"></span></li>
            <li><strong>Role:</strong> <span id="deleteUserRole"></span></li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
            <i class="fas fa-trash"></i> Delete User
          </button>
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
          <button type="button" class="close text-white" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <p><strong>ID:</strong> <span id="viewUserId"></span></p>
              <p><strong>Username:</strong> <span id="viewUserName"></span></p>
              <p><strong>Email:</strong> <span id="viewUserEmail"></span></p>
            </div>
            <div class="col-md-6">
              <p><strong>Role:</strong> <span id="viewUserRole"></span></p>
            </div>
          </div>
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

  <script>
    let users = [];
    let currentDeleteId = null;
    let dataTable = null;

    // Initialize when document is ready
    $(document).ready(function() {
      loadUsers();
    });

    // Load users from database
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
          showAlert('Error loading users: ' + error, 'danger');
        }
      });
    }

    // Render users table
    function renderUsersTable() {
      const tbody = document.getElementById('usersTableBody');
      tbody.innerHTML = '';
      
      if (users.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">No users found</td></tr>';
        return;
      }
      
      users.forEach((user, index) => {
        const roleBadge = getRoleBadge(user.role);
        
        const row = `
          <tr>
            <td>${index + 1}</td>
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td>${roleBadge}</td>
            <td class="action-buttons">
              <button class="btn btn-info btn-sm" onclick="viewUser(${user.id})" title="View">
                <i class="fas fa-eye"></i>
              </button>
              <button class="btn btn-warning btn-sm" onclick="editUser(${user.id})" title="Edit">
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})" title="Delete">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
        `;
        tbody.innerHTML += row;
      });
    }

    // Initialize or reinitialize DataTable
    function initializeDataTable() {
      if (dataTable) {
        dataTable.destroy();
      }
      
      dataTable = $('#usersTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "paging": true,
        "pageLength": 10
      });
    }

    // Get role badge HTML
    function getRoleBadge(role) {
      switch(role) {
        case 'admin':
          return '<span class="badge badge-danger">Admin</span>';
        case 'user':
          return '<span class="badge badge-success">User</span>';
        default:
          return '<span class="badge badge-secondary">' + role + '</span>';
      }
    }

    // Show alert message
    function showAlert(message, type = 'success') {
      const alertContainer = document.getElementById('alertContainer');
      const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
          <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-triangle' : 'info-circle'}"></i>
          ${message}
          <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
          </button>
        </div>
      `;
      alertContainer.innerHTML = alertHtml;
      
      // Auto hide after 5 seconds
      setTimeout(() => {
        $('.alert').alert('close');
      }, 5000);
    }

    // Add user form submission
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
        success: function(response) {
          if (response.success) {
            $('#addUserModal').modal('hide');
            $('#addUserForm')[0].reset();
            showAlert(response.message, 'success');
            loadUsers(); // Reload users from database
          } else {
            showAlert(response.error, 'danger');
          }
        },
        error: function(xhr, status, error) {
          const response = xhr.responseJSON;
          const errorMessage = response && response.error ? response.error : 'Error adding user';
          showAlert(errorMessage, 'danger');
        }
      });
    });

    // Edit user function
    function editUser(id) {
      const user = users.find(u => u.id === id);
      if (user) {
        $('#editUserId').val(user.id);
        $('#editUsername').val(user.username);
        $('#editEmail').val(user.email);
        $('#editPassword').val(''); // Clear password field
        $('#editRole').val(user.role);
        $('#editUserModal').modal('show');
      }
    }

    // Update user form submission
    $('#editUserForm').on('submit', function(e) {
      e.preventDefault();
      
      const formData = {
        id: parseInt($('#editUserId').val()),
        username: $('#editUsername').val(),
        email: $('#editEmail').val(),
        role: $('#editRole').val()
      };
      
      // Add password only if it's not empty
      const password = $('#editPassword').val();
      if (password.length > 0) {
        formData.password = password;
      }
      
      $.ajax({
        url: 'api.php',
        type: 'PUT',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('#editUserModal').modal('hide');
            showAlert(response.message, 'success');
            loadUsers(); // Reload users from database
          } else {
            showAlert(response.error, 'danger');
          }
        },
        error: function(xhr, status, error) {
          const response = xhr.responseJSON;
          const errorMessage = response && response.error ? response.error : 'Error updating user';
          showAlert(errorMessage, 'danger');
        }
      });
    });

    // Delete user function
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

    // Confirm delete
    $('#confirmDeleteBtn').on('click', function() {
      if (currentDeleteId) {
        $.ajax({
          url: 'api.php?id=' + currentDeleteId,
          type: 'DELETE',
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              $('#deleteUserModal').modal('hide');
              currentDeleteId = null;
              showAlert(response.message, 'success');
              loadUsers(); // Reload users from database
            } else {
              showAlert(response.error, 'danger');
            }
          },
          error: function(xhr, status, error) {
            const response = xhr.responseJSON;
            const errorMessage = response && response.error ? response.error : 'Error deleting user';
            showAlert(errorMessage, 'danger');
          }
        });
      }
    });

    // View user function
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
    $('#addUserModal').on('hidden.bs.modal', function() {
      $('#addUserForm')[0].reset();
    });

    $('#editUserModal').on('hidden.bs.modal', function() {
      $('#editUserForm')[0].reset();
    });
  </script>
</body>
</html>