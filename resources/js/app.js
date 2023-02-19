import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

console.log("Progrmador:\n %cElianLvX", "color:#00ff00; font-size: 2rem; font-weight: bold");

if(document.querySelector('#dropzone')){
    const dropzone = new Dropzone('#dropzone', {
        dictDefaultMessage: "Sube aqui tu imagen",
        acceptedFiles: ".png,.jpg,.jpeg,.gif",
        addRemoveLinks: true,
        dictRemoveFile: "Borrar Archivo",
        maxFiles: 1,
        uploadMultiple: false,

        // ! Nota: la ruta de la imagen la que pasa el profesor es correcta si lo utilisamos con "php artisan serve" o con Sail de docker
        // !       en este caso lo deje asi por que estoi usando xampp
        // ? Si se quiere trabajar bien con la ruta que da el profesor y con xampp hay que "Configurar hosts virtuales"
        //this.options.thumbnail.call(this, imagenPublicada, `/devstagram/public/uploads/${imagenPublicada.name}`); asi seria la ruta(no recomendable) con xampp sin configurar el host virtual

        init: function () {
            if (document.querySelector('[name="imagen"]').value.trim()) {
                const imagenPublicada = {};
                imagenPublicada.size = 1234;
                imagenPublicada.name = document.querySelector('[name="imagen"]').value;

                this.options.addedfile.call(this, imagenPublicada);
                this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`); // asi se puede trabajar con el servidor de laravel sin configurar

                imagenPublicada.previewElement.classList.add("dz-success","dz-complete");
            }
        }
    });
    // -*-*-*-*-*-*-*-*-*-*-*-* EVENTOS CON DROPZONE -*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-
    // Todos estos eventos se miran desde la consola del browser
    
    dropzone.on("success", function(file, response) {
        document.querySelector('[name="imagen"]').value = response.imagen;
    });
    
    dropzone.on('removedfile', function () {
        document.querySelector('[name="imagen"]').value = "";
    })
}


// console.log("Hecho en:\n %cME", "color:#00ff00; font-size: 2rem; font-weight: bold");
// console.log("%cXI", "color:#ffffff; font-size: 2rem; font-weight: bold");
// console.log("%cCO", "color:#ff0000; font-size: 2rem; font-weight: bold");