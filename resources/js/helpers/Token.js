class Token {

    isValid(token) {
        // Here is the place for token validation, i.e. ISS token part (ISS stands for address of the issuer).
        return true;
    }

    payload(token) {
        const payload = token.split('.')[1];
        return this.decode(payload);
    }

    decode(payload) {
        return JSON.parse(atob(payload));
    }
}

export default Token = new Token();
