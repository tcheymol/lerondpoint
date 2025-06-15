export const displayPreviewImage = (previewImageId, path) => {
        if (!previewImageId || !path) return;

        try {
            const previewImageElement = document.getElementById(previewImageId);
            previewImageElement.querySelector('img').src = path;
            previewImageElement.classList.remove('d-none');
        } catch (e) {
            console.error('Failed displaying preview image', e);
        }

}

export const fillFieldUrl = (fieldElementId, path) => {
    if (!fieldElementId || !path) return;

    try {
        const urlFieldElement = document.getElementById(fieldElementId);
        urlFieldElement.value = path;
    } catch (e) {
        console.error('Failed filling image url field', e);
    }
}
