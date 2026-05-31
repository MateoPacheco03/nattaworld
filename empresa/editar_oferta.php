<?php
session_start();
require_once '../includes/Oferta.class.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'empresa') {
    header('Location: ../login.php');
    exit();
}

$errores = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $titulo = htmlspecialchars($_POST['titulo']);
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $ubicacion = htmlspecialchars($_POST['ubicacion']);
    $area = htmlspecialchars($_POST['area']);

    if ($titulo && $area) {
        if (Oferta::actualizar($id, $titulo, $descripcion, $ubicacion, $area)) {
            header('Location: mis_ofertas.php?mensaje=oferta_actualizada');
            exit();
        } else {
            $errores = "Error al actualizar la oferta";
        }
    } else {
        $errores = "El titulo y el area son obligatorios";
    }
} else {
    $id = $_GET['id'];
    $oferta = Oferta::obtener($id);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Natt World — Editar oferta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylos.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
</head>
<body>

<?php include '../includes/navbar.php'; ?>

<main>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="fw-bold mb-4">Editar oferta</h2>
                <?php if ($errores): ?>
                    <div class="alert alert-danger"><?php echo $errores; ?></div>
                <?php endif; ?>
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $oferta['id']; ?>">
                            <div class="mb-3">
                                <label class="form-label">Titulo de la oferta</label>
                                <input type="text" name="titulo" class="form-control" value="<?php echo htmlspecialchars($oferta['titulo']); ?>" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Area profesional</label>
                                    <input type="text" name="area" class="form-control" value="<?php echo htmlspecialchars($oferta['area']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ubicacion</label>
                                    <input type="text" name="ubicacion" class="form-control" value="<?php echo htmlspecialchars($oferta['ubicacion']); ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripcion</label>
                                <textarea name="descripcion" class="form-control" rows="5"><?php echo htmlspecialchars($oferta['descripcion']); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Guardar cambios</button>
                            <a href="mis_ofertas.php" class="btn btn-outline-secondary w-100 mt-2">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>