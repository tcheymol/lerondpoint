const showCaptcha = () => {
    // const container = document.getElementById('captcha_container');
    // if (container) {
    //     container.classList.remove('d-none');
    // }
}

export const hideImageContainer = () => {
    showCaptcha()
    const container = document.getElementById('upload_files_container');
    if (container) {
        container.classList.add('d-none');
    }
}
export const hideVideoContainer = () => {
    showCaptcha();
    const container = document.getElementById('copy_video_url_container');
    if (container) {
        container.classList.add('d-none');
    }
}
