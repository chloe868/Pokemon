import axios from 'axios'
import ROUTER from '../../router'
export default {
    url: 'http://localhost:8000/',
    token: localStorage.getItem('userToken'),
    userId: localStorage.getItem('userId'),
    config: {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('userToken')
        }
    },
    setToken(token) {
        this.token = token
        localStorage.setItem('userToken', token)
        if (token) {
            setTimeout(() => {
                axios({
                    method: 'post',
                    url: this.url + 'tokenRefresh',
                    headers: {
                      Authorization: 'Bearer ' + token
                    }
                }).then(response => {
                    this.setToken(response.data.access_token)
                }).catch(err => {
                    this.deauthenticate()
                })
            }, 1000 * 60 * 60) // 50min
        }
    },
    deauthenticate(){
        axios({
            method: 'post',
            url: this.url + 'logout',
            headers: {
              Authorization: 'Bearer ' + this.token
            }
        }).then(res => {
            console.log('logout', res);
            if(res.data.token === null){
                localStorage.removeItem('userToken')
                localStorage.removeItem('userId')
                this.token = null
                this.userId = null
                ROUTER.go('/login')
            }
        })
    }
}