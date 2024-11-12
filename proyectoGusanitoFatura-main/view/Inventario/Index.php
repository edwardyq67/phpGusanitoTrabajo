<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($conn)) {
        $isbn = isset($_POST['segundoFormISBN']) ? $_POST['segundoFormISBN'] : '';
        $sku = isset($_POST['segundoFormSKU']) ? $_POST['segundoFormSKU'] : '';
        $nombreProducto = isset($_POST['NombProducto']) ? $_POST['NombProducto'] : '';
        $precio = isset($_POST['precio']) ? $_POST['precio'] : '';
        $cantidad = isset($_POST['cantida']) ? $_POST['cantida'] : '';

        $sql = "INSERT INTO libro (isbn, sku, nombreP, cantidad, precio) VALUES (:isbn, :sku, :nombreProducto, :cantidad, :precio)";

        try {
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':isbn', $isbn);
            $stmt->bindParam(':sku', $sku);
            $stmt->bindParam(':nombreProducto', $nombreProducto);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':precio', $precio);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al insertar el registro: " . $e->getMessage();
        }
    } else {
        echo "Error: La conexión no se ha establecido.";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
    if (isset($conn)) {
        $idEliminar = isset($_POST['idEliminar']) ? $_POST['idEliminar'] : '';

        // Validación de idEliminar como un entero
        if ($idEliminar && filter_var($idEliminar, FILTER_VALIDATE_INT)) {
            // Consulta para eliminar el libro
            $sql = "DELETE FROM libro WHERE id = :id";

            try {
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $idEliminar, PDO::PARAM_INT);

                $stmt->execute();
                header("Location: index.php?page=inventario");
                exit();
            } catch (PDOException $e) {
                echo "Error al eliminar el registro: " . $e->getMessage();
            }
        } else {
            echo "ID inválido para eliminar.";
        }
    } else {
        echo "Error: La conexión no se ha establecido.";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cliente_id'])) {
        $cliente_id = $_POST['cliente_id'];

        // SQL para eliminar el cliente
        $sql = "DELETE FROM cliente WHERE id = :cliente_id"; // Cambia 'id' por el nombre de la columna que identifica a tu cliente

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
            $stmt->execute();

            // Puedes redirigir a la misma página o mostrar un mensaje de éxito
            header("Location: ?page=inventario"); // Cambia esto a la URL donde quieres redirigir después de eliminar
            exit();
        } catch (PDOException $e) {
            echo "Error al eliminar el cliente: " . $e->getMessage();
        }
    }
}
$sqlCheck = "SELECT * FROM libro WHERE id = :id";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bindParam(':id', $idEliminar, PDO::PARAM_INT);
$stmtCheck->execute();
if ($stmtCheck->rowCount() > 0) {
    echo "Registro encontrado, procediendo a eliminar.";
} else {
    echo "No se encontró el registro con ID: " . $idEliminar;
}

?>

<div id="contenido" class="flex flex-col gap-5">
    <section class="bg-slate-50 rounded-md py-4 px-4 flex gap-4 items-center">
        <button id="openModal" class="py-1 px-3 rounded-md bg-green-600 text-white hover:bg-green-500 transition-all duration-200">
            Crear
        </button>

        <form action="" class="relative flex items-center text-sm">
            <label for="Buscar" class="font-bold mr-2">Buscar: </label>
            <input id="Buscar" type="text" class="bg-zinc-200 focus:outline-none rounded-md py-1 pl-3 ">
            <i class="fa-solid fa-magnifying-glass absolute right-0 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500 hover:text-gray-800 transition-all duration-200 px-3"></i>
        </form>
        <form action="" class="flex gap-4 items-center text-sm">
            <div class="flex items-center">
                <label for="" class="font-bold mr-2">Desde:</label>
                <input type="date" class="bg-zinc-200 rounded-md py-1 px-2 focus:outline-none">
            </div>
            <div class="flex items-center">
                <label for="" class="font-bold mr-2">Hasta:</label>
                <input type="date" class="bg-zinc-200 rounded-md py-1 px-2 focus:outline-none">
            </div>
        </form>
    </section>
    <section>
        <div class="overflow-hidden bg-white rounded-md">
            <table
                class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                <thead
                    class=" border-neutral-200 font-medium dark:border-white/10">
                    <tr>
                        <th
                            scope="col"
                            class=" border-neutral-200 px-6 py-4 dark:border-white/10">

                        </th>
                        <th
                            scope="col"
                            class=" border-neutral-200 px-6 py-4 dark:border-white/10">
                            Codigo ISBN
                        </th>
                        <th
                            scope="col"
                            class=" border-neutral-200 px-6 py-4 dark:border-white/10">
                            Codigo SKU
                        </th>
                        <th scope="col" class="px-6 py-4">Nom. Prducto</th>
                        <th scope="col" class="px-6 py-4">Cantidad</th>
                        <th scope="col" class="px-6 py-4">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $libro): ?>
                        <tr class="border-neutral-200 dark:border-white/10">
                            <td class="whitespace-nowrap flex gap-2 border-neutral-200 px-6 py-4 font-medium dark:border-white/10">
                                <button id="openModalCrear" class="py-1 px-3 rounded-md bg-yellow-600 text-white hover:bg-yellow-500 transition-all duration-200">Editar</button>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="idEliminar" value="<?php echo $libro['id']; ?>">
                                    <button type="submit" class="py-1 px-3 rounded-md bg-red-600 text-white hover:bg-red-500 transition-all duration-200">Eliminar</button>
                                </form>
                            </td>
                            <td class="whitespace-nowrap border-neutral-200 px-6 py-4 dark:border-white/10">
                                <?php echo htmlspecialchars($libro['isbn']); ?>
                            </td>
                            <td class="whitespace-nowrap border-neutral-200 px-6 py-4 dark:border-white/10">
                                <?php echo htmlspecialchars($libro['sku']); ?>
                            </td>
                            <td class="whitespace-nowrap border-neutral-200 px-6 py-4 dark:border-white/10">
                                <?php echo htmlspecialchars($libro['nombreP']); ?>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <?php echo htmlspecialchars($libro['cantidad']); ?>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <?php echo htmlspecialchars($libro['precio']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </section>
    <section>
        <div>
            <ul class="list-style-none flex">
                <li>
                    <a
                        class="pointer-events-none relative block rounded bg-transparent px-3 py-1.5 text-sm text-surface/50 transition duration-300 dark:text-neutral-400">Previous</a>
                </li>
                <li>
                    <a
                        class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-surface transition duration-300 hover:bg-neutral-100 focus:bg-neutral-100 focus:text-primary-700 focus:outline-none active:bg-neutral-100 active:text-primary-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700  dark:focus:text-primary-500 dark:active:bg-neutral-700 dark:active:text-primary-500"
                        href="#!">1</a>
                </li>
                <li aria-current="page">
                    <a
                        class="relative block rounded bg-primary-100 px-3 py-1.5 text-sm font-medium text-primary-700 transition duration-300 focus:outline-none dark:bg-slate-900 dark:text-primary-500"
                        href="#!">2
                        <span
                            class="absolute -m-px h-px w-px overflow-hidden whitespace-nowrap border-0 p-0 [clip:rect(0,0,0,0)]">(current)</span>
                    </a>
                </li>
                <li>
                    <a
                        class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-surface transition duration-300 hover:bg-neutral-100 focus:bg-neutral-100 focus:text-primary-700 focus:outline-none active:bg-neutral-100 active:text-primary-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:focus:text-primary-500 dark:active:bg-neutral-700 dark:active:text-primary-500"
                        href="#!">3</a>
                </li>
                <li>
                    <a
                        class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-surface transition duration-300 hover:bg-neutral-100 focus:bg-neutral-100 focus:text-primary-700 focus:outline-none active:bg-neutral-100 active:text-primary-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:focus:text-primary-500 dark:active:bg-neutral-700 dark:active:text-primary-500"
                        href="#!">Next</a>
                </li>
            </ul>
        </div>
    </section>
</div>


<div id="crear" class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-50 ">
    <?php include('Post.php') ?>
</div>

<div id="editar" class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-50 ">
    <?php include('Put.php')?>
</div>
<style>
    #contenido {
        display: grid;
        min-height: 88vh;
        grid-template-rows:
            auto 1fr auto;
    }
</style>

<script>
    // modal crear
    const openModal = document.getElementById('openModal');
    const closeModal = document.getElementById('closeModal');
    const modal = document.getElementById('crear');
    const isbnInput = document.getElementById('isbnInput');
    const skuInput = document.getElementById('SKUInput')
    const GuardarCodigo = document.getElementById('GuardarCodigo')

    openModal.addEventListener('click', () => {
        modal.classList.remove('hidden');
        isbnInput.focus();
    });

    closeModal.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
    // validacion del codigo
    const formCodigo = document.getElementById('formCodigo');
    const formInfoCodigo = document.getElementById('formInfoCodigo');
    const segundoFormISBN = document.getElementById('segundoFormISBN');
    const segundoFormSKU = document.getElementById('segundoFormSKU');

    document.getElementById('GuardarCodigo').addEventListener('click', (event) => {
        event.preventDefault();

        const isbnInputValid = isbnInput.value.length === 13 && /^\d{13}$/.test(isbnInput.value);
        const skuInputValid = skuInput.value.length === 14

        if (isbnInputValid || skuInputValid) {

            formCodigo.classList.add('hidden');

            formInfoCodigo.classList.remove('hidden');

            if (isbnInput) {
                segundoFormISBN.value = isbnInput.value

            }
            if (SKUInput) {
                segundoFormSKU.value = SKUInput.value
            }
        } else {
            alert("Por favor, ingresa un ISBN de 13 dígitos o un SKU de 14 dígitos.");
        }
    });

    // Modal y Formulario
    const openModalCrear = document.getElementById('openModalCrear');
    const editar = document.getElementById('editar');
    const isbnInputEditar = document.getElementById('isbnInputEditar');
    const SKUInputEditar = document.getElementById('SKUInputcrear'); // Corregido el id aquí
    const closeModalEditar = document.getElementById('closeModalEditar');

    openModalCrear.addEventListener('click', () => {
        editar.classList.remove('hidden');
        isbnInputEditar.focus();
    });

    closeModalEditar.addEventListener('click', () => {
        editar.classList.add('hidden');
    });

    window.addEventListener('click', (event) => {
        if (event.target === editar) {
            editar.classList.add('hidden');
        }
    });

    // Validación del formulario de códigos
    const formCodigoEdit = document.getElementById('formCodigoEdit');
    const formInfoCodigoEdit = document.getElementById('formInfoCodigoEdit');
    const segundoFormISBNEdit = document.getElementById('segundoFormISBN');
    const segundoFormSKUEdit = document.getElementById('segundoFormSKU');

    document.getElementById('GuardarCodigoEditar').addEventListener('click', (event) => {
        event.preventDefault();

        const isbnInputEditarValidar = isbnInputEditar.value.length === 13 && /^\d{13}$/.test(isbnInputEditar.value);

        const SKUInputEditarValidar = SKUInputEditar.value.length === 14 && /^\d{14}$/.test(SKUInputEditar.value);

        if (isbnInputEditarValidar || SKUInputEditarValidar) {
            formCodigoEdit.classList.add('hidden');
            formInfoCodigoEdit.classList.remove('hidden');

            if (isbnInputEditarValidar) {
                segundoFormISBNEdit.value = isbnInputEditar.value;
            }

            if (SKUInputEditarValidar) {
                segundoFormSKUEdit.value = SKUInputEditar.value;
            }
        } else {
            alert('Por favor, ingrese un ISBN de 13 dígitos o un SKU de 14 dígitos.');
        }
    });
</script>