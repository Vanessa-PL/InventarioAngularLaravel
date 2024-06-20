<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/app.css" />
    <title>Inventario</title>
</head>

<body>
    <div class="table">
        <div class="table_header">
            <h2>Inventario de productos</h2>
            <button class="add_new" onclick="toggleModal('create-form-modal')">Agregar producto</button>
            <div>
                <input id="codigoProductoInput" placeholder="Codigo de producto">
                <button onclick="buscarProducto()">Buscar</button>
            </div>
        </div>
        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>Codigo de producto</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="productos-body">
                </tbody>
            </table>
        </div>
    </div>

    <!-- Formulario para agregar un nuevo producto -->
    <div id="create-form-modal" class="modal">
        <h2>Agregar nuevo producto</h2>
        <form id="create-product-form">
            <label for="create-CodigoProducto">Codigo de Producto:</label>
            <input type="text" id="create-CodigoProducto" name="CodigoProducto" required><br><br>

            <label for="create-Nombre">Nombre:</label>
            <input type="text" id="create-Nombre" name="Nombre" required><br><br>

            <label for="create-Cantidad">Cantidad:</label>
            <input type="number" id="create-Cantidad" name="Cantidad" required><br><br>

            <label for="create-PrecioUnitario">Precio Unitario:</label>
            <input type="number" id="create-PrecioUnitario" name="PrecioUnitario" required><br><br>

            <label for="create-Total">Total:</label>
            <input type="number" id="create-Total" name="Total" required><br><br>

            <button type="submit">Guardar</button>
            <button type="button" onclick="toggleModal('create-form-modal')">Cancelar</button>
        </form>
    </div>

    <!-- Formulario para actualizar un producto -->
    <div id="update-form-modal" class="modal">
        <h2>Actualizar producto</h2>
        <form id="update-product-form"
            onsubmit="event.preventDefault(); actualizarProducto(document.getElementById('update-CodigoProducto').value);">
            <input type="hidden" id="update-CodigoProducto" name="CodigoProducto" required><br><br>

            <label for="update-Nombre">Nombre:</label>
            <input type="text" id="update-Nombre" name="Nombre" required><br><br>

            <label for="update-Cantidad">Cantidad:</label>
            <input type="number" id="update-Cantidad" name="Cantidad" required><br><br>

            <label for="update-PrecioUnitario">Precio Unitario:</label>
            <input type="number" id="update-PrecioUnitario" name="PrecioUnitario" required><br><br>

            <label for="update-Total">Total:</label>
            <input type="number" id="update-Total" name="Total" required><br><br>

            <button type="submit">Actualizar</button>
            <button type="button" onclick="toggleModal('update-form-modal')">Cancelar</button>
        </form>
    </div>

    <!-- Overlay para el modal -->
    <div id="overlay" class="overlay"></div>

    <script>
        // Enviar datos del formulario de creación a la API
        document.getElementById('create-product-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            fetch('/api/productos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 201) {
                        alert('Producto creado exitosamente');
                        location.reload();
                    } else {
                        alert('Error al crear el producto');
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Función para mostrar el formulario de actualización en el modal
        function showUpdateForm(producto) {
            document.getElementById('update-CodigoProducto').value = producto.CodigoProducto;
            document.getElementById('update-Nombre').value = producto.Nombre;
            document.getElementById('update-Cantidad').value = producto.Cantidad;
            document.getElementById('update-PrecioUnitario').value = producto.PrecioUnitario;
            document.getElementById('update-Total').value = producto.Total;
            toggleModal('update-form-modal');
        }

        // Función para actualizar un producto
        // Función para actualizar un producto
        function actualizarProducto(codigoProducto) {
            const updatedData = {
                Nombre: document.getElementById('update-Nombre').value,
                Cantidad: document.getElementById('update-Cantidad').value,
                PrecioUnitario: document.getElementById('update-PrecioUnitario').value,
                Total: document.getElementById('update-Total').value
            };

            console.log('Actualizando producto:', codigoProducto, 'con datos:', updatedData);

            fetch(`/api/productos/${codigoProducto}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(updatedData),
                })
                .then(response => {
                    if (response.ok) {
                        alert('Producto actualizado correctamente');
                        window.location.reload(); // Recargar la página después de la actualización
                    } else {
                        alert('Error al actualizar el producto');
                    }
                })
                .catch(error => console.error('Error al actualizar el producto:', error));
        }




        // Función para mostrar u ocultar un modal y el overlay
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            const overlay = document.getElementById('overlay');

            if (modal.style.display === 'block') {
                modal.style.display = 'none';
                overlay.style.display = 'none';
            } else {
                modal.style.display = 'block';
                overlay.style.display = 'block';
            }
        }

        //Buscar producto
        function buscarProducto() {
            const codigoProducto = document.getElementById('codigoProductoInput').value;

            fetch(`/api/productos/${codigoProducto}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Respuesta de la API:', data);

                    if (data.status === 200 && data.Producto) {
                        const producto = data.Producto;
                        const productosBody = document.getElementById('productos-body');

                        // Limpiar el contenido existente de la tabla
                        productosBody.innerHTML = '';

                        // Crear una nueva fila con los datos del producto
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${producto.CodigoProducto}</td>
                            <td>${producto.Nombre}</td>
                            <td>${producto.Cantidad}</td>
                            <td>${producto.PrecioUnitario}</td>
                            <td>${producto.Total}</td>
                            <td>
                                <button onclick='showUpdateForm(${JSON.stringify(producto)})'>Actualizar</button>
                                <button onclick="eliminarProducto('${producto.CodigoProducto}')">Eliminar</button>
                            </td>
                        `;

                        // Agregar la nueva fila a la tabla
                        productosBody.appendChild(row);
                    } else {
                        alert('Producto no encontrado');
                    }
                })
                .catch(error => console.error('Error al buscar el producto:', error));
        }


        // Obtener los productos desde la API y mostrar en la tabla
        fetch('/api/productos')
            .then(response => response.json())
            .then(data => {
                const productos = data.Productos;
                const productosBody = document.getElementById('productos-body');

                productos.forEach(producto => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${producto.CodigoProducto}</td>
                        <td>${producto.Nombre}</td>
                        <td>${producto.Cantidad}</td>
                        <td>${producto.PrecioUnitario}</td>
                        <td>${producto.Total}</td>
                        <td>
                            <button onclick='showUpdateForm(${JSON.stringify(producto)})'>Actualizar</button>
                            <button onclick="eliminarProducto('${producto.CodigoProducto}')">Eliminar</button>
                        </td>
                    `;
                    productosBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error al obtener los productos:', error));


        // Función para eliminar un producto
        function eliminarProducto(codigoProducto) {
            if (confirm('¿Estás seguro de eliminar este producto?')) {
                fetch(`/api/productos/${codigoProducto}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            alert('Producto eliminado correctamente');
                            window.location.reload(); // Recargar la página para actualizar la lista de productos
                        } else {
                            alert('Error al eliminar el producto');
                        }
                    })
                    .catch(error => console.error('Error al eliminar el producto:', error));
            }
        }
    </script>

</body>

</html>
