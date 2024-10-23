<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'fragmentos/header.php'; ?>
    <title>Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center poppins-regular">Inicio de Sesión</h1>
        <div class="row justify-content-center mt-4">
            <div class="col-md-4 poppins-regular">
                <?php if (isset($_GET['msg'])) : ?>
                    <?php if ($_GET['msg'] == 'error') : ?>
                        <div class="alert alert-danger">Nombre de usuario o contraseña incorrectos.</div>
                    <?php elseif ($_GET['msg'] == 'empty') : ?>
                        <div class="alert alert-warning">Por favor, complete todos los campos.</div>
                    <?php endif; ?>
                <?php endif; ?>
                <form action="controlador/login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
