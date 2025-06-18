<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../db.php';

// Database connection
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

// Get request method and data
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

try {
    switch ($method) {
        case 'GET':
            handleGet($pdo);
            break;
        case 'POST':
            handlePost($pdo, $input);
            break;
        case 'PUT':
            handlePut($pdo, $input);
            break;
        case 'DELETE':
            handleDelete($pdo);
            break;
        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

// Handle GET request - Retrieve all users
function handleGet($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT id, username, email, role FROM users ORDER BY id ASC");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'data' => $users,
            'count' => count($users)
        ]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to fetch users: ' . $e->getMessage()]);
    }
}

// Handle POST request - Create new user
function handlePost($pdo, $input) {
    // Validate input
    if (!$input || !isset($input['username']) || !isset($input['email']) || !isset($input['password'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Missing required fields: username, email, password']);
        return;
    }
    
    $username = trim($input['username']);
    $email = trim($input['email']);
    $password = $input['password'];
    $role = isset($input['role']) ? $input['role'] : 'user';
    
    // Validate data
    if (empty($username)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Username cannot be empty']);
        return;
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid email address']);
        return;
    }
    
    if (strlen($password) < 6) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Password must be at least 6 characters long']);
        return;
    }
    
    if (!in_array($role, ['user', 'admin'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid role. Must be user, moderator, or admin']);
        return;
    }
    
    try {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            http_response_code(409);
            echo json_encode(['success' => false, 'error' => 'Username already exists']);
            return;
        }
        
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            http_response_code(409);
            echo json_encode(['success' => false, 'error' => 'Email already exists']);
            return;
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword, $role]);
        
        $userId = $pdo->lastInsertId();
        
        echo json_encode([
            'success' => true,
            'message' => 'User created successfully',
            'data' => [
                'id' => $userId,
                'username' => $username,
                'email' => $email,
                'role' => $role
            ]
        ]);
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to create user: ' . $e->getMessage()]);
    }
}

// Handle PUT request - Update user
function handlePut($pdo, $input) {
    // Validate input
    if (!$input || !isset($input['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Missing user ID']);
        return;
    }
    
    $id = (int)$input['id'];
    $username = isset($input['username']) ? trim($input['username']) : null;
    $email = isset($input['email']) ? trim($input['email']) : null;
    $password = isset($input['password']) ? $input['password'] : null;
    $role = isset($input['role']) ? $input['role'] : null;
    
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid user ID']);
        return;
    }
    
    try {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT username, email, role FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$existingUser) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'User not found']);
            return;
        }
        
        // Prepare update data
        $updateFields = [];
        $updateValues = [];
        
        if ($username !== null) {
            if (empty($username)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Username cannot be empty']);
                return;
            }
            
            // Check if username already exists (excluding current user)
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
            $stmt->execute([$username, $id]);
            if ($stmt->fetch()) {
                http_response_code(409);
                echo json_encode(['success' => false, 'error' => 'Username already exists']);
                return;
            }
            
            $updateFields[] = "username = ?";
            $updateValues[] = $username;
        }
        
        if ($email !== null) {
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid email address']);
                return;
            }
            
            // Check if email already exists (excluding current user)
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $id]);
            if ($stmt->fetch()) {
                http_response_code(409);
                echo json_encode(['success' => false, 'error' => 'Email already exists']);
                return;
            }
            
            $updateFields[] = "email = ?";
            $updateValues[] = $email;
        }
        
        if ($password !== null && !empty($password)) {
            if (strlen($password) < 6) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Password must be at least 6 characters long']);
                return;
            }
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateFields[] = "password = ?";
            $updateValues[] = $hashedPassword;
        }
        
        if ($role !== null) {
            if (!in_array($role, ['user', 'moderator', 'admin'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid role. Must be user, moderator, or admin']);
                return;
            }
            
            $updateFields[] = "role = ?";
            $updateValues[] = $role;
        }
        
        if (empty($updateFields)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'No fields to update']);
            return;
        }
        
        // Add user ID to values
        $updateValues[] = $id;
        
        // Execute update
        $sql = "UPDATE users SET " . implode(', ', $updateFields) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($updateValues);
        
        // Get updated user data
        $stmt = $pdo->prepare("SELECT id, username, email, role FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $updatedUser = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $updatedUser
        ]);
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to update user: ' . $e->getMessage()]);
    }
}

// Handle DELETE request - Delete user
function handleDelete($pdo) {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Missing user ID']);
        return;
    }
    
    $id = (int)$_GET['id'];
    
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid user ID']);
        return;
    }
    
    try {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'User not found']);
            return;
        }
        
        // Delete user
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'User deleted successfully',
                'deleted_user' => $user['username']
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to delete user']);
        }
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to delete user: ' . $e->getMessage()]);
    }
}

// Utility function to validate user data
function validateUserData($data, $isUpdate = false) {
    $errors = [];
    
    if (!$isUpdate || isset($data['username'])) {
        if (empty($data['username'])) {
            $errors[] = 'Username is required';
        } elseif (strlen($data['username']) < 3) {
            $errors[] = 'Username must be at least 3 characters long';
        } elseif (strlen($data['username']) > 50) {
            $errors[] = 'Username must not exceed 50 characters';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
            $errors[] = 'Username can only contain letters, numbers, and underscores';
        }
    }
    
    if (!$isUpdate || isset($data['email'])) {
        if (empty($data['email'])) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        } elseif (strlen($data['email']) > 100) {
            $errors[] = 'Email must not exceed 100 characters';
        }
    }
    
    if (!$isUpdate || isset($data['password'])) {
        if (!$isUpdate && empty($data['password'])) {
            $errors[] = 'Password is required';
        } elseif (!empty($data['password']) && strlen($data['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters long';
        } elseif (!empty($data['password']) && strlen($data['password']) > 255) {
            $errors[] = 'Password is too long';
        }
    }
    
    if (isset($data['role']) && !in_array($data['role'], ['user', 'moderator', 'admin'])) {
        $errors[] = 'Invalid role. Must be user, moderator, or admin';
    }
    
    return $errors;
}

// Error handler
function handleError($message, $code = 500) {
    http_response_code($code);
    echo json_encode(['success' => false, 'error' => $message]);
    exit();
}
?>