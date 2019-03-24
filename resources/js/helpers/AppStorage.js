class AppStorage {
    storeToken(token) {
        localStorage.setItem('token', token);
    }

    storeUser(user) {
        localStorage.setItem('user', user);
    }

    storePermissionId(permission_id) {
        localStorage.setItem('permission_id', permission_id);
    }

    store(user, token, permission_id) {
        this.storeToken(token);
        this.storeUser(user);
        this.storePermissionId(permission_id);
    }

    clear() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
    }

    getToken() {
        return localStorage.getItem('token');
    }

    getUser() {
        return localStorage.getItem('user');
    }

    getPermissionId() {
        return localStorage.getItem('permission_id');
    }
}

export default AppStorage = new AppStorage();
