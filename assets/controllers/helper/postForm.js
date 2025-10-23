import axios from "axios";
import {updateQueryParams} from "./browserHelpers.js";
import {hideElement, showElement} from "./domManipulationHelper.js";

const makePostFormRequest = async (form, loader, action) => {
    try{
        const response = await axios(buildAxiosParams(form, action));
        updateQueryParams(response.data.queryParams);
        hideLoader(loader)

        return response.data.html;
    } catch (error) {
        hideLoader(loader)
    }
}

export const postForm = async (form, loader, action) => {
    try {
        showLoader(loader);
        return await makePostFormRequest(form, loader, action);
    } catch (error) {
        hideLoader(loader);

        return '';
    }
}

const buildAxiosParams = (form, action) => ({
    method: "post",
    url: action ? action : form.action,
    data: new FormData(form),
    headers: {
        "Content-Type": "multipart/form-data",
        "X-Requested-With": "XMLHttpRequest",
    },
});


const hideLoader = (loaderElement) => hideElement(loaderElement);

const showLoader = (loaderElement) => showElement(loaderElement);
