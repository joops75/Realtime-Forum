import Token from './Token';
import AppStorage from './AppStorage';

class User {
    login(form) {
        axios.post('api/auth/login', form)
            .then(res => this.responseAfterLogin(res))
            .catch(err => console.log(err.response.data));
    }

    responseAfterLogin(res) {
        const { access_token } = res.data;
        const { username } = res.data;

        if (Token.isValid(access_token)) {
            AppStorage.store(username, access_token);
        }
    }

    hasToken() {
        const storedToken = AppStorage.getToken();
        return storedToken && Token.isValid(storedToken);
    }

    loggedIn() {
        return this.hasToken();
    }

    logout() {
        AppStorage.clear();
    }

    name() {
        if (this.loggedIn()) {
            return AppStorage.getUsername();
        }
    }

    id() {
        if (this.loggedIn()) {
            return Token.payload(AppStorage.getToken()).sub;
        }
    }
}

export default User = new User();