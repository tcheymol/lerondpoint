export const updateElementHtml = (id, content) => document.getElementById(id).innerHTML = content ?? '';

export const updateElementHref = (id, content) => document.getElementById(id).href = content ?? '';

export const updateElementSrc = (id, content) => document.getElementById(id).src = content ?? '';

export const generateDiv = () => {
    const item = document.createElement('div');
    item.style.textAlign = 'center';

    return item;
}

export const generateList = (elements) => {
    const list = document.createElement('ul');

    elements.forEach(element => {
        const item = document.createElement('li');
        item.textContent = element;
        list.appendChild(item);
    })

    return list;
}

export const generateText = (action) => {
    const text = document.createElement('div');
    text.textContent = action.name;

    return text;
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
