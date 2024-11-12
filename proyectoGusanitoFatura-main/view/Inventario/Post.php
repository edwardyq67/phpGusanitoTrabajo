<div class="bg-transparent w-[80%]  rounded-md p-4">

        <button class="py-1 px-3 rounded-t-md bg-blue-600 text-white hover:bg-blue-500 transition-all duration-200">Inventario</button>

        <div id="formCodigo" class="bg-white h-full p-4">
            <div class=" rounded-b-md rounded-tr-md text-sm grid gap-4 h-auto justify-center items-center text-center">
                <div>
                    <label for="isbnInput">
                        <img class="blur-sm w-40 h-auto" src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg6HkGGUlZna7sbOqOQuhQn9XdKLpOYmlr1kmOMT0KY0QNvtsOBQTl7gvkgK1QRmXuonz1Pg2NfBg1clljFEF5z01NwGbDQXo-dODhM1ECllzRhMbACM7Q82QZqkor0k06adj1H2r6GWWum/s1600/Qu%25C3%25A9+es+un+ISBN.png" alt="">
                    </label>
                    <input id="isbnInput" maxlength="13"
                        minlength="13"
                        pattern="\d{13}" name="ISBN" type="text" class="bg-zinc-200 focus:outline-none rounded-md py-1 pl-3 opacity-0" placeholder="ISBN">
                </div>
                <span>ó</span>
                <input id="SKUInput" type="text" maxlength="14"
                    minlength="14"
                    pattern="\d{14}" class="bg-zinc-200 focus:outline-none rounded-md py-1 pl-3" placeholder="SKU">
            </div>
            <div class="flex gap-4">
                <button id="GuardarCodigo" type="submit" class="flex col-span-5 mt-4 py-1 px-3 bg-blue-600 text-white rounded-md hover:bg-blue-500 transition-all duration-200">
                    Guardar
                </button>
                <button id="closeModal" class="flex col-span-5 mt-4 py-1 px-3 bg-red-600 text-white rounded-md hover:bg-red-500 transition-all duration-200">
                    Cancelar modal
                </button>
            </div>
</div>

        <form id="formInfoCodigo" method="POST" class="bg-white h-full p-4 hidden text-sm">
            <input type="hidden" name="accion" value="crear">
            <div class="grid grid-cols-4 gap-4">
                <div class="flex flex-col col-span-2">
                    <label for="segundoFormISBN" class="font-bold mb-1">ISBN: </label>
                    <input name="segundoFormISBN" id="segundoFormISBN" value="isbnInput" type="text" class="bg-zinc-200 focus:outline-none rounded-md py-1 pl-3">
                </div>
                <div class="flex flex-col col-span-2">
                    <label for="segundoFormSKU" class="font-bold mb-1">SKU: </label>
                    <input name="segundoFormSKU" id="segundoFormSKU" value="SKUInput" type="text" class="bg-zinc-200 focus:outline-none rounded-md py-1 pl-3">
                </div>
                <div class="flex flex-col col-span-2">
                    <label for="NombProducto" class="font-bold mb-1">Nombre del Producto: </label>
                    <input name="NombProducto" id="NombProducto" type="text" class="bg-zinc-200 focus:outline-none rounded-md py-1 pl-3">
                </div>
                <div class="flex flex-col col-span-1">
                    <label for="precio" class="font-bold mb-1">Precio: </label>
                    <input name="precio" id="precio" type="number" step="0.01" class="bg-zinc-200 focus:outline-none rounded-md py-1 pl-3">
                </div>

                <div class="flex flex-col col-span-1">
                    <label for="cantidad" class="font-bold mb-1">Cantidad: </label>
                    <input name="cantida" id="cantidad" type="number" class="bg-zinc-200 focus:outline-none rounded-md py-1 pl-3">
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex col-span-5 mt-4 py-1 px-3 bg-blue-600 text-white rounded-md hover:bg-blue-500 transition-all duration-200">
                    Guardar
                </button>
                <button id="closeModal" class="flex col-span-5 mt-4 py-1 px-3 bg-red-600 text-white rounded-md hover:bg-red-500 transition-all duration-200">
                    Cancelar
                </button>
            </div>
        </form>
    </div>