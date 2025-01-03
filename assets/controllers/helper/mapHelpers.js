export const fillAddressFields = (location, formName) => {
    const inputs = ['lat', 'lon', 'address_line1', 'address_line2', 'city', 'country', 'postcode', 'state'];
    inputs.forEach(input => {
        const inputElement = document.getElementById(`${formName}_${input}`);
        if (inputElement) {
            inputElement.value = location.properties[input];
        }
    });
}
