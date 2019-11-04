class Token {
    isValid(token) {
        const payload = this.payload(token);
        return payload && (payload.iss === `${process.env.MIX_APP_URL}/api/auth/login` || payload.iss === `${process.env.MIX_APP_URL}/api/auth/register`);
    }

    payload(token) {
        const payload = token.split('.')[1];
        return this.decode(payload);
    }

    decode(payload) {
        return JSON.parse(atob(payload)); // atob function decodes a string of data which has been encoded using base-64 encoding
    }
}

export default Token = new Token();
