const getLoader = () => document.getElementById('fullscreenLoader')

export const showLoader = () => {
    const loader = getLoader();
    try {
        loader.classList.remove('d-none');
        setTimeout(() => {
            loader.classList.add('d-none');
        }, 5000);
    } catch (e) {
        loader.classList.add('d-none');
    }
}

export const hideLoader = () => {
    const loader = getLoader();
    loader.classList.add('d-none');
}
