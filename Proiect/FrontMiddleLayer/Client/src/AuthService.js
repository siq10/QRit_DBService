import axios from "axios";

const url = 'api/auths';

class AuthService {
    //post
    static postAuth(credentials) {
        return axios.post(url,credentials)
    }

}

export default UsersService