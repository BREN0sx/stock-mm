document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    function isImage(file) {
        return file.type.startsWith('image/');
    }

    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
            const file = inputElement.files[0];
            if (file.size > 1024 * 1024) {
                alert("O arquivo é maior do que 1 MB. Por favor, selecione um arquivo menor.");
                inputElement.value = '';
            } else if (isImage(file)) {
                updateThumbnail(dropZoneElement, file);
            } else {
                alert("Por favor, selecione um arquivo de imagem.");
            }
        }
    });

    dropZoneElement.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    dropZoneElement.addEventListener("drop", (e) => {
        e.preventDefault();

        if (e.dataTransfer.files.length) {
            const file = e.dataTransfer.files[0];
            if (file.size > 1024 * 1024) {
                alert("O arquivo é maior do que 1 MB. Por favor, selecione um arquivo menor.");
            } else if (isImage(file)) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnail(dropZoneElement, file);
            } else {
                alert("Por favor, selecione um arquivo de imagem.");
            }
        }

        dropZoneElement.classList.remove("drop-zone--over");
    });
});

function updateThumbnail(dropZoneElement, file) {
	let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    if (dropZoneElement.querySelector('.drop-zone__thumb')) dropZoneElement.querySelector('.drop-zone__thumb').style.cssText = 'display: block;';
	if (dropZoneElement.querySelector(".drop-zone__prompt")) dropZoneElement.querySelector(".drop-zone__prompt").style.cssText = 'display: none;';
    if (dropZoneElement.querySelector(".drop-zone__prompt.support")) dropZoneElement.querySelector(".drop-zone__prompt.support").style.cssText = 'display: none;';
    if (dropZoneElement.querySelector(".drop-zone__prompt.editor-viewer")) dropZoneElement.querySelector(".drop-zone__prompt.editor-viewer").style.cssText = 'display: none;';

	if (!thumbnailElement) {
		thumbnailElement = document.createElement("div");
		thumbnailElement.classList.add("drop-zone__thumb");
		dropZoneElement.appendChild(thumbnailElement);
	}

	thumbnailElement.dataset.label = file.name;

	if (file.type.startsWith("image/")) {
		const reader = new FileReader();

		reader.readAsDataURL(file);
		reader.onload = () => {
			thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
		};
	} else {
		thumbnailElement.style.backgroundImage = null;
	}
}