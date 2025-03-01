export const updateQueryParams = (queryParams) => {
    const url = new URL(window.location);

    url.search = '';

    Object.entries(queryParams).forEach(([key, value]) => {
        if (value) {
            url.searchParams.set(key, value);
        } else {
            url.searchParams.delete(key);
        }
    });

    history.pushState({}, '', url);
}
