export const updateElementHtml = (id, content) => document.getElementById(id).innerHTML = content ?? '';

export const updateElementHref = (id, content) => document.getElementById(id).href = content ?? '';

export const generateDiv = () => {
    const item = document.createElement('div');
    item.style.textAlign = 'center';

    return item;
}

export const generateImg = (action) => {
    const img = document.createElement('img');
    img.src = action.iconPath;
    img.alt = action.name;
    img.style.width = '50px';

    return img;
}

export const generateText = (action) => {
    const text = document.createElement('div');
    text.textContent = action.name;

    return text;
}

export const appendImg = (action, item) => {
    const img = generateImg(action);
    item.appendChild(img);
}

export const appendText = (action, item) => {
    const text = generateText(action);
    item.appendChild(text);
}

export const showElement = (element) => {
    if (!element) return;

    element.classList.remove('hidden');
}

export const hideElement = (element) => {
    if (!element) return;

    element.classList.add('hidden');
}
