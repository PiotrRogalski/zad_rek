import Token from './Token'
import AppStorage from './AppStorage'
import Permissions from '../constants'

class User {
    login(form) {
        axios.post('/api/auth/login', form)
            .then(res => this.handleLoginResponse(res))
            .catch(error => console.log(error.response.data))
    }

    handleLoginResponse(response) {
        const access_token = response.data.access_token;
        const username = response.data.user;
        const permission_id = response.data.permission_id;

        if (Token.isValid(access_token)) {
            AppStorage.store(username, access_token, permission_id);
            window.location = '/new-task';
            return true;
        }

        return false;
    }

    hasToken() {
        const storedToken = AppStorage.getToken();

        if (storedToken) {
            return Token.isValid(storedToken);
        }

        return false;
    }

    hasTokenExpired() {
        if (this.isLogged()) {
            const token = AppStorage.getToken();
            const payload = Token.payload(token);
            const exp = payload.exp;
            const now = Date.now() / 1000;

            console.log('In ' + Math.round((exp - now) / 60) + ' min. token expire');

            if (exp < now) {
                console.log('Expired!');
                return true;
            }
        } else {
            console.log('You are not logged!')
        }
        return false;
    }

    logoutIfTokenExp() {
        if (this.hasTokenExpired()) {
            this.logout();
        }
    }

    isLogged() {
        return this.hasToken();
    }

    isManager() {
        return this.isLogged() && AppStorage.getPermissionId() == Permissions.MANAGER;
    }

    isWorker() {
        return this.isLogged() && AppStorage.getPermissionId() == Permissions.EMPLOYEE;
    }

    logout() {
        AppStorage.clear();
        window.location = '/';
        return true;
    }

    name() {
        return this.isLogged() ? AppStorage.getUser() : false;
    }

    id() {
        if (this.isLogged()) {
            const payload = Token.payload(AppStorage.getToken());
            return payload.sub;
        }

        return false;
    }

    //checking if the id is equal to logged user
    own(id) {
        return this.id() === id;
    }

    admin() {
        return this.id() === 1;
    }
}

export default User = new User();
