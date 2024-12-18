<?php
header('Content-Type: application/json');

$host = '127.0.0.1';
$db   = 'php_study';
$user = 'root';
$pass = 'mypass';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}


// A helper function to read the request body as JSON
function getJsonInput() {
    $input = file_get_contents('php://input');
    return json_decode($input, true);
}

// Parse the request
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$basePath = '/'; // If this file is accessible at root. Adjust if needed.
$path = str_replace($basePath, '', $uri);
$path = trim($path, '/');

// Split path into segments

// Expected routes: tasks or tasks/{id}
$resource = $segments[0] ?? '';


switch($method) {
    case 'GET':
        $resource = $_GET['resource'] ?? '';
        $segments = explode('/', $resource);
        $id = $segments[2] ?? null;
        if ($id) {
            // GET /tasks/{id}
            getTask($pdo, $id);
        } else {
            // GET /tasks?filter=...
            $filter = $_GET['filter'] ?? 'all';
            getTasks($pdo, $filter);
        }
        break;
    case 'POST':
        // POST /tasks
        createTask($pdo);
        break;
    case 'PUT':
        // PUT /tasks/{id}
        $resource = $_GET['resource'] ?? '';
        $segments = explode('/', $resource);
        $id = $segments[2] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Task ID is required']);
            exit;
        }
        updateTask($pdo, $id);
        break;
    case 'DELETE':
        $resource = $_GET['resource'] ?? '';
        $segments = explode('/', $resource);
        $id = $segments[2] ?? null;
        // DELETE /tasks/{id}
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Task ID is required']);
            exit;
        }
        deleteTask($pdo, $id);
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

// Functions for each action

function getTasks($pdo, $filter) {
    $where = '';
    if ($filter === 'completed') {
        $where = 'WHERE completed = 1';
    } elseif ($filter === 'active') {
        $where = 'WHERE completed = 0';
    }

    $stmt = $pdo->query("SELECT id, title, completed FROM tasks $where ORDER BY id ASC");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($tasks);
}

function getTask($pdo, $id) {
    $stmt = $pdo->prepare("SELECT id, title, completed FROM tasks WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        http_response_code(404);
        echo json_encode(['error' => 'Task not found']);
        return;
    }

    echo json_encode($task);
}

function createTask($pdo) {
    $data = getJsonInput();
    if (!isset($data['title']) || trim($data['title']) === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Title is required']);
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO tasks (title) VALUES (:title)");
    $stmt->execute([':title' => trim($data['title'])]);
    $id = $pdo->lastInsertId();

    // Return the created task
    http_response_code(201);
    echo json_encode([
        'id' => $id,
        'title' => trim($data['title']),
        'completed' => 0
    ]);
}

function updateTask($pdo, $id) {
    $data = getJsonInput();

    // Check if task exists
    $stmt = $pdo->prepare("SELECT id, title, completed FROM tasks WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        http_response_code(404);
        echo json_encode(['error' => 'Task not found']);
        return;
    }

    $newTitle = isset($data['title']) ? trim($data['title']) : $task['title'];
    $newCompleted = isset($data['completed']) ? (int)$data['completed'] : $task['completed'];

    $updateStmt = $pdo->prepare("UPDATE tasks SET title = :title, completed = :completed WHERE id = :id");
    $updateStmt->execute([
        ':title' => $newTitle,
        ':completed' => $newCompleted,
        ':id' => $id
    ]);

    echo json_encode([
        'id' => $id,
        'title' => $newTitle,
        'completed' => $newCompleted
    ]);
}

function deleteTask($pdo, $id) {
    // Check if task exists
    $stmt = $pdo->prepare("SELECT id FROM tasks WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        http_response_code(404);
        echo json_encode(['error' => 'Task not found']);
        return;
    }

    $deleteStmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $deleteStmt->execute([':id' => $id]);

    http_response_code(204); // No Content
}
