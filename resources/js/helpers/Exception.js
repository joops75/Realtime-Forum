import User from './User';

class Exception {
    handle(err) {
        this.isExpired(err.response.data);
    }

    isExpired({ error }) {
        if (error && error.slice(0, 5) === 'Token') {
            User.logout();
        }
    }
}

export default Exception = new Exception();