export function getPayload(token) {
    return JSON.parse(atob(token.split('.')[1]));
}

export function isValidAccessToken(accessToken) {
    if (!accessToken || accessToken.split('.').length < 3) {
        return false;
    }

    const exp = new Date(getPayload(accessToken).exp * 1000); // JS deals with dates in milliseconds since epoch

    return new Date() < exp;
}