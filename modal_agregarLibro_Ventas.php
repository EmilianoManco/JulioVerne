<div class="modal fade" id="agregarLibro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #DB7035 !important;">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Seleccionar Libro</h4>
            </div>

            <div class="modal-body">
                    <form action="buscar.php">
                        <input type="text" name="buscador" id="buscador" placeholder="Nombre del Libro" autocomplete="off">
                        <button type="submit" disabled hidden aria-hidden="true"></button>
                    </form>

                    <table class="table table-sm">
                        <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Stock Disponible</th>
                                    <th scope="col">Elegir</th>
                                </tr>
                        </thead>
                        <tbody id="content">



                        </tbody>             
                    </table>



            

            <div class="modal-footer">
                <!-- <input type="submit" class='btn btn-primary' value="Confirmar">  -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
    getData();

    document.getElementById("buscador").addEventListener("keyup", getData);

    function getData() {
        let inputElement = document.getElementById("buscador");
        let contentElement = document.getElementById("content");

        if (inputElement && contentElement) { //aca muestro la tabla con los datos de load.php
            let input = inputElement.value;
            let url = "buscar.php";
            let formaData = new FormData();
            formaData.append('buscador', input);

            fetch(url, {
                method: "POST",
                body: formaData
            }).then(response => response.json())
            .then(data => {
                contentElement.innerHTML = data;
            }).catch(error => console.log(error));
        } else {
            console.error("Elementos no encontrados en el DOM.");
        }
    }
});
</script>