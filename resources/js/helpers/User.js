import Token from './Token';
import AppStorage from './AppStorage';

class User {
    login(form) {
        return axios.post('api/auth/login', form)
            .then(res => this.responseAfterLogin(res))
            .catch(err => err.response.data);
    }

    signup(form) {
        return axios.post('api/auth/signup', form)
            .then(res => this.responseAfterLogin(res))
            .catch(err => err.response.data);
    }

    responseAfterLogin(res) {
        const { access_token } = res.data;
        const { username } = res.data;

        if (Token.isValid(access_token)) {
            AppStorage.store(username, access_token);
            window.location = '/forum';
        }
    }

    hasToken() {
        const storedToken = AppStorage.getToken();
        if (storedToken) {
            return Token.isValid(storedToken) ? true : this.logout();
        }
        return false;
    }

    loggedIn() {
        return this.hasToken();
    }

    logout() {
        AppStorage.clear();
        window.location = '/';
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

    userIsOwner(id) {
        return this.id() == id;
    }

    isAdmin() {
        const adminIds = JSON.parse(process.env.MIX_ADMIN_IDS);
        return adminIds.indexOf(this.id()) !== -1;
    }
}

export default User = new User();