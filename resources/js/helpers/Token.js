class Token {
    isValid(token) {
        const payload = this.payload(token);
        return payload && (payload.iss === `${process.env.MIX_APP_URL}/api/auth/login` || payload.iss === `${process.env.MIX_APP_URL}/api/auth/signup`);
    }

    payload(token) {
        const payload = token.split('.')[1];
        return this.decode(payload);
    }

    decode(payload) {
         // atob function decodes a string of data which has been encoded using base-64 encoding
        return this.isBase64(payload) ? JSON.parse(atob(payload)) : false;
    }

    isBase64(str) {
        try {
            return btoa(atob(str)).replace(/=/g, '') === str; // btoa encodes a string to base-64 encoding
        } catch(err) {
            return false;
        }
    }
}

export default Token = new Token();
