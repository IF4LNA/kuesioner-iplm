document.addEventListener("DOMContentLoaded", function () {
    let fotoInput = document.getElementById("foto");
    let labelFoto = document.querySelector(".custom-file-label");
    let preview = document.getElementById("preview");

    fotoInput.addEventListener("change", function () {
        let file = this.files[0];
        if (file) {
            labelFoto.innerHTML = '<i class="fas fa-upload"></i> ' + file.name;
            let reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
