class AppStorage {
    storeToken(token) {
        localStorage.setItem('token', token);
    }

    storeusername(username) {
        localStorage.setItem('username', username);
    }

    store(username, token) {
        this.storeusername(username);
        this.storeToken(token);
    }

    clear() {
        localStorage.removeItem('token');
        localStorage.removeItem('username');
    }

    getToken() {
        return localStorage.getItem('token');
    }

    getUsername() {
        return localStorage.getItem('username');
    }
}

export default AppStorage = new AppStorage();
