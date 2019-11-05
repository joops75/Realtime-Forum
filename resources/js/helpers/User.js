import Token from './Token';
import AppStorage from './AppStorage';
import { router } from '../router/router';

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
            router.push('/forum');
            EventBus.$emit('login');
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
        router.push('/forum');
        EventBus.$emit('logout');
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