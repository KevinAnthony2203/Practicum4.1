<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar cita</title>
</head>
<body>
    <h1>Hospital Isidro Ayora de la Ciudad de Loja</h1>
    <h2>Agendar Cita</h2>
    <!--Inicio e formulario-->
    <div>
        <form>
            <label for="Nombres">Nombre</label>
            <input type="text" class="form-control" id="nombre" placeholder="Ej:Andres Nicolas">
        </form>
    </div>
    <div>
        <form action="Apelidos">Apellido</form>
        <input type="text" class="form-control" id="apellido" placeholder="Ej: Martinez Reina">
    </div>
    <div>
    <select class="form-select" aria-label="Disabled select example">
            <option selected>Seleccionar especilidad</option>
            <option value="1">Especilidad 1</option>
            <option value="2">Especilidad 2</option>
            <option value="3">Especilidad 3</option>
        </select>
    </div>
    <div>
        <select class="form-select" aria-label="Disabled select example">
            <option selected>Seleccionar médico</option>
            <option value="1">Médico 1</option>
            <option value="2">Médico 2</option>
            <option value="3">Médico 3</option>
        </select>
    </div>
    <div>
        <form>
            <label for="fecha">Seleccionar una fecha de cita</label>
            <input type="date" id="fecha" name="fecha">
        </form>
    </div>
    <div>

    </div>
</body>
</html><?php /**PATH C:\laragon\www\proyectoPracticum\resources\views/register.blade.php ENDPATH**/ ?>